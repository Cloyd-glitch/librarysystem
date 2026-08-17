<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // Statistics
        $stats = [
            'total_books' => Book::count(),
            'available_books' => Book::where('isActive', true)->count(),
            'total_students' => Student::count(),
            'total_categories' => Category::where('isActive', true)->count(),
            'borrowed_books' => Transaction::whereNull('date_returned')->count(),
            'overdue_books' => Transaction::whereNull('date_returned')
                ->where('due_date', '<', now())
                ->count(),
            'returned_books' => Transaction::whereNotNull('date_returned')->count(),
            'total_transactions' => Transaction::count(),
        ];

        // Recent transactions
        $recentTransactions = Transaction::with(['student', 'book'])
            ->latest()
            ->take(10)
            ->get();

        // Most borrowed books
        $mostBorrowedBooks = Book::withCount('transactions')
            ->orderBy('transactions_count', 'desc')
            ->take(5)
            ->get();

        // Most active students
        $mostActiveStudents = Student::withCount('transactions')
            ->orderBy('transactions_count', 'desc')
            ->take(5)
            ->get();

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(6) // Limit to 6 items
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentTransactions',
            'mostBorrowedBooks',
            'mostActiveStudents',
            'recentActivities'
        ));
    }
}