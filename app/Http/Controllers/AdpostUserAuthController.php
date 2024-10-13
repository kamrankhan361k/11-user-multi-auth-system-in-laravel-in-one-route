<?php


namespace App\Http\Controllers;

use App\Models\AdpostUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdpostUserAuthController extends Controller
{
    /**
     * Show the AdpostUser login form.
     */
    public function showLoginForm()
    {
        return view('adpostuser.login');
    }

    /**
     * Handle AdpostUser login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        // Use Auth guard for AdpostUser
        if (Auth::guard('adpostuser')->attempt($credentials)) {
            return redirect()->route('adpostuser.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    /**
     * Show the AdpostUser registration form.
     */
    public function showRegisterForm()
    {
        return view('adpostuser.register');
    }

    /**
     * Handle AdpostUser registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:adpost_users',
            'password' => 'required|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);

        AdpostUser::create($data);

        return redirect()->route('adpostuser.login')->with('success', 'Registration successful, please login.');
    }

    /**
     * Handle AdpostUser logout request.
     */
    public function logout()
    {
        Auth::guard('adpostuser')->logout();
        return redirect()->route('adpostuser.login');
    }

    /**
     * Show the AdpostUser dashboard (protected route).
     */
    public function dashboard()
    {
        return view('adpostuser.dashboard');
    }
}
