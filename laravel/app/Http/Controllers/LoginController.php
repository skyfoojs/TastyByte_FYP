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
    public function loginPost(Request $request) {
        $request->validate([
            "email_or_username" => "required", // Accepts email or username
            "password" => "required",
        ]);

        $loginField = filter_var($request->input('email_or_username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginField => $request->input('email_or_username'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            // Get the authenticated user
            $user = Auth::user();

            // Store user details in the session
            session([
                'username' => $user->username,
                'userID' => $user->userID,
            ]);

            // Check the user's role and redirect accordingly
            return match ($user->role) {
                'Waiter' => redirect()->intended(route('menu')),
                'Admin' => redirect()->route('admin-dashboard'),
                'Cashier' => redirect()->route('cashier.table'),
                'Kitchen' => redirect()->route('kitchen.index'),
                default => tap(Auth::logout(), fn () => redirect()->route('login')->with('error', 'Unauthorized access.')),
            };
        }

        return redirect()->route('login')->with('error', 'Unsuccessful login. Incorrect credentials.');
    }

    public function logout() {
        auth()->logout();
        session()->flush();

        return redirect()->route('login')->with('logoutSuccess', 'Logout Successfull！');
    }
}
