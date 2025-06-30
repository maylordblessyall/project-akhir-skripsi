<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User; 

class LogoutController extends Controller
{

    public function logout(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($user) {
            Log::info('Logout successful', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->getRole(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Successfully logged out.');
    }
}