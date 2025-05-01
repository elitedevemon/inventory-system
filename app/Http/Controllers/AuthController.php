<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    // Validate the request data
    $validator = Validator::make($request->all(), [
      'email' => ['required', 'email'],
      'password' => ['required', 'string'],
    ]);

    // If validation fails, redirect back with errors
    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    // Attempt to login the user
    if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
      return redirect()->intended(route('dashboard.index')); // Redirect to the dashboard
    }

    // Authentication failed
    return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
  }

  public function logout(Request $request)
  {
    Auth::logout();
    return redirect()->route('login');
  }
}
