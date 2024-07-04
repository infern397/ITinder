<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $user = $request->user();

        $userSkillsIds = $user->skills ? $user->skills->pluck('id')->toArray() : [];
        $userSeekingSkillsIds = $user->seeking_skills ? $user->seeking_skills->pluck('id')->toArray() : [];

        $availableUserSkills = SkillResource::collection(
            Skill::query()->whereNotIn('id', $userSkillsIds)->get()
        )->resolve();

        $availableSeekingSkills = SkillResource::collection(
            Skill::query()->whereNotIn('id', $userSeekingSkillsIds)->get()
        )->resolve();

        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'availableUserSkills' => $availableUserSkills,
            'availableSeekingSkills' => $availableSeekingSkills
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($request->hasFile('profile_picture')) {

            $file = $request->file('profile_picture');

            $extension = $file->getClientOriginalExtension();

            $path = $file->storeAs('public/avatars', $user->id . '.' . $extension);;

            $user->profile_picture = Storage::url($path);
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
