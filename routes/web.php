<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\Match\MatchController;
use App\Http\Controllers\Match\MyMatchesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [MatchController::class, 'index'])->name('matches.index');
    Route::get('/more-users', [MatchController::class, 'getMoreUsers'])->name('matches.more');
    Route::post('/', [MatchController::class, 'store'])->name('matches.store');

    Route::get('/my-matches/{status}/{match?}', [MyMatchesController::class, 'index'])->name('my-matches.index');
    Route::post('/my-matches/{match}/accept', [MyMatchesController::class, 'acceptMatch'])->name('my-matches.accept');
    Route::post('/my-matches/{match}/reject', [MyMatchesController::class, 'rejectMatch'])->name('my-matches.reject');
    Route::post('/my-matches/{match}/cancel', [MyMatchesController::class, 'undoStatus'])->name('my-matches.cancel');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [ChatController::class, 'chat'])->name('chat.chat');
    Route::post('/chat/{user}', [ChatController::class, 'storeMessage'])->name('chat.store');
    Route::post('/chat/message/{message}/read', [ChatController::class, 'markAsRead'])->name('chat.markAsRead');

});

require __DIR__.'/auth.php';
