<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PoliticalParty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartyController extends Controller
{
    public function pendingParties()
    {
        if (!auth()->user()->isNebe()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $parties = User::with('politicalParty')
            ->where('type', 'party')
            ->where('is_approved', false)
            ->get();

        return response()->json($parties);
    }

    public function approveParty($id)
    {
        if (!auth()->user()->isNebe()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $party = User::findOrFail($id);
        $party->update(['is_approved' => true]);
        $party->save();

        return response()->json(['message' => 'Party approved successfully']);
    }

    public function rejectParty($id)
    {
        if (!auth()->user()->isNebe()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $party = User::findOrFail($id);
        $party->delete();

        return response()->json(['message' => 'Party rejected and deleted']);
    }

    public function index()
    {
        $parties = User::with('politicalParty')
            ->where('type', 'party')
            ->where('is_approved', true)
            ->get();

        return response()->json($parties);
    }

    // -------------------------------
    // 🎯 Party Profile Management
    // -------------------------------

    public function showProfile()
    {
        $user = Auth::user();

        $party = PoliticalParty::where('user_id', $user->id)->first();

        if (!$party) {
            return response()->json(['message' => 'Party profile not found.'], 404);
        }

        return response()->json($party);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $party = PoliticalParty::where('user_id', $user->id)->first();

        if (!$party) {
            return response()->json(['message' => 'Party profile not found.'], 404);
        }

        $validated = $request->validate([
            'party_name' => 'string|max:255',
            'party_acronym' => 'string|max:50',
            'registration_number' => 'string|max:100',
            'certificate_url' => 'url|nullable',
            'logo_url' => 'url|nullable',
            'president_name' => 'string|max:255',
            'president_photo_url' => 'url|nullable',
            'contact_phone' => 'string|max:20',
            'contact_email' => 'email|max:255',
            'headquarters_address' => 'string|max:255',
            'facebook_url' => 'url|nullable',
            'twitter_url' => 'url|nullable',
            'founded_year' => 'integer|nullable',
            'slogan' => 'string|nullable|max:255',
        ]);

        $party->update($validated);

        return response()->json([
            'message' => 'Profile updated successfully',
            'party' => $party,
        ]);
    }

}
