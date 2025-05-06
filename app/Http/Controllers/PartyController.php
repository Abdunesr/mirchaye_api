<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function pendingParties()
    {
        // Only NEBE can access this
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
        // Only NEBE can access this
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
        // Only NEBE can access this
        if (!auth()->user()->isNebe()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $party = User::findOrFail($id);
        $party->delete(); // Or you might want to soft delete

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
}