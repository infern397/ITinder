<?php

namespace App\Http\Controllers\Match;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MyMatchesController extends Controller
{
    public function index($matchId = null)
    {
        $user = Auth::user();
        $matches = UserMatch::query()->where('matched_user_id', $user->id)->with('user')->get();
        $selectedMatch = $matches->first();

        if ($matchId) {
            $selectedMatch = $matches->where('id', $matchId)->first();
        }

        return Inertia::render('Matches', [
            'matches' => $matches,
            'selectedMatch' => $selectedMatch,
        ]);
    }

    public function acceptMatch(UserMatch $match)
    {
        $match->update(['status' => 'accepted']);
        Redirect::back()
    }
}
