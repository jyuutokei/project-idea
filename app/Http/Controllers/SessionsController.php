<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RateLimiter;

class SessionsController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $throttleKey = 'login:' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()
                ->withErrors(['password' => "Too may login attempts. Please try again in {$seconds} seconds."])
                ->withInput($request->except('password'));

        }

        $validated = $request->validate([
            'email' => ['required', 'email', 'string', 'max:255'],
            'password' => ['required', 'string']
        ]);

        if (!Auth::attempt($validated)) {
            RateLimiter::hit($throttleKey, 60);

            return back()
                ->withErrors(['password' => 'We were unable to authenticate using the provided credentials'])
                ->withInput($request->except('password'));
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();
        return redirect()->intended('/')->with('success', 'You are now logged in');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
