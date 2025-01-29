<?php

namespace App\Http\Controllers;

use App\Mail\Mail2FA;
use App\Models\User;
use App\Rules\ReCaptcha;
use App\Rules\Valid2FACode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('login');
    }

    /**
     * Show the 2FA form.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function create2FA(int $id)
    {
        return view('2fa', ['id' => $id]);
    }

    /**
     * Handle the login request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'g-recaptcha-response' => ['required', new ReCaptcha()],
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password) && $user->status) {
            $code = rand(100000, 999999);
            try {
                Mail::to($request->email)->send(new Mail2FA($code));
            } catch (\Exception $e) {
                Log::error('Error sending the 2FA code', ['email' => $request->email, 'exception' => $e]);
                return redirect()->route('login')->with('error', 'Error sending the 2FA code.');
            }
            $user->code = Hash::make($code);
            $user->save();
            $signedRoute = URL::temporarySignedRoute(
                '2fa',
                now()->addMinutes(10),
                ['id' => $user->id]
            );
            Log::info('2FA code sent to ' . $request->email);
            return redirect($signedRoute);
        }
        Log::info('Invalid credentials', ['email' => $request->email]);
        return redirect()->route('login')->with('error', 'Invalid credentials');
    }

    /**
     * Verify the 2FA code.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify2FA(Request $request, int $id)
    {
        $request->validate([
            'code' => ['required', 'numeric', 'digits:6', new Valid2FACode($id)],
        ]);
        $user = User::find($id);
        if ($user) {
            Auth::login($user);
            Log::info('User logged in', ['user' => $user]);
            return redirect()->route('dashboard');
        }
    }
}