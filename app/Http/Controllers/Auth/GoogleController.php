<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;
use Throwable;

class GoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('login')
                ->withErrors(['google' => __('ui.auth.google_failed')]);
        }

        $user = User::where('google_id', $googleUser->getId())->first()
            ?? User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            $user->fill([
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);

            if (is_null($user->email_verified_at)) {
                $user->forceFill(['email_verified_at' => now()]);
            }

            $user->save();
        } else {
            $user = User::create([
                'name' => $googleUser->getName() ?: 'Pengguna Google',
                'email' => $googleUser->getEmail(),
                'password' => Str::random(32),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
            ]);

            $user->forceFill(['email_verified_at' => now()])->save();

            $user->assignRole(Role::findOrCreate('warga', 'web'));
        }

        Auth::login($user, remember: true);

        return redirect()->intended(route('dashboard'));
    }
}
