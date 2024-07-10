<?php
namespace App\Http\Controllers\Match;

use App\Http\Controllers\Controller;
use App\Models\UserMatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MyMatchesController extends Controller
{
    public function index($status = null, $matchId = null)
    {
        $user = Auth::user();
        $query = UserMatch::query()->where('matched_user_id', $user->id)->with('user');
        if ($status) {
            $query->where('status', $status);
        }

        $matches = $query->get();
        $selectedMatch = $matches->first();

        if ($matchId) {
            $selectedMatch = $matches->where('id', $matchId)->first();
        }

        return Inertia::render('Matches', [
            'matches' => $matches,
            'selectedMatch' => $selectedMatch,
            'currentStatus' => $status,
        ]);
    }

    public function acceptMatch(UserMatch $match)
    {
        $match->update(['status' => 'accepted']);
        return Redirect::back()->with('message', 'Match successfully accepted');
    }

    public function rejectMatch(UserMatch $match)
    {
        $match->update(['status' => 'rejected']);
        return Redirect::back()->with('message', 'Match successfully rejected');
    }

    public function undoStatus(UserMatch $match)
    {
        $match->update(['status' => 'pending']);
        return Redirect::back()->with('message', 'Match status successfully updated');
    }

}
