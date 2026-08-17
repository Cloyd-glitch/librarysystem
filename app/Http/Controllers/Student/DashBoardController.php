<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard
     */
    public function index()
    {
        $user = Auth::user();

        $student = Student::where('student_id', $user->student_id)->first();

        if (!$student) {
            return view('student.dashboard', [
                'totalBorrowed' => 0,
                'currentlyBorrowed' => 0,
                'overdueBooks' => 0,
                'recentBorrowedBooks' => collect([]),
            ]);
        }
        
        // 1. Calculate Counts (Variables named exactly as the View expects)
        $totalBorrowed = Transaction::where('student_id', $student->id)->count();
        
        // "Currently Borrowed" Count
        $currentlyBorrowed = Transaction::where('student_id', $student->id)
            ->whereNull('date_returned')
            ->count();
            
        // "Overdue" Count
        $overdueBooks = Transaction::where('student_id', $student->id)
            ->whereNull('date_returned')
            ->where('due_date', '<', now())
            ->count();
        
        // 2. Get Data Lists
        // The View uses '$recentBorrowedBooks' for the "Currently Reading" section
        $recentBorrowedBooks = Transaction::with('book.category')
            ->where('student_id', $student->id)
            ->whereNull('date_returned')
            ->latest()
            ->simplePaginate(6);
        
        // 3. Pass data to the view
        return view('student.dashboard', compact(
            'totalBorrowed',
            'currentlyBorrowed', 
            'overdueBooks',
            'recentBorrowedBooks'
        ));
    }
}