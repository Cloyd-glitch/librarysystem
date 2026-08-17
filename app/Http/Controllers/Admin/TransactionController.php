<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of transactions.
     */
    public function index(Request $request)
    {
        // 1. Start the query with relationships
        $query = Transaction::with(['student', 'book.category']);

        // 2. Filter by Status
        if ($request->has('status')) {
            if ($request->status == 'borrowed') {
                // Borrowed = date_returned is NULL
                $query->whereNull('date_returned');
            } 
            elseif ($request->status == 'returned') {
                // Returned = date_returned is NOT NULL
                $query->whereNotNull('date_returned');
            }
        }

        // 3. Search Logic
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('txn_no', 'like', "%{$search}%")
                  ->orWhereHas('student', function($subQ) use ($search) {
                      $subQ->where('firstname', 'like', "%{$search}%")
                           ->orWhere('lastname', 'like', "%{$search}%");
                  })
                  ->orWhereHas('book', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // 4. Pagination (Sort by newest borrow date)
        $transactions = $query->latest('date_borrowed')->paginate(10);
        $transactions->appends($request->all());

        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        $students = Student::all();
        // Only show books that are Active and have Stock > 0
        $books = Book::where('isActive', true)->where('stock', '>', 0)->get();
        
        // FIX: You were missing 'books' in the compact function
        return view('admin.transactions.create', compact('students', 'books')); 
    }

    /**
     * Store a newly created transaction (Borrow Book).
     */
    public function store(Request $request)
    {
        // 1. Validate Input
        $request->validate([
            'student_id'    => 'required|exists:students,id',
            'book_id'       => 'required|exists:books,id',
            'due_date'      => 'required|date|after_or_equal:today',
        ]);

        $book = Book::findOrFail($request->book_id);
        $student = Student::findOrFail($request->student_id);

        // 2. Check Stock Availability
        if ($book->stock <= 0) {
            return back()->with('error', 'Error: This book is out of stock.');
        }

        // 3. Check for existing active loans for this user/book combo
        $exists = Transaction::where('student_id', $student->id)
            ->where('book_id', $book->id)
            ->whereNull('date_returned')
            ->exists();

        if ($exists) {
            return back()->with('error', 'Student already has an active loan for this book.');
        }

        // 4. Create Transaction & Decrease Stock (Database Transaction)
        DB::transaction(function () use ($request, $book, $student) {
            // Auto-generate Transaction Number
            $txn_no = 'TXN-' . strtoupper(uniqid());

            Transaction::create([
                'txn_no'        => $txn_no,
                'student_id'    => $student->id,
                'book_id'       => $book->id,
                'date_borrowed' => Carbon::now(),
                'date_added'    => Carbon::now(), // Record creation date
                'due_date'      => $request->due_date,
                'by'            => 'Admin', // Since admin is creating it
                'date_returned' => null,    // Explicitly null means "Borrowed"
            ]);

            // DECREASE STOCK
            $book->decrement('stock');
        });

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction created and book stock updated.');
    }

    /**
     * Display the specified transaction.
     */
    public function show(string $id)
    {
        $transaction = Transaction::with(['student', 'book.category'])->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing.
     */
    public function edit(string $id)
    {
        $transaction = Transaction::with(['student', 'book'])->findOrFail($id);
        return view('admin.transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource (Handle Returns & Edits).
     */
    public function update(Request $request, string $id)
    {
        $transaction = Transaction::findOrFail($id);

        if ($request->action == 'return') {
            
            if ($transaction->date_returned) {
                return back()->with('error', 'Book is already returned.');
            }

            DB::transaction(function () use ($transaction) {
                // 1. Update Transaction
                $transaction->date_returned = Carbon::now();
                $transaction->save();
                

                // 2. INCREASE STOCK
                if($transaction->wasChanged('date_returned'))
                {
                    // If book_id was changed, increment stock for the new book
                    $transaction->book->increment('stock');
                }

                $bookName = $transaction->book->name ?? 'Unknown Book';
                $studentName = ($transaction->student->firstname ?? '') . ' ' . ($transaction->student->lastname ?? '');

                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'action' => 'Returned Book',
                    'description' => "Received '{$bookName}' from {$studentName}",
                ]);
            });

            return back()->with('success', 'Book returned successfully. Stock restored.');
        }

        $validatedData = $request->validate([
            // Ensure unique txn_no, but ignore the current record's ID
            'txn_no'   => 'required|string|max:50|unique:transactions,txn_no,' . $id,
            'due_date' => 'required|date',
        ]);


        $transaction->update([
            'txn_no'   => $validatedData['txn_no'],
            'due_date' => $validatedData['due_date'],
        ]);

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction details updated.');
    }

    /**
     * Remove the specified transaction.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        
        // Optional: If you delete an active loan, should stock return?
        // Usually, yes. Safest is to force return first, then delete.
        // For now, we just delete the record.
        $transaction->delete();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }

    /**
     * Show overdue transactions.
     */
    public function overdue()
    {
        $overdueTransactions = Transaction::with(['student', 'book'])
            ->whereNull('date_returned') // Filter by date_returned, NOT date_added
            ->where('due_date', '<', Carbon::now()) // Due date is in the past
            ->orderBy('due_date', 'asc')
            ->get();
        
        // You can reuse the index view or a specific overdue view
        return view('admin.transactions.overdue', compact('overdueTransactions'));
    }
}