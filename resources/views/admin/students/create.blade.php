@extends('admin.layouts.master')

@section('title', 'Register New Student')

@section('content')
<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Register New Student</h1>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Students</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 mx-auto">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Student Information</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.students.store') }}" method="POST">
                        @csrf

                        <div class="row gy-4">
                            <div class="col-xl-12">
                                <label class="form-label">Student ID <span class="text-danger">*</span></label>
                                <input type="text" name="student_id" class="form-control" placeholder="Enter Student ID" required>
                            </div>

                            <div class="col-xl-4">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="firstname" class="form-control" placeholder="First Name" required>
                            </div>

                            <div class="col-xl-4">
                                <label class="form-label">Middle Name</label>
                                <input type="text" name="middlename" class="form-control" placeholder="Middle Name">
                            </div>

                            <div class="col-xl-4">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="lastname" class="form-control" placeholder="Last Name" required>
                            </div>

                            <div class="col-xl-6">
                                <label class="form-label">Course <span class="text-danger">*</span></label>
                                <input type="text" name="course" class="form-control" placeholder="e.g. BSCS" required>
                            </div>
                            <div class="col-xl-6">
                                <label class="form-label">Year Level <span class="text-danger">*</span></label>
                                <input type="number" name="year_level" class="form-control" min="1" max="6" placeholder="1" required>
                            </div>

                            <div class="col-xl-12">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="Enter valid email" required>
                            </div>

                            <div class="col-xl-6">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="col-xl-6">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i> Register Student
                            </button>
                            <a href="{{ route('admin.students.index') }}" class="btn btn-light">
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