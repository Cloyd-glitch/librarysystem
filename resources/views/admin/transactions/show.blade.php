@extends('admin.layouts.master')

@section('title', 'Transaction Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Transaction Details</h1>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}">Transactions</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 mx-auto">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Transaction #{{ $transaction->txn_no }}</div>
                    <div>
                        @if($transaction->date_added)
                            <span class="badge bg-success-transparent">Returned</span>
                        @elseif(\Carbon\Carbon::parse($transaction->due_date)->isPast())
                            <span class="badge bg-danger-transparent">Overdue</span>
                        @else
                            <span class="badge bg-warning-transparent">Borrowed</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-6">
                            <h6 class="fw-semibold mb-3">Student Information</h6>
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th width="150">Student ID:</th>
                                    <td>{{ $transaction->student->student_id }}</td>
                                </tr>
                                <tr>
                                    <th>Name:</th>
                                    <td>
                                        <a href="{{ route('admin.students.show', $transaction->student->id) }}">
                                            {{ $transaction->student->firstname }} {{ $transaction->student->lastname }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Course:</th>
                                    <td>{{ $transaction->student->course }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-xl-6">
                            <h6 class="fw-semibold mb-3">Book Information</h6>
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th width="150">Title:</th>
                                    <td>
                                        <a href="{{ route('admin.books.show', $transaction->book->id) }}">
                                            {{ $transaction->book->name }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Author:</th>
                                    <td>{{ $transaction->book->author }}</td>
                                </tr>
                                <tr>
                                    <th>ISBN:</th>
                                    <td><code>{{ $transaction->book->isbn }}</code></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-xl-12">
                            <h6 class="fw-semibold mb-3">Transaction Timeline</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="200">Borrowed Date:</th>
                                    <td>{{ \Carbon\Carbon::parse($transaction->date_borrowed)->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Due Date:</th>
                                    <td>
                                        {{ \Carbon\Carbon::parse($transaction->due_date)->format('F d, Y') }}
                                        @if(\Carbon\Carbon::parse($transaction->due_date)->isPast() && !$transaction->date_added)
                                            <span class="badge bg-danger-transparent ms-2">Overdue by {{ \Carbon\Carbon::parse($transaction->due_date)->diffInDays(now()) }} days</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Return Date:</th>
                                    <td>
                                        @if($transaction->date_added)
                                            {{ \Carbon\Carbon::parse($transaction->date_added)->format('F d, Y') }}
                                            <span class="badge bg-success-transparent ms-2">On Time</span>
                                        @else
                                            <span class="text-muted">Not yet returned</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Processed By:</th>
                                    <td>{{ $transaction->by }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="btn btn-primary">
                            <i class="ri-edit-line me-1"></i> Edit Transaction
                        </a>
                        <a href="{{ route('admin.transactions.index') }}" class="btn btn-light">
                            <i class="ri-arrow-left-line me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection