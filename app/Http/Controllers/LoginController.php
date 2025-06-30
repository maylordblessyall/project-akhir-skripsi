<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        Log::info('Login attempt', ['email' => $request->email]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            /** @var \App\Models\User $user */
            $user = Auth::user();

            Log::info('Login successful', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->getRole(),
            ]);

            $dashboardUrl = $this->getDashboardUrl($user);

            return redirect()->intended($dashboardUrl);
        }

        Log::warning('Login failed', ['email' => $request->email]);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    private function getDashboardUrl($user)
    {
        /** @var \App\Models\User $user */
        $role = $user->getRole();
    
        switch ($role) {
            case 'Doctor':
                return route('doctors.dashboard');
            case 'Admin':
                return route('admin.dashboard');
            case 'Registration Staff':
                return route('registrationstaff.dashboard');
            case 'Nurse':
                return route('nurse.dashboard');
            case 'Hospital Manager':
                return route('manager.dashboard');
            default:
                \Illuminate\Support\Facades\Log::warning('Unknown role detected', ['user_id' => $user->id, 'role' => $role]);
                return route('dashboard'); 
        }
    }

    
}