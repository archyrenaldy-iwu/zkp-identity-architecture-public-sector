<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomEmailVerificationRequest extends Request
{
    /**
     * Fulfill the email verification request.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function fulfill()
    {
        Log::info('Route parameters', ['parameters' => $this->route()]);

        $userId = $this->route('id');
        $hash = $this->route('hash');

        if (! $userId) {
            Log::error('User ID is null', ['route_parameters' => $this->route()]);

            return redirect('/login')->withErrors('Invalid verification link. Please request a new one.');
        }

        $user = User::find($userId);

        if (! $user) {
            Log::error('User not found', ['user_id' => $userId]);

            return redirect('/login')->withErrors('User not found or session expired. Please log in and try again.');
        }

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            Log::error('Invalid hash for user verification', ['user_id' => $user->id]);

            return redirect('/login')->withErrors('Invalid verification link. Please request a new one.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/login')->with('message', 'Your email is already verified.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            Log::info('User email verified', ['user_id' => $user->id]);
        }

        return redirect('/login')->with('verified', true);
    }
}
