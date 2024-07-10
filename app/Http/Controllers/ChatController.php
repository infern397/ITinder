<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use App\Models\User;
use App\Models\UserMatch;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ChatController extends Controller
{
    public function index(Request $request, User $user)
    {
        $users = $request->user()
            ->acceptedUserMatches()->get()
            ->merge($request->user()->acceptedMatchedUsers);

        return Inertia::render('Chat/Index', [
            'users' => $users,
        ]);
    }

    public function chat(Request $request, User $user)
    {
        $messages = Message::query()
            ->where(function ($query) use ($request, $user) {
                $query->where('sender_id', $request->user()->id)
                    ->where('receiver_id', $user->id);
            })
            ->orWhere(function ($query) use ($request, $user) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $request->user()->id);
            })
            ->get();

        return Inertia::render('Chat/Chat', ['messages' => $messages, 'user' => $request->user(), 'receiver' => $user]);
    }

    public function storeMessage(StoreMessageRequest $request, User $user)
    {
        $data = $request->validated();

        $message = Message::create($data);

//        broadcast(new MessageSent($message));

        return redirect()->back();
    }
}
