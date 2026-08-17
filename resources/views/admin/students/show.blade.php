@extends('admin.layouts.master')

@section('title', 'Student Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Student Details</h1>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Students</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Student Information -->
        <div class="col-xl-8">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Student Information</div>
                    <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-primary">
                        <i class="ri-edit-line me-1"></i> Edit
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th width="200">Student ID:</th>
                                <td><code>{{ $student->student_id }}</code></td>
                            </tr>
                            <tr>
                                <th>Full Name:</th>
                                <td>{{ $student->firstname }} {{ $student->middlename ? $student->middlename . ' ' : '' }}{{ $student->lastname }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $student->email }}</td>
                            </tr>
                            <tr>
                                <th>Course:</th>
                                <td><span class="badge bg-info-transparent">{{ $student->course }}</span></td>
                            </tr>
                            <tr>
                                <th>Year Level:</th>
                                <td><span class="badge bg-primary-transparent">Year {{ $student->year_level }}</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Borrowing History -->
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Borrowing History</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Transaction #</th>
                                    <th>Book</th>
                                    <th>Borrowed</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($student->transactions as $transaction)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="fw-semibold">
                                            #{{ $transaction->txn_no }}
                                        </a>
                                    </td>
                                    <td>{{ $transaction->book->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->date_borrowed)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y') }}</td>
                                    <td>
                                        @if($transaction->date_added)
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
                                    <td colspan="5" class="text-center py-3">
                                        <i class="ri-inbox-line fs-24 text-muted"></i>
                                        <p class="text-muted mb-0 mt-2">No borrowing history</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats & Actions -->
        <div class="col-xl-4">
            <!-- Statistics -->
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Statistics</div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Total Borrowed:</span>
                            <span class="fw-semibold">{{ $student->transactions()->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Currently Borrowed:</span>
                            <span class="fw-semibold">{{ $student->transactions()->whereNull('date_added')->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-muted">Returned Books:</span>
                            <span class="fw-semibold">{{ $student->transactions()->whereNotNull('date_added')->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Overdue Books:</span>
                            <span class="fw-semibold text-danger">
                                {{ $student->transactions()->whereNull('date_added')->where('due_date', '<', now())->count() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Quick Actions</div>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-primary">
                            <i class="ri-edit-line me-1"></i> Edit Student
                        </a>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-light">
                            <i class="ri-arrow-left-line me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection