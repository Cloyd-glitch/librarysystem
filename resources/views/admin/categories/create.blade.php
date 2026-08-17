@extends('admin.layouts.master')

@section('title', 'Add New Category')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Add New Category</h1>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 mx-auto">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Category Information</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   placeholder="Enter category name (e.g., Fiction, Science, History)" 
                                   value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Example: Fiction, Non-Fiction, Science, History, Biography, etc.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="isActive" id="isActive" 
                                       {{ old('isActive', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActive">
                                    Active (Enable this category for use)
                                </label>
                            </div>
                            <small class="text-muted">Inactive categories won't appear in book selection dropdowns</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="ri-information-line me-2"></i>
                            <small>After creating this category, you can assign books to it from the Books management page.</small>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i> Create Category
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-light">
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