@extends('admin.layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Dashboard</h1>
            <p class="text-muted mb-0">Welcome back, {{ Auth::user()->firstname }}!</p>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Statistics Cards Row 1 -->
    <div class="row">
        <!-- Total Books -->
        <div class="col-xxl-3 col-lg-6 col-md-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-top">
                        <div class="flex-fill">
                            <span class="d-block mb-2 text-muted">Total Books</span>
                            <h4 class="fw-semibold mb-2">{{ $stats['total_books'] }}</h4>
                            <span class="fs-12 text-success">
                                <i class="ti ti-trending-up me-1"></i>{{ $stats['available_books'] }} Available
                            </span>
                        </div>
                        <div class="ms-2">
                            <span class="avatar avatar-lg bg-primary-transparent">
                                <i class="ri-book-line fs-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Borrowed Books -->
        <div class="col-xxl-3 col-lg-6 col-md-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-top">
                        <div class="flex-fill">
                            <span class="d-block mb-2 text-muted">Borrowed Books</span>
                            <h4 class="fw-semibold mb-2">{{ $stats['borrowed_books'] }}</h4>
                            <span class="fs-12 text-warning">
                                <i class="ti ti-alert-circle me-1"></i>{{ $stats['overdue_books'] }} Overdue
                            </span>
                        </div>
                        <div class="ms-2">
                            <span class="avatar avatar-lg bg-warning-transparent">
                                <i class="ri-bookmark-line fs-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Students -->
        <div class="col-xxl-3 col-lg-6 col-md-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-top">
                        <div class="flex-fill">
                            <span class="d-block mb-2 text-muted">Total Students</span>
                            <h4 class="fw-semibold mb-2">{{ $stats['total_students'] }}</h4>
                            <span class="fs-12 text-success">
                                <i class="ti ti-trending-up me-1"></i>Active Users
                            </span>
                        </div>
                        <div class="ms-2">
                            <span class="avatar avatar-lg bg-success-transparent">
                                <i class="ri-user-line fs-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Transactions -->
        <div class="col-xxl-3 col-lg-6 col-md-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-top">
                        <div class="flex-fill">
                            <span class="d-block mb-2 text-muted">Total Transactions</span>
                            <h4 class="fw-semibold mb-2">{{ $stats['total_transactions'] }}</h4>
                            <span class="fs-12 text-info">
                                <i class="ti ti-arrow-back-up me-1"></i>{{ $stats['returned_books'] }} Returned
                            </span>
                        </div>
                        <div class="ms-2">
                            <span class="avatar avatar-lg bg-info-transparent">
                                <i class="ri-exchange-line fs-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Recent Transactions -->
        <div class="col-xxl-8 col-xl-7">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Recent Transactions</div>
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-sm btn-primary">
                        View All <i class="ri-arrow-right-line ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Transaction #</th>
                                    <th>Student</th>
                                    <th>Book</th>
                                    <th>Date Borrowed</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="fw-semibold">
                                            #{{ $transaction->txn_no }}
                                        </a>
                                    </td>
                                    <td>{{ $transaction->student->firstname }} {{ $transaction->student->lastname }}</td>
                                    <td>{{ Str::limit($transaction->book->name, 30) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->date_borrowed)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y') }}</td>
                                    <td>
                                        @if($transaction->date_returned)
                                            <span class="badge bg-success-transparent">Returned</span>
                                        @elseif(\Carbon\Carbon::parse($transaction->due_date)->isPast())
                                            <span class="badge bg-danger-transparent">Overdue</span>
                                        @else
                                            <span class="badge bg-warning-transparent">Borrowed</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="ri-inbox-line fs-24 text-muted"></i>
                                        <p class="text-muted mb-0 mt-2">No recent transactions</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-xxl-4 col-xl-5">
            <!-- Most Borrowed Books -->
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Most Borrowed Books</div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @forelse($mostBorrowedBooks as $book)
                        <li class="mb-3 d-flex align-items-center">
                            <div class="me-2">
                                <span class="avatar avatar-sm bg-primary-transparent">
                                    <i class="ri-book-2-line fs-14"></i>
                                </span>
                            </div>
                            <div class="flex-fill">
                                <div class="fw-semibold">{{ Str::limit($book->name, 25) }}</div>
                                <span class="text-muted fs-12">{{ $book->author }}</span>
                            </div>
                            <div>
                                <span class="badge bg-primary-transparent">{{ $book->transactions_count }} times</span>
                            </div>
                        </li>
                        @empty
                        <li class="text-center py-3">
                            <i class="ri-book-line fs-24 text-muted"></i>
                            <p class="text-muted mb-0 mt-2">No data available</p>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Most Active Students -->
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Most Active Students</div>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @forelse($mostActiveStudents as $student)
                        <li class="mb-3 d-flex align-items-center">
                            <div class="me-2">
                                <span class="avatar avatar-sm bg-success-transparent">
                                    {{ strtoupper(substr($student->firstname, 0, 1)) }}{{ strtoupper(substr($student->lastname, 0, 1)) }}
                                </span>
                            </div>
                            <div class="flex-fill">
                                <div class="fw-semibold">{{ $student->firstname }} {{ $student->lastname }}</div>
                                <span class="text-muted fs-12">{{ $student->course }}</span>
                            </div>
                            <div>
                                <span class="badge bg-success-transparent">{{ $student->transactions_count }}</span>
                            </div>
                        </li>
                        @empty
                        <li class="text-center py-3">
                            <i class="ri-user-line fs-24 text-muted"></i>
                            <p class="text-muted mb-0 mt-2">No data available</p>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="card custom-card">
    <div class="card-header justify-content-between">
        <div class="card-title">
            Recent Activity
        </div>
        <div>
             <span class="badge bg-light text-secondary">Log</span>
        </div>
    </div>
    <div class="card-body">
        <ul class="list-unstyled mb-0">
            @forelse($recentActivities as $activity)
                <li class="mb-3">
                    <div class="d-flex align-items-start">
                        <div class="me-2">
                            <span class="avatar avatar-sm bg-primary-transparent">
                                {{ strtoupper(substr($activity->user->firstname ?? 'S', 0, 1)) }}
                            </span>
                        </div>
                        <div class="flex-fill">
                            <p class="mb-0 fw-semibold">{{ $activity->action }}</p>
                            <div class="text-muted fs-12">
                                {{ $activity->user->firstname ?? 'System' }} 
                                <span class="mx-1">•</span> 
                                {{ $activity->description }}
                            </div>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">{{ $activity->created_at->diffForHumans(null, true) }}</small>
                        </div>
                    </div>
                </li>
            @empty
                <li class="text-center text-muted">No recent activity.</li>
            @endforelse
        </ul>
    </div>
</div>
    </div>
</div>
@endsection