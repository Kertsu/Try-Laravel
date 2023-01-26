<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Attempting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\User;

class UserController extends Controller
{

    // show register/create form
    public function create()
    {
        return view('users.register');
    }


    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'password' => 'required|confirmed|min:6',
            'email' => ['required', 'email', Rule::unique('users', 'email')]
        ]);

        // hash password
        $formFields['password'] = bcrypt($formFields['password']);

        // create user
        $user = User::create($formFields);

        // login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in!');
    }

    // logout user
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out');
    }

    // show login form
    public function login(Request $request)
    {
        return view('users.login');
    }

    // login user
    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'password' => 'required',
            'email' => ['required', 'email']
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
            return redirect('/')->with('message', 'Logged in successfully!');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
