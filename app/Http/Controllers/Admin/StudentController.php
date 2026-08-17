<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         $students = Student::latest()->get();

    return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

         $students = Student::latest()->get();
         
        return view('admin.students.create', compact('students'));
        
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|unique:users,student_id',
            'firstname'  => 'required',
            'lastname'   => 'required',
            'email'      => 'required|email|unique:users,email',
            'course'     => 'required',
            'year_level' => 'required|integer',
            'password'   => 'required|min:8|confirmed',
        ]);

        // Use Transaction to ensure both records are created or neither
        DB::transaction(function () use ($request) {
            
            // 1. Create Login Account
            User::create([
                'student_id' => $request->student_id,
                'firstname'  => $request->firstname,
                'lastname'   => $request->lastname,
                'middlename' => $request->middlename,
                'email'      => $request->email,
                'course'     => $request->course,
                'year_level' => $request->year_level,
                'role'       => 'student',
                'isActive'   => true,
                'password'   => Hash::make($request->password),
            ]);

            // 2. Create Student Record (For library transactions)
            Student::create([
                'student_id' => $request->student_id,
                'firstname'  => $request->firstname,
                'lastname'   => $request->lastname,
                'middlename' => $request->middlename,
                'email'      => $request->email,
                'course'     => $request->course,
                'year_level' => $request->year_level,
            ]);

            // 3. Log the Activity (Moved inside transaction)
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Registered Student',
                'description' => "Added {$request->firstname} {$request->lastname} ({$request->student_id})",
            ]);
        }); // <--- THIS WAS MISSING (The closing brace and parenthesis)

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Fetch the student AND eager load their transactions + books in one query
        $student =Student::findOrFail($id);

        // Only pass '$student'. The view accesses history via $student->transactions
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
         $student = Student::findOrFail($id);
        return view('admin.students.edit', compact('student'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $student = Student::findOrFail($id);

        $validatedData = $request->validate([
            'student_id' => 'required|unique:students,student_id,' . $student->id . '|string|max:50',
            'lastname' => 'required|string|max:100',
            'firstname' => 'required|string|max:100',
            'middlename' => 'nullable|string|max:100',
            'email' => 'required|email|unique:students,email,' . $student->id . '|max:255',
            'course' => 'required|string|max:100',
            'year_level' => 'required|integer|min:1|max:6',
        ]);

         $student->update($validatedData);

         ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Edited Student',
            'description' => "Updated details for student {$student->firstname} {$student->lastname}",
        ]);
         return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');

        //return update for admin student
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}
