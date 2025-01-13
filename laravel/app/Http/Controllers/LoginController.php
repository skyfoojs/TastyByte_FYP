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

        if(Auth::attempt($credentials)) {
            return redirect()->intended(route('menu'));
        }

        return redirect(route('login'))->with('error', 'Login details are invalid.');
    }
}
