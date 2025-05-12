<?php

namespace App\Http\Controllers;

use App\Models\PoliticalParty;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
 public function register(Request $request)
{
    // Validate all input fields
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'party_name' => 'required|string|max:255|unique:political_parties,party_name',
        'party_acronym' => 'required|string|max:255|unique:political_parties,party_acronym',
        'president_name' => 'required|string|max:255',
        'registration_number' => 'required|string|max:255|unique:political_parties,registration_number',
        'description' => 'nullable|string',
        'certificate' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Check if party already exists (additional safety check)
    $existingParty = PoliticalParty::where('party_name', $validatedData['party_name'])
        ->orWhere('party_acronym', $validatedData['party_acronym'])
        ->orWhere('registration_number', $validatedData['registration_number'])
        ->first();

    if ($existingParty) {
        return response()->json([
            'message' => 'A party with similar details already exists. Please check party name, acronym, or registration number.',
        ], 422);
    }

    // Start database transaction for atomic operations
    DB::beginTransaction();

    try {
        // Create user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'type' => 'party',
            'is_approved' => false,
        ]);

        // Handle file uploads
        $certificatePath = $request->file('certificate')->store('party/certificates', 'public');
        $logoPath = $request->file('logo')->store('party/logos', 'public');

        // Create political party
        $partyData = [
            'party_name' => $validatedData['party_name'],
            'party_acronym' => $validatedData['party_acronym'],
            'president_name' => $validatedData['president_name'],
            'registration_number' => $validatedData['registration_number'],
            'description' => $validatedData['description'] ?? null,
            'certificate_url' => $certificatePath,
            'logo_url' => $logoPath,
            'user_id' => $user->id,
        ];

        $user->politicalParty()->create($partyData);

        // Commit transaction if all operations succeed
        DB::commit();

        return response()->json([
            'message' => 'Registration successful. Waiting for NEBE approval.',
            'user' => $user->load('politicalParty') // Eager load the party relationship
        ], 201);

    } catch (\Exception $e) {
        // Rollback transaction on error
        DB::rollBack();
        
        // Delete any uploaded files if transaction failed
        if (isset($certificatePath)) {
            Storage::disk('public')->delete($certificatePath);
        }
        if (isset($logoPath)) {
            Storage::disk('public')->delete($logoPath);
        }

        return response()->json([
            'message' => 'Registration failed. Please try again.',
            'error' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if ($user->isParty() && !$user->is_approved) {
            return response()->json(['message' => 'Your account is pending approval by NEBE'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user->load('politicalParty')
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}