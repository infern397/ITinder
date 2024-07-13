<?php

namespace App\Http\Controllers\Match;

use App\Events\NewMatch;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserMatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MatchController extends Controller
{
    public function index()
    {
        $users = $this->getUsers();
        return Inertia::render('Dashboard', ['users' => $users]);
    }

    public function getMoreUsers()
    {
        $users = $this->getUsers();
        return Redirect::back()->with('newUsers', $users);
    }

    public function store(Request $request)
    {
        UserMatch::create([
            'user_id' => $request->user()->id,
            'matched_user_id' => $request->matched_user_id,
        ]);

        $receiver = User::findOrFail($request->matched_user_id);
        broadcast(new NewMatch($receiver));

        return Redirect::back()->with('message', 'Match successfully created');
    }

    private function getUsers()
    {
        $matchedUserIds = UserMatch::query()->where('user_id', Auth::user()->id)->pluck('matched_user_id');

        return UserResource::collection(
            User::query()
                ->whereNotIn('id', $matchedUserIds)
                ->where('id', '!=', Auth::user()->id) // Исключаем текущего пользователя
                ->inRandomOrder()
                ->limit(5)
                ->get()
        )->resolve();
    }
}
