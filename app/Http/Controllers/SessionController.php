<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function store()
    {
        // Step 1: Validate the input
        $userCredentials = request()->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Step 2: Attempt to authenticate the user
        if (!Auth::attempt($userCredentials)) {
            // Return validation error if authentication fails
            throw ValidationException::withMessages([
                'err' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Step 3: Regenerate the session to prevent session fixation attacks
        request()->session()->regenerate();

        // Step 4: Get the authenticated user
        $user = Auth::user();

        // Step 5: Redirect based on user type (admin or sales)
        if ($user->admin) {
            return redirect('/dashboard'); // Redirect to admin dashboard
        } elseif ($user->sales) {
            return redirect('/my-project'); // Redirect to sales dashboard
        }

        // Default redirect if the user is neither admin nor sales
        return redirect('/login');
    }

    public function destroy(){
        Auth::logout();
        session()->flash('success', 'Log Out Successfully.');

        return redirect('/login');
    }
}
