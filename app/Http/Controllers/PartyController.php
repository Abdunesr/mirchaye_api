<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PoliticalParty;
use Illuminate\Support\Facades\Storage;
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
        if (empty($request->all())) {
            return response()->json([
                'error' => 'Empty request data',
                'headers_received' => $request->headers->all(),
                'content_type' => $request->headers->get('Content-Type')
            ], 400);
        }

        $user = Auth::user();
        $party = PoliticalParty::where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'party_name' => 'sometimes|string|max:255',
            'party_acronym' => 'sometimes|string|max:20',
            'registration_number' => 'sometimes|string|max:50',
            'president_name' => 'sometimes|string|max:100',
            'contact_phone' => 'sometimes|string|max:20',
            'contact_email' => 'sometimes|email|max:255',
            'headquarters_address' => 'sometimes|string|max:255',
            'facebook_url' => 'sometimes|url',
            'twitter_url' => 'sometimes|url',
            'founded_year' => 'sometimes|integer|min:1800|max:' . date('Y'),
            'slogan' => 'sometimes|string|max:255',
            'certificate' => 'sometimes|file|mimes:pdf|max:2048',
            'logo' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
            'president_photo' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $updateData = [];

        foreach ([
            'party_name',
            'party_acronym',
            'registration_number',
            'president_name',
            'contact_phone',
            'contact_email',
            'headquarters_address',
            'facebook_url',
            'twitter_url',
            'founded_year',
            'slogan'
        ] as $field) {
            if ($request->has($field)) {
                $updateData[$field] = $validated[$field];
            }
        }

        $fileFields = [
            'certificate' => 'certificate_url',
            'logo' => 'logo_url',
            'president_photo' => 'president_photo_url'
        ];

        foreach ($fileFields as $requestField => $dbField) {
            if ($request->hasFile($requestField)) {
                if ($party->{$dbField}) {
                    Storage::disk('public')->delete($party->{$dbField});
                }

                $file = $request->file($requestField);
                if ($file && !is_array($file) && $file->isValid()) {
                    $file = $request->file($requestField);
                    if ($file && !is_array($file) && $file->isValid()) {
                        $updateData[$dbField] = $file->store(
                            "party/{$requestField}s",
                            'public'
                        );
                    }
                }
            }
        }

        $party->update($updateData);

        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => $updateData,
            'party' => $party->fresh()
        ]);
    }
}
