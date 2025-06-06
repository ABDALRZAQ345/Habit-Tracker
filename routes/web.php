<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// Route::get('/auth/google', function () {
//    return Socialite::driver('google')->redirect();
// })->name('auth.google');
//
// Route::get('/auth/google/callback', function () {
//    $googleUser = Socialite::driver('google')->stateless()->user();
//
//    $user = User::updateOrCreate([
//        'google_id' => $googleUser->id,
//    ], [
//        'name' => $googleUser->name,
//
//        'email' => $googleUser->email,
//        'password' => Hash::make(str()->random(24)),
//    ]);
//
//    Auth::login($user);
//
//    return redirect('/');
// });
Route::get('/', function () {
    return view('main');
})->middleware(['locale', 'throttle:api', 'xss']);
