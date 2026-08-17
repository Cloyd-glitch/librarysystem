<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        // Start query with relationships
        $query = Book::with('category');
        
        // Search by title, author, or ISBN
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
        
        // Filter by status (available/unavailable)
        if ($request->has('status') && $request->status != '') {
            $query->where('isActive', $request->status);
        }
        
        // Get paginated results (20 per page)
        $books = $query->latest('date_added')->paginate(20);
        
        // Get all categories for filter dropdown
        $categories = Category::where('isActive', true)->get();
        
        // Statistics
        $availableCount = Book::where('isActive', true)->count();
        $borrowedCount = 0; // TODO: Count from transactions where date_returned is null
        
        return view('admin.books.index', compact('books', 'categories', 'availableCount', 'borrowedCount'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
        $categories = Category::where('isActive', true)->get();
        return view('admin.books.create', compact('categories'));
        //                                          
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate 
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'isbn' => 'required|string|max:50', 
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:1',
            'isActive' => 'nullable', 
        ]);

        // 2. CHECK FOR DUPLICATES
        $existingBook = Book::where('name', $request->name)
                            ->where('author', $request->author)
                            ->first();

        if ($existingBook) {
            // DUPLICATE FOUND
            $newStock = $existingBook->stock + $request->stock;
            $existingBook->update(['stock' => $newStock]);
            
            $message = "Book '{$existingBook->name}' by {$existingBook->author} already exists. Stock updated to {$newStock}.";
        } else {
            // NO DUPLICATE
            $validatedData['date_added'] = now();
            $validatedData['isActive'] = $request->has('isActive') ? true : false;
            
            Book::create($validatedData);
            $message = "New book created successfully.";
        }

        ActivityLog::create([
        'user_id' => Auth::id(),
        'action' => 'Created Book',
        'description' => $request->name
    ]);

        return redirect()->route('admin.books.index')->with('success', $message);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        // Show book with its category and transaction history
    $book = Book::with(['category', 'transactions.student'])->findOrFail($id);
    
    return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        // Find the book to edit
            $book = Book::findOrFail($id);

            // Fetch all active categories for the dropdown
            $categories = Category::where('isActive', true)->get();

            // Corrected view and compact variables
            return view('admin.books.edit', compact('book', 'categories'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $book = Book::findOrFail($id);

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'isbn' => 'required|string|max:50|unique:books,isbn,' . $id,
        'author' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'stock' => 'required|integer|min:0',
        'isActive' => 'nullable',
    ]);

    // Prevent renaming a book to a Title/Author that already exists (merging not supported in update)
    $duplicateCheck = Book::where('name', $request->name)
                      ->where('author', $request->author)
                      ->where('id', '!=', $id) 
                      ->exists();

    if ($duplicateCheck) {
        return back()->with('error', 'Cannot update: Another book with this Title and Author already exists. Please delete this one.');
    }

    $validatedData['isActive'] = $request->has('isActive') ? 1 : 0;

    $book->update($validatedData);

    return redirect()->route('admin.books.index')
        ->with('success', 'Book details updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $book = Book::findOrFail($id);
        
        // Check if book has transactions
        if ($book->transactions()->count() > 0) {
            return redirect()->route('admin.books.index')
                ->with('error', 'Cannot delete book with existing transactions.');
        }
        
        $book->delete();
        
        return redirect()->route('admin.books.index')
            ->with('success', 'Book deleted successfully!');
    }

    public function addStock(Request $request, string $id)
    {
        $request->validate([
            'added_stock' => 'required|integer|min:1',
        ]);

        $book = Book::findOrFail($id);
        
        // Increment the stock
        $book->increment('stock', $request->added_stock);

        return redirect()->back()
            ->with('success', "Added {$request->added_stock} copies to '{$book->name}'. Total Stock: {$book->stock}");
    }
}
