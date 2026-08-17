@extends('admin.layouts.master')

@section('title', 'Add New Book')

@section('content')
<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Add New Book</h1>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">Books</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 mx-auto">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Book Information</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.books.store') }}" method="POST">
                        @csrf

                        <div class="row gy-4">
                            <!-- Book Title -->
                            <div class="col-xl-12">
                                <label class="form-label">Book Title <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="Enter book title" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Author -->
                            <div class="col-xl-6">
                                <label class="form-label">Author <span class="text-danger">*</span></label>
                                <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" 
                                       placeholder="Enter author name" value="{{ old('author') }}" required>
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ISBN -->
                            <div class="col-xl-6">
                                <label class="form-label">ISBN <span class="text-danger">*</span></label>
                                <input type="text" name="isbn" class="form-control @error('isbn') is-invalid @enderror" 
                                       placeholder="Enter ISBN" value="{{ old('isbn') }}" required>
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="col-xl-6">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-xl-6">
                                <label class="form-label">Quantity (Stock) <span class="text-danger">*</span></label>
                                <input type="number" name="stock" class="form-control" value="1" min="1" required>
                                <small class="text-muted">If ISBN exists, this amount will be added to the existing stock.</small>
                            </div>

                            <!-- Status -->
                            <div class="col-xl-6">
                                <label class="form-label">Status</label>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="isActive" id="isActive" 
                                           {{ old('isActive', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isActive">
                                        Available for borrowing
                                    </label>
                                </div>
                            </div>
                        </div>



                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i> Create Book
                            </button>
                            <a href="{{ route('admin.books.index') }}" class="btn btn-light">
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