<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Student;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => ['required', 'string', 'max:50', 'unique:users,student_id'],
            'firstname' => ['required', 'string', 'max:100'],
            'lastname' => ['required', 'string', 'max:100'],
            'middlename' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'course' => ['required', 'string', 'max:100'],
            'year_level' => ['required', 'integer', 'min:1', 'max:6'],
            'password' => ['required', 'confirmed', Password::min(8)],
    ]);

        $user = User::create([
            'student_id' => $request->student_id,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
            'email' => $request->email,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'role' => 'student',
            'password' => Hash::make($request->password),
            'isActive' => true, 
        ]);

        Student::create([
            'student_id' => $request->student_id,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'middlename' => $request->middlename,
            'email' => $request->email,
            'course' => $request->course,
            'year_level' => $request->year_level,
        ]);



        event(new Registered($user));

        Auth::login($user);

         if ($user->isStaff()) {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome to the admin dashboard!');
        }

        return redirect()->route('student.dashboard')->with('success', 'Registration successful! Welcome to the Library System.');
    }
}