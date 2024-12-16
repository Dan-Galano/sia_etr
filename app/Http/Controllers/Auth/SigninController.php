<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;


class SigninController extends Controller
{
    public function showLanding()
    {
        return view('landing');
    }
    public function showSigninForm()
    {
        return view('auth.signin');
    }

    public function signin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            Session::start();
            Session::put('user', $user);
            if ($user->type === 'organizer') {
                return redirect()->route('organizer-home');
            } else if($user->type === 'member'){
                return redirect()->route('member-home');
            } else{
                return redirect()->route('admin-home');
            }
        }
        return redirect()->back()->withInput()->withErrors(['message' => 'Invalid email or password']);
    }

     
}
