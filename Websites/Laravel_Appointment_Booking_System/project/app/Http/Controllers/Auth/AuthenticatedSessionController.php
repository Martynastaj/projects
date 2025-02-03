<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle the login attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /** @var array<string, string> $credentials */
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]) ?? [];

        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
            // Regenerate session on successful login
            $request->session()->regenerate();

            // Check if the user is logged in and has the role
            $user = Auth::user();
            if ($user) {
                // Redirect based on the user's role
                if ($user->role === 'client') {
                    return redirect()->route('client.dashboard');
                } elseif ($user->role === 'provider') {
                    return redirect()->route('provider.dashboard');
                } elseif ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
            }
        }

        // If login fails, redirect back with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Log out the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        // Invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
