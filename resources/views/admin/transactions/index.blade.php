@extends('admin.layouts.master')

@section('title', 'Manage Transactions')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Transactions Management</h1>
            <p class="text-muted mb-0">Track all book borrowing and returns</p>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Transactions</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ri-check-line me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif(session('message'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="ri-information-line me-2"></i>{{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Tabs -->
    <div class="row mb-4">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="btn-group" role="group">
                    
                    <a href="{{ route('admin.transactions.index') }}" 
                    class="btn btn-primary {{ !request('status') && !Route::is('admin.transactions.overdue') ? 'active' : '' }}">
                        <i class="ri-list-check me-1"></i> All Transactions
                    </a>

                    <a href="{{ route('admin.transactions.index', ['status' => 'borrowed']) }}" 
                    class="btn btn-primary {{ request('status') == 'borrowed' ? 'active' : '' }}">
                        <i class="ri-book-line me-1"></i> Currently Borrowed
                    </a>

                    <a href="{{ route('admin.transactions.overdue') }}" 
                    class="btn btn-danger {{ Route::is('admin.transactions.overdue') ? 'active' : '' }}">
                        <i class="ri-alert-line me-1"></i> Overdue Books
                    </a>

                    <a href="{{ route('admin.transactions.index', ['status' => 'returned']) }}" 
                    class="btn btn-primary {{ request('status') == 'returned' ? 'active' : '' }}">
                        <i class="ri-check-line me-1"></i> Returned
                    </a>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">All Transactions</div>
                    <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i> New Transaction
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-bordered">
                            <thead>
                                <tr>
                                    <th>Transaction #</th>
                                    <th>Student</th>
                                    <th>Book</th>
                                    <th>Borrowed</th>
                                    <th>Due Date</th>
                                    <th>Returned</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        <tbody>
                            @forelse($transactions as $transaction)
                            <tr>
                                {{-- Transaction ID --}}
                                <td>
                                    <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="fw-semibold text-primary">
                                        #{{ $transaction->txn_no }}
                                    </a>
                                </td>
                                
                                {{-- Student --}}
                                <td>
                                    @if($transaction->student)
                                        <div class="d-flex align-items-center">
                                            <span class="avatar avatar-xs me-2 avatar-rounded">
                                                <img src="https://ui-avatars.com/api/?name={{ $transaction->student->firstname }}+{{ $transaction->student->lastname }}&background=random" alt="">
                                            </span>
                                            <div class="fw-medium">{{ $transaction->student->firstname }} {{ $transaction->student->lastname }}</div>
                                        </div>
                                    @else
                                        <span class="text-danger fst-italic">Student Deleted</span>
                                    @endif
                                </td>

                                {{-- Book --}}
                                <td>
                                    @if($transaction->book)
                                        <div class="fw-medium">{{ Str::limit($transaction->book->name, 30) }}</div>
                                    @else
                                        <span class="text-danger fst-italic">Book Deleted</span>
                                    @endif
                                </td>

                                {{-- Borrowed Date --}}
                                <td>
                                    {{ \Carbon\Carbon::parse($transaction->date_borrowed)->format('M d, Y') }}
                                </td>

                                {{-- Due Date --}}
                                <td>
                                    <span class="{{ \Carbon\Carbon::parse($transaction->due_date)->isPast() && !$transaction->date_returned ? 'text-danger fw-bold' : '' }}">
                                        {{ \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y') }}
                                    </span>
                                </td>

                                {{-- Returned Date --}}
                                <td>
                                    @if($transaction->date_returned)
                                        <span class="text-success fw-medium">
                                            {{ \Carbon\Carbon::parse($transaction->date_returned)->format('M d, Y') }}
                                        </span>
                                    @else
                                        <span class="text-muted text-center d-block">-</span>
                                    @endif
                                </td>

                                {{-- Status Badge --}}
                                <td>
                                    @if($transaction->date_returned)
                                        <span class="badge bg-success-transparent text-success">Returned</span>
                                    @elseif(\Carbon\Carbon::parse($transaction->due_date)->isPast())
                                        <span class="badge bg-danger-transparent text-danger">Overdue</span>
                                    @else
                                        <span class="badge bg-primary-transparent text-primary">Borrowed</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <div class="hstack gap-2 fs-15">
                                        {{-- Mark as Returned Button (Only if not returned yet) --}}
                                        @if(!$transaction->date_returned)
                                            <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="action" value="return">
                                                <button type="submit" class="btn btn-icon btn-sm btn-success-light" data-bs-toggle="tooltip" title="Mark as Returned">
                                                    <i class="ri-check-double-line"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('admin.transactions.edit', $transaction->id) }}" 
                                            class="btn btn-icon btn-sm btn-info-light" 
                                            title="Edit Transaction">
                                                <i class="ri-edit-line"></i>
                                            </a>

                                        {{-- Delete Button --}}
                                        <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-sm btn-danger-light" data-bs-toggle="tooltip" title="Delete History">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ri-inbox-line fs-48 text-muted mb-2"></i>
                                        <p class="text-muted mb-0">No transactions found</p>
                                        <a href="{{ route('admin.transactions.create') }}" class="btn btn-sm btn-primary mt-3">
                                            Create First Transaction
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        </table>
                    </div>
                    <div class="mt-4 d-flex justify-content-end">
                    {{ $transactions->links() }}
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection