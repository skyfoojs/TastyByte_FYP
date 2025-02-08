<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('waiter.login');
    }

    function loginPost(Request $request) {
        $request->validate([
            "email" => "required",
            "password" => "required",
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Get the authenticated user
            $user = Auth::user();

            // Store user details in the session
            session([
                'username' => $user->username,
                'userID' => $user->userID,
            ]);

            // Check the user's role and redirect accordingly
            if ($user->role === 'Waiter') {
                return redirect()->intended(route('menu'));
            } elseif ($user->role === 'Admin') {
                return redirect()->route('admin-users');
            } elseif ($user->role === 'cashier') {
                return redirect()->route('cashier-menu');
            } else {
                // Logout the user if their role is not valid for redirection
                Auth::logout();
                return redirect()->route('login')->with('error', 'Unauthorized access.');
            }
        }

        return redirect()->route('login')->with('error', 'Unsuccessful login. Incorrect credentials.');
    }
}
