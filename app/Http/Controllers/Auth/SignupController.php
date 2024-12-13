<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignupController extends Controller
{
    public function showSignupForm()
    {
        return view('auth.signup');
    }
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:member,organizer',
            'studentid' => 'nullable|string|unique:users,studentid',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'photo' => 'nullable|image|max:2048',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $photoFilename = 'defaultpfp.png';
        if ($request->hasFile('photo')) {
            $photoFile = $request->file('photo');
            $photoFilename = $photoFile->getClientOriginalName(); 
            $photoFile->move(public_path('profile-imgs'), $photoFilename);
        }

        DB::table('users')->insert([
            'type' => $request->input('type', 'member'),
            'studentid' => $request->input('studentid'),
            'firstname' => $request->input('firstname'),
            'middlename' => $request->input('middlename'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'photo' => $photoFilename,
            'password' => Hash::make($request->input('password')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('signin')->with('success', 'Account created successfully.');
    }
}
