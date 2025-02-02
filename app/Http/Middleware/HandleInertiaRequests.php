<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        $newMessagesAmount = 0;
        $newMatchesAmount = 0;

        $currentLocale = App::getLocale();
        $headerStrings = Lang::get('header');
        $matchesStrings = Lang::get('matches');
        $myMatchesStrings = Lang::get('myMatches');
        $myProfileStrings = Lang::get('profile');
        $myChatStrings = Lang::get('chat');
        $myTitleStrings = Lang::get('title');

        if ($user) {
            $newMessagesAmount = $user->unreadMessagesCountGropedByUsers();
            $newMatchesAmount = $user->newMatchesReceivedCount();
        }
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
            ],
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
            'currentLocale' => $currentLocale,
            'strings' => [
                'header' => $headerStrings,
                'matches' => $matchesStrings,
                'my-matches' => $myMatchesStrings,
                'profile' => $myProfileStrings,
                'chat' => $myChatStrings,
                'title' => $myTitleStrings,
                ],
            'newMessagesAmount' => $newMessagesAmount,
            'newMatchesAmount' => $newMatchesAmount,
        ];
    }
}
