<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MatchController extends Controller
{
    public function index()
    {
        $users = UserResource::collection(User::with(['skills', 'seekingSkills'])->limit(10)->get())->resolve(); // Получите всех пользователей из базы данных
        return Inertia::render('Dashboard', ['users' => $users]); // Верните компонент Deck с данными пользователей
    }
}
