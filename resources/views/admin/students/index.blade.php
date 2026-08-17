@extends('admin.layouts.master')

@section('title', 'Manage Students')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Students Management</h1>
            <p class="text-muted mb-0">Manage student accounts and information</p>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Students</li>
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
                    <div class="card-title">All Students</div>
                    <a href="{{ route('admin.students.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus-fill"></i> Register New Student
        </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-bordered">
                            <thead>
                                <tr>
                                    <th width="100">Student ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Course</th>
                                    <th>Year Level</th>
                                    <th>Date Registered</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $student)
                                <tr>
                                    <td>
                                        <code>{{ $student->student_id }}</code>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <span class="avatar avatar-sm bg-primary-transparent">
                                                    {{ strtoupper(substr($student->firstname, 0, 1)) }}{{ strtoupper(substr($student->lastname, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <a href="{{ route('admin.students.show', $student->id) }}" class="fw-semibold">
                                                    {{ $student->firstname }} {{ $student->middlename ? $student->middlename . ' ' : '' }}{{ $student->lastname }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                        <span class="badge bg-info-transparent">{{ $student->course }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-transparent">Year {{ $student->year_level }}</span>
                                    </td>
                                    <td>
                                        @if($student->created_at)
                                            {{ $student->created_at->format('M d, Y') }}
                                            <br>
                                            <small class="text-muted">{{ $student->created_at->format('h:i A') }}</small>
                                        @else
                                            <span class="text-muted text-italic">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.students.edit', $student->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="ri-edit-line"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $student->id }}" title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete student <strong>{{ $student->firstname }} {{ $student->lastname }}</strong>?</p>
                                                        <p class="text-muted small mb-0">This action cannot be undone.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="ri-user-line fs-48 text-muted"></i>
                                        <p class="text-muted mb-0 mt-2">No students found</p>
                                        <a href="{{ route('admin.students.create') }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="ri-add-line me-1"></i> Add Your First Student
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