@extends('admin.layouts.master')

@section('title', 'Overdue Books')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Overdue Books</h1>
            <p class="text-muted mb-0">Books that have exceeded their due date</p>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}">Transactions</a></li>
                    <li class="breadcrumb-item active">Overdue</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Alert -->
    @if($overdueTransactions->count() > 0)
        {{-- Show Warning if there are overdue books --}}
        <div class="alert alert-warning" role="alert">
            <i class="ri-alert-line me-2"></i>
            <strong>{{ $overdueTransactions->count() }} overdue {{ Str::plural('transaction', $overdueTransactions->count()) }} found.</strong>
            Please contact the students to return their books.
        </div>
    @else
        {{-- Show Success if count is 0 --}}
        <div class="alert alert-success" role="alert">
            <i class="ri-check-double-line me-2"></i>
            <strong>No overdue books found!</strong>
            All borrowed books are within their due dates.
        </div>
    @endif

    <!-- Main Content -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Overdue Transactions</div>
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-light">
                        <i class="ri-arrow-left-line me-1"></i> Back to All
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
                                    <th>Due Date</th>
                                    <th>Days Overdue</th>
                                    <th>Contact</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($overdueTransactions as $transaction)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="fw-semibold">
                                            #{{ $transaction->txn_no }}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.students.show', $transaction->student->id) }}">
                                            {{ $transaction->student->firstname }} {{ $transaction->student->lastname }}
                                        </a>
                                    </td>
                                    <td>{{ Str::limit($transaction->book->name, 30) }}</td>
                                    <td>
                                        <span class="text-danger fw-semibold">
                                            {{ \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger-transparent">
                                            {{ intval(\Carbon\Carbon::parse($transaction->due_date)->diffInDays(now())) }} days
                                        </span>
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $transaction->student->email }}" class="btn btn-sm btn-info">
                                            <i class="ri-mail-line"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn btn-sm btn-primary">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="ri-check-line fs-48 text-success"></i>
                                        <p class="text-muted mb-0 mt-2">No overdue books! Everything is on track.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection