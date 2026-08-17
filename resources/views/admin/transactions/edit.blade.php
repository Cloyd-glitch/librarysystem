@extends('admin.layouts.master')

@section('title', 'Edit Transaction')

@section('content')
<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Edit Transaction</h1>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.transactions.index') }}">Transactions</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
                    <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row gy-4">
                            
                            {{-- READ ONLY INFO --}}
                            <div class="col-12">
                                <div class="alert alert-light border">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="ri-user-line me-2 text-primary"></i>
                                        <strong>Student:</strong> 
                                        <span class="ms-2">{{ $transaction->student->firstname }} {{ $transaction->student->lastname }}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="ri-book-line me-2 text-primary"></i>
                                        <strong>Book:</strong> 
                                        <span class="ms-2">{{ $transaction->book->name }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- EDITABLE FIELD: Transaction Number --}}
                            <div class="col-xl-6">
                                <label class="form-label">Transaction No. <span class="text-danger">*</span></label>
                                <input type="text" name="txn_no" 
                                       class="form-control @error('txn_no') is-invalid @enderror" 
                                       value="{{ old('txn_no', $transaction->txn_no) }}" required>
                                @error('txn_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- EDITABLE FIELD: Due Date --}}
                            <div class="col-xl-6">
                                <label class="form-label">Due Date <span class="text-danger">*</span></label>
                                <input type="date" name="due_date" 
                                       class="form-control @error('due_date') is-invalid @enderror" 
                                       value="{{ old('due_date', $transaction->due_date->format('Y-m-d')) }}" required>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Read Only: Date Borrowed --}}
                            <div class="col-xl-6">
                                <label class="form-label text-muted">Date Borrowed</label>
                                <input type="text" class="form-control bg-light" 
                                       value="{{ $transaction->date_borrowed->format('M d, Y') }}" readonly>
                            </div>

                            {{-- Read Only: Status --}}
                            <div class="col-xl-6">
                                <label class="form-label text-muted">Current Status</label>
                                <div class="form-control bg-light d-flex align-items-center">
                                    @if($transaction->date_returned)
                                        <span class="badge bg-success-transparent">Returned</span>
                                    @elseif($transaction->due_date->isPast())
                                        <span class="badge bg-danger-transparent">Overdue</span>
                                    @else
                                        <span class="badge bg-primary-transparent">Active</span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i> Update Transaction
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