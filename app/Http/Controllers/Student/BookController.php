<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class BookController extends Controller  
{
    /**
     * Display a listing of available books (catalog)
     */
    public function index(Request $request)
    {
        $query = Book::with('category')
        ->where('isActive', true)
        ->whereHas('category', function($q) {
            $q->where('isActive', true);
        });
        
        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }
        
        // Filter by category
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }
        
        $books = $query->latest('date_added')->paginate(12);
        $categories = Category::where('isActive', true)->get();
        
        return view('student.books.index', compact('books', 'categories'));
    }

    /**
     * Display the specified book details
     */
    public function show(string $id)
    {
        $book = Book::with('category')->findOrFail($id);
        
        // Check if currently borrowed
        $isBorrowed = Transaction::where('book_id', $book->id)
            ->whereNull('date_returned')
            ->exists();
        
        return view('student.books.show', compact('book', 'isBorrowed'));
    }

    /**
     * Display user's currently borrowed books
     */ 
    /**
     * Display user's currently borrowed books
     */ 
    public function myBooks()
    {
        $user = Auth::user();
        
        //  Fetch Current Active Loans
        // Renamed from '$borrowedBooks' to '$currentTransactions' to match your View
        $currentTransactions = Transaction::with('book.category')
            ->where('student_id', $user->id)
            ->whereNull('date_returned')
            ->latest('date_borrowed') // Sort by newest borrow date
            ->get();
        
        //  Fetch Borrowing History (Returned Books)
        // Renamed from '$history' to '$historyTransactions' to match your View
        $historyTransactions = Transaction::with('book.category')
            ->where('student_id', $user->id)
            ->whereNotNull('date_returned')
            ->latest('date_returned') // Sort by newest return date
            ->get();
        
        //  Calculate Statistics for the Cards
        $activeLoans = $currentTransactions->count();
        
        $returnedLoans = $historyTransactions->count();
        
        // Filter the current transactions to find which ones are overdue
        $overdueLoans = $currentTransactions->filter(function ($transaction) {
            // Check if due date is in the past
            return \Carbon\Carbon::parse($transaction->due_date)->isPast();
        })->count();
        
        //  Return the view with ALL the required variables
        return view('student.my-books', compact(
            'currentTransactions', 
            'historyTransactions', 
            'activeLoans', 
            'overdueLoans', 
            'returnedLoans'
        ));
    }

    public function borrow(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $user = Auth::user();

        // 1. FIX: Find the correct Student Record first
        // We match them using the unique 'student_id' string (e.g., "2023-0001")
        $student = Student::where('student_id', $user->student_id)->first();

        // Safety check
        if (!$student) {
            return back()->with('error', 'Error: Student profile not found. Please contact the librarian.');
        }

        // 2. Check Availability
        if (!$book->isActive || $book->stock <= 0) {
            return back()->with('error', 'Sorry, this book is currently unavailable.');
        }

        // 3. Check for existing active loans using the STUDENT ID (not User ID)
        $existingLoan = Transaction::where('student_id', $student->id)
            ->where('book_id', $book->id)
            ->whereNull('date_returned')
            ->exists();

        if ($existingLoan) {
            return back()->with('error', 'You already have an active loan for this book.');
        }

        // 4. Create Transaction
        DB::transaction(function () use ($book, $student, $user) {
            $txn_no = 'TXN-' . strtoupper(uniqid());

            Transaction::create([
                'txn_no'        => $txn_no,
                'student_id'    => $student->id, // <--- USE $student->id HERE (Correct)
                'book_id'       => $book->id,
                'date_borrowed' => now(),
                'due_date'      => now()->addDays(7),
                'by'            => $user->firstname . ' ' . $user->lastname,
                'date_added'    => now(),
            ]);

            $book->decrement('stock');
        });

        // Redirect...
        return redirect()->route('student.books.receipt', Transaction::latest('id')->first()->txn_no)
            ->with('success', 'Book borrowed successfully!');
    }
    public function showReceipt($txn_no)
    {
        // Fetch transaction with relations
        $transaction = Transaction::with(['book', 'student'])
            ->where('txn_no', $txn_no)
            ->firstOrFail();

        // Security Check: Ensure the logged-in student owns this transaction
        if ($transaction->student->student_id !== Auth::user()->student_id) {
            abort(403, 'Unauthorized access to this receipt.');
        }

        return view('student.books.receipt', compact('transaction'));
    }
}