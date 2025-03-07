<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class AuthController extends Controller
{
    function loginIndex()
    {
        return Inertia::render('Login');
    }

    function login(Request $request)
    {
        // dd($request->boolean('remember'));
        // dd($request->headers->get('X-CSRF-TOKEN'), $request->cookie('XSRF-TOKEN'));
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->boolean('remember'))) {
            // return redirect()->route('dashboard');
            $user = Auth::user(); // Get the authenticated user
            return redirect()->route('admin.dashboard'); // Redirect to dashboard on successful login
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

    function adminIndex()
    {
        $admins = User::with('role')->get();
        $role = role::get();
        // dd($admins[0]->roles);
        // $roles = $admins->roles;
        // foreach ($admins as $admin) {
        //     $admins['role_name'] = $admin->roles->role; // Ambil properti 'role' dari setiap 'role' di 'roles'
        // }
        // dd($roles);
        return Inertia::render('admin/adminList', compact('admins', 'role'));
    }

    function Register(Request $request)
    {
        // dd($request);
        $input = $request->validate([
            'name' => 'required|string',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:4',
            'role' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $input['name'],
            'username' => $input['username'],
            'password' => bcrypt($input['password']),
            'role_id' => $input['role'],
        ]);

        return redirect()->route('admin.Admin')->with('success', 'create user successfully!');
    }

    function logout()
    {
        Auth::logout();
        return redirect()->route('login'); // Redirect to login
    }
}
