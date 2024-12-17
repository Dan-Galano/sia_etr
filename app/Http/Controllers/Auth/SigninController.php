<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\SchoolOrganization;


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

    // public function signin(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $user = User::where('email', $credentials['email'])->first();

    //     if ($user && Hash::check($credentials['password'], $user->password)) {
    //         Auth::login($user);
    //         Session::start();
    //         Session::put('user', $user);
    //         if ($user->type === 'organizer') {
    //             return redirect()->route('organizer-home');
    //         } else {
    //             return redirect()->route('member-home');
    //         }
    //     }
    //     return redirect()->back()->withInput()->withErrors(['message' => 'Invalid email or password']);
    // }

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

        if($user->type === 'admin'){
            return redirect()->route('admin-home');
        }

       else  if ($user->type === 'organizer') {
            // Fetch the first organization where the user is an admin
            $organization = SchoolOrganization::where('admin_id', $user->id)->first();

            if ($organization) {
                // Redirect to the organization's dashboard
                return redirect()->route('organization.show', ['id' => $organization->id]);
            }

            // If no organization is found, handle as appropriate
            return redirect()->route('organizer-home')->withErrors(['message' => 'No organization found for this organizer']);
        } else {
            return redirect()->route('member-home');
        }
    }

    return redirect()->back()->withInput()->withErrors(['message' => 'Invalid email or password']);
}


     
}
