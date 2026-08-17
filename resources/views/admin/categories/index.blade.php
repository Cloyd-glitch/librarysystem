@extends('admin.layouts.master')

@section('title', 'Manage Categories')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Categories Management</h1>
            <p class="text-muted mb-0">Organize your library books by categories</p>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Categories</li>
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
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="ri-error-warning-line me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Main Content -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header justify-content-between">
                    <div class="card-title">All Categories</div>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i> Add New Category
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-bordered">
                            <thead>
                                <tr>
                                    <th width="80">ID</th>
                                    <th>Category Name</th>
                                    <th>Books Count</th>
                                    <th>Status</th>
                                    <th>Date Added</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
    @forelse($categories as $category)
    <tr>
        <td>{{ $category->id }}</td>
        <td>
            <div class="d-flex align-items-center">
                <div class="me-2">
                    <span class="avatar avatar-sm bg-primary-transparent">
                        <i class="ri-folder-line"></i>
                    </span>
                </div>
                <div>
                    <span class="fw-semibold">{{ $category->name }}</span>
                </div>
            </div>
        </td>
        <td>
            <span class="badge bg-info-transparent">
                {{ $category->books_count }} {{ Str::plural('book', $category->books_count) }}
            </span>
        </td>
        <td>
            @if($category->isActive)
                <span class="badge bg-success-transparent">
                    <i class="ri-checkbox-circle-line me-1"></i>Active
                </span>
            @else
                <span class="badge bg-danger-transparent">
                    <i class="ri-close-circle-line me-1"></i>Inactive
                </span>
            @endif
        </td>
        <td>{{ \Carbon\Carbon::parse($category->date_added)->format('M d, Y') }}</td>
        <td>
            <div class="btn-group" role="group">
                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning" title="Edit">
                    <i class="ri-edit-line"></i>
                </a>
                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $category->id }}" title="Delete">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>

            <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete <strong>{{ $category->name }}</strong>?</p>
                            @if($category->books_count > 0)
                                <div class="alert alert-warning">
                                    <i class="ri-alert-line me-2"></i>
                                    This category has <strong>{{ $category->books_count }}</strong> books associated with it.
                                </div>
                            @endif
                            <p class="text-muted small mb-0">This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- REMOVED THE EXTRA </div> HERE --}}
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="6" class="text-center py-4">
            <i class="ri-folder-open-line fs-48 text-muted"></i>
            <p class="text-muted mb-0 mt-2">No categories found</p>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary mt-2">
                <i class="ri-add-line me-1"></i> Add Your First Category
            </a>
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