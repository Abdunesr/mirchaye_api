<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'party_name' => 'required|string|max:255',
            'registration_number'=>'required|string|max:255',
            'president_name'=>'required|string|max:255',
            'party_acronym'=>'required|string|max:255',   
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 'party',
            'is_approved' => false, // Needs NEBE approval
        ]);

        $user->politicalParty()->create([
            'party_name' => $request->party_name,
            'party_acronym' => $request->party_acronym,
            'description' => $request->description,
            'president_name' => $request->president_name,
            'registration_number' => $request->registration_number,
        ]);

        return response()->json([
            'message' => 'Registration successful. Waiting for NEBE approval.',
            'user' => $user
        ], 201);
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