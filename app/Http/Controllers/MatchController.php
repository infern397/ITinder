<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MatchController extends Controller
{
    public function index(Request $request)
    {
        $matchedUserIds = UserMatch::query()->where('user_id', $request->user()->id)->pluck('matched_user_id');

        $users = UserResource::collection(
            User::with(['skills', 'seekingSkills'])
                ->whereNotIn('id', $matchedUserIds)
                ->limit(10)
                ->get()
        )->resolve();

        return Inertia::render('Dashboard', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $match = UserMatch::create([
            'user_id' => $request->user()->id,
            'matched_user_id' => $request->matched_user_id,
        ]);

        return Redirect::back()->with('message', 'Match successfully created');
    }
}
