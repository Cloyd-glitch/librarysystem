@extends('admin.layouts.master')

@section('title', 'Book Details')

@section('content')
<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Book Details</h1>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">Books</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">Book Information</div>
                    <div>
                        <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-primary">
                            <i class="ri-edit-line me-1"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Title:</th>
                            <td>{{ $book->name }}</td>
                        </tr>
                        <tr>
                            <th>Author:</th>
                            <td>{{ $book->author }}</td>
                        </tr>
                        <tr>
                            <th>ISBN:</th>
                            <td><code>{{ $book->isbn }}</code></td>
                        </tr>
                        <tr>
                            <th>Category:</th>
                            <td><span class="badge bg-info-transparent">{{ $book->category->name ?? 'N/A' }}</span></td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($book->isActive)
                                    <span class="badge bg-success-transparent">Available</span>
                                @else
                                    <span class="badge bg-warning-transparent">Borrowed</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Date Added:</th>
                            <td>{{ \Carbon\Carbon::parse($book->date_added)->format('F d, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Transaction History -->
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Transaction History</div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Transaction #</th>
                                    <th>Student</th>
                                    <th>Borrowed Date</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($book->transactions as $transaction)
                                <tr>
                                    <td>#{{ $transaction->txn_no }}</td>
                                    <td>{{ $transaction->student->firstname }} {{ $transaction->student->lastname }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->date_borrowed)->format('M d, Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y') }}</td>
                                    <td>
                                        @if($transaction->date_added)
                                            <span class="badge bg-success-transparent">Returned</span>
                                        @else
                                            <span class="badge bg-warning-transparent">Borrowed</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3">No transaction history</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Quick Actions</div>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-primary">
                            <i class="ri-edit-line me-1"></i> Edit Book
                        </a>
                        <a href="{{ route('admin.books.index') }}" class="btn btn-light">
                            <i class="ri-arrow-left-line me-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection