<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Admin Controllers
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;

// Student Controllers
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\BookController as StudentBookController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Admin & Librarian Routes (Staff Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin,librarian'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management (Admins/Librarians)
    Route::resource('users', UserController::class);
    
    // Books Management
    Route::put('/books/{book}/add-stock', [BookController::class, 'addStock'])->name('books.add-stock');
    Route::resource('books', BookController::class);
    
    // Categories Management
    Route::resource('categories', CategoryController::class);
    
    // Students Management  
    Route::resource('students', StudentController::class);
    
    // Transactions Management
    Route::get('/transactions/overdue', [TransactionController::class, 'overdue'])->name('transactions.overdue');
    Route::resource('transactions', TransactionController::class);
    
    
});

/*
|--------------------------------------------------------------------------
| Student Routes (Students Only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    
    // Browse Books (Read-Only)
    Route::get('/books', [StudentBookController::class, 'index'])->name('books.index');
    Route::get('/books/{id}', [StudentBookController::class, 'show'])->name('books.show');
    
    // My Borrowed Books
    Route::get('/my-books', [StudentBookController::class, 'myBooks'])->name('my-books');
    Route::post('/books/{id}/borrow', [StudentBookController::class, 'borrow'])->name('books.borrow');
    Route::get('/books/receipt/{txn_no}', [StudentBookController::class, 'showReceipt'])->name('books.receipt');
    
    // My Profile
    Route::get('/profile', [StudentProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [StudentProfileController::class, 'update'])->name('profile.update');
    
    // Borrow Action (Added from previous step)
    Route::post('/books/{id}/borrow', [StudentBookController::class, 'borrow'])->name('books.borrow');
});

// ... rest of your file (test routes, auth require) ...
Route::get('/test-role', function () {
    if (!Auth::check()) {
        return 'Not logged in';
    }
    
    $user = Auth::user();
    return [
        'email' => $user->email,
        'role' => $user->role,
        'isStaff' => $user->isStaff(),
        'isStudent' => $user->isStudent(),
        'isAdmin' => $user->isAdmin(),
        'isLibrarian' => $user->isLibrarian(),
    ];
})->middleware('auth');

require __DIR__.'/auth.php';