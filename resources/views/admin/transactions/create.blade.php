@extends('admin.layouts.master')

@section('title', 'New Transaction')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">New Transaction</h1>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}">Transactions</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 mx-auto">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Transaction Details</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.transactions.store') }}" method="POST">
                        @csrf

                        <div class="row gy-4">
                            <!-- Transaction Number -->
                            <div class="col-xl-12">
                                <label class="form-label">Transaction Number <span class="text-danger">*</span></label>
                                <input type="text" name="txn_no" class="form-control @error('txn_no') is-invalid @enderror" 
                                       placeholder="e.g., TXN-2024-001" value="{{ old('txn_no', 'TXN-' . date('Ymd') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT)) }}" required>
                                @error('txn_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Student -->
                            <div class="col-xl-12">
                                <label class="form-label">Student <span class="text-danger">*</span></label>
                                <select name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                                    <option value="">Select Student</option>
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                            {{ $student->student_id }} - {{ $student->firstname }} {{ $student->lastname }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Book -->
                            <div class="col-xl-12">
                                <label class="form-label">Book <span class="text-danger">*</span></label>
                                <select name="book_id" class="form-select @error('book_id') is-invalid @enderror" required>
                                    <option value="">Select Book</option>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                            {{ $book->name }} - {{ $book->author }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('book_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date Borrowed -->
                            <div class="col-xl-6">
                                <label class="form-label">Date Borrowed <span class="text-danger">*</span></label>
                                <input type="date" name="date_borrowed" class="form-control @error('date_borrowed') is-invalid @enderror" 
                                       value="{{ old('date_borrowed', date('Y-m-d')) }}" required>
                                @error('date_borrowed')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Due Date -->
                            <div class="col-xl-6">
                                <label class="form-label">Due Date <span class="text-danger">*</span></label>
                                <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" 
                                       value="{{ old('due_date', date('Y-m-d', strtotime('+14 days'))) }}" required>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Default: 14 days from borrow date</small>
                            </div>

                            <!-- Processed By -->
                            <div class="col-xl-12">
                                <label class="form-label">Processed By <span class="text-danger">*</span></label>
                                <input type="text" name="by" class="form-control @error('by') is-invalid @enderror" 
                                       value="{{ old('by', Auth::user()->firstname . ' ' . Auth::user()->lastname) }}" required>
                                @error('by')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i> Create Transaction
                            </button>
                            <a href="{{ route('admin.transactions.index') }}" class="btn btn-light">
                                <i class="ri-close-line me-1"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection