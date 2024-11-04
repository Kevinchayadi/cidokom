<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class AuthController extends Controller
{
    function loginIndex() {
        return Inertia::render('Login');
        
    }

    function login(Request $request) {
        // dd($request->boolean('remember'));
        // dd($request->headers->get('X-CSRF-TOKEN'), $request->cookie('XSRF-TOKEN'));
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt(['username' => $request->username, 'password' => $request->password],  $request->boolean('remember'))) {
            // return redirect()->route('dashboard');
            return redirect()->route('user.dashboard');
        } else {
            return back()->withErrors(['error' => 'User data not found']);
        }
        if ($request->has('remember')) {
            // Jika remember me diaktifkan, set durasi session lebih lama
            config(['session.lifetime' => 20160]); // 2 minggu dalam menit
            config(['session.expire_on_close' => false]);
        } else {
            // Jika remember me tidak diaktifkan, set agar session expire saat browser ditutup
            config(['session.expire_on_close' => true]);
        }
        
    }
    
    function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}

