<?php

namespace App\Http\Controllers;

use App\Mail\MailActivation;
use App\Models\User;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('register');
    }

    /**
     * Handle the registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:30', 'regex:/^[a-zA-Z0-9\s]+$/'],
            'email' => ['required', 'email', 'unique:users', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'max:255', 'not_regex:/\s/', 'regex:/[@$!%*?&#]/'],
            'g-recaptcha-response' => ['required', new ReCaptcha()],
        ]);

        $signedRoute = URL::temporarySignedRoute(
            'active', now()->addMinutes(10),
            ['user' => $validated['email']]
        );

        try {
            Mail::to($request->email)->send(new MailActivation($signedRoute));
        } catch (\Exception $e) {
            return redirect()->route('register')->with('error', 'There was an error sending the activation email. Please try again.');
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Check your email to verify your account');
    }

    /**
     * Activate the user account.
     *
     * @param string $email
     * @return \Illuminate\Http\RedirectResponse
     */
    public function active($email)
    {
        $user = User::where('email', $email)->first();
        if ($user && !$user->status) {
            $user->status = true;
            $user->save();
            return redirect()->route('login')->with('success', 'Your account has been activated');
        }
        return redirect()->route('notfound');
    }
}