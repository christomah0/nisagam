<?php

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => ['required' | 'email'],
            'pasword' => ['required'],
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerate session for security
            $request->session()->regenerate();

            // Redirect to intended page
            return redirect()->intended('dashboard');
        }

        // If login fails, redirect back with error
        return back()
            ->withErrors(['email' => 'Les informations d\'identification fournies sont incorrectes.'])
            ->onlyInput('email');
    }
}
