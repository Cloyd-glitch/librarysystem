@extends('admin.layouts.master')

@section('title', 'Manage Books')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Books Management</h1>
            <p class="text-muted mb-0">Manage your library book collection</p>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Books</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-lg-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-top">
                        <div class="flex-fill">
                            <span class="d-block mb-1">Available Books</span>
                            <h4 class="fw-semibold mb-0">{{ $availableCount }}</h4>
                        </div>
                        <div class="ms-2">
                            <span class="avatar avatar-md bg-success-transparent">
                                <i class="ri-book-open-line fs-20"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-top">
                        <div class="flex-fill">
                            <span class="d-block mb-1">Borrowed Books</span>
                            <h4 class="fw-semibold mb-0">{{ $borrowedCount }}</h4>
                        </div>
                        <div class="ms-2">
                            <span class="avatar avatar-md bg-warning-transparent">
                                <i class="ri-bookmark-line fs-20"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="d-flex align-items-top">
                        <div class="flex-fill">
                            <span class="d-block mb-1">Total Books</span>
                            <h4 class="fw-semibold mb-0">{{ $books->total() }}</h4>
                        </div>
                        <div class="ms-2">
                            <span class="avatar avatar-md bg-primary-transparent">
                                <i class="ri-book-line fs-20"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
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
                    <div class="card-title">All Books</div>
                    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                        <i class="ri-add-line me-1"></i> Add New Book
                    </a>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Form -->
                    <form action="{{ route('admin.books.index') }}" method="GET" class="row g-3 mb-4">
                        <div class="col-lg-4">
                            <input type="text" name="search" class="form-control" placeholder="Search by title, author, or ISBN..." value="{{ request('search') }}">
                        </div>
                        <div class="col-lg-3">
                            <select name="category_id" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Available</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Borrowed</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="ri-search-line me-1"></i> Filter
                            </button>
                            <a href="{{ route('admin.books.index') }}" class="btn btn-light">
                                <i class="ri-refresh-line me-1"></i> Reset
                            </a>
                        </div>
                    </form>

                    <!-- Books Table -->
                    <div class="table-responsive">
                        <table class="table text-nowrap table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>ISBN</th>
                                    <th>Category</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Date Added</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                          <tbody>
                    @forelse($books as $book)
                    <tr>
                        
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <span class="avatar avatar-sm bg-primary-transparent">
                                        <i class="ri-book-2-line"></i>
                                    </span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.books.show', $book->id) }}" class="fw-semibold">
                                        {{ $book->name }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <td>{{ $book->author }}</td>
                        <td><code>{{ $book->isbn }}</code></td>
                        <td>
                            <span class="badge bg-info-transparent">
                                {{ $book->category->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold text-success">
                                    {{ $book->available_stock }} Available
                                </span>
                                <span class="text-muted small">
                                    out of {{ $book->stock }} Total
                                </span>
                                {{-- Add Stock Button --}}
                                <button type="button" class="btn btn-icon btn-sm btn-success-light rounded-pill mt-1" 
                                        data-bs-toggle="modal" data-bs-target="#addStockModal{{ $book->id }}" 
                                        title="Add Stock">
                                    <i class="ri-add-line"></i>
                                </button>
                            </div>
                        </td>
                        <td>
                            {{-- 1. Check if Book itself is inactive --}}
                            @if(!$book->isActive)
                                <span class="badge bg-danger-transparent">
                                    <i class="ri-close-circle-line me-1"></i>Inactive
                                </span>

                            @elseif(optional($book->category)->isActive == false) 
                                <span class="badge bg-secondary-transparent" data-bs-toggle="tooltip" title="This book is hidden because the '{{ $book->category->name }}' category is disabled.">
                                    <i class="ri-eye-off-line me-1"></i>Category Inactive
                                </span>

                            
                            @elseif($book->available_stock > 0)
                                <span class="badge bg-success-transparent">
                                    <i class="ri-checkbox-circle-line me-1"></i>Available
                                </span>
                            @else
                                <span class="badge bg-warning-transparent">
                                    <i class="ri-time-line me-1"></i>Out of Stock
                                </span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($book->date_added)->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.books.show', $book->id) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $book->id }}" title="Delete">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <i class="ri-inbox-line fs-48 text-muted"></i>
                            <p class="text-muted mb-0 mt-2">No books found</p>
                            <a href="{{ route('admin.books.create') }}" class="btn btn-sm btn-primary mt-2">
                                <i class="ri-add-line me-1"></i> Add Your First Book
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $books->firstItem() ?? 0 }} to {{ $books->lastItem() ?? 0 }} of {{ $books->total() }} entries
                        </div>
                        <div>
                            {{ $books->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- MODALS SECTION --}}
@foreach($books as $book)

  
    <div class="modal fade" id="addStockModal{{ $book->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Add Stock: {{ Str::limit($book->name, 20) }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.books.add-stock', $book->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <label class="form-label">Copies to Add</label>
                        <input type="number" name="added_stock" class="form-control" value="1" min="1" required>
                        <div class="text-muted small mt-2">
                            Current Stock: <strong>{{ $book->stock }}</strong>
                        </div>
                    </div>
                    <div class="modal-footer p-2">
                        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success btn-sm">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="deleteModal{{ $book->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>{{ $book->name }}</strong>?</p>
                    <p class="text-muted small mb-0">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection