@extends('admin.layouts.master')

@section('title', 'Edit Student')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <div>
            <h1 class="page-title fw-semibold fs-18 mb-0">Edit Student</h1>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Students</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 mx-auto">
            <div class="card custom-card">
                <div class="card-header">
                    <div class="card-title">Edit Student Information</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row gy-4">
                            <!-- Student ID -->
                            <div class="col-xl-12">
                                <label class="form-label">Student ID <span class="text-danger">*</span></label>
                                <input type="text" name="student_id" 
                                       class="form-control @error('student_id') is-invalid @enderror" 
                                       value="{{ old('student_id', $student->student_id) }}" 
                                       required>
                                @error('student_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Name Fields Row -->
                            <div class="col-xl-4">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="firstname" 
                                       class="form-control @error('firstname') is-invalid @enderror" 
                                       value="{{ old('firstname', $student->firstname) }}" 
                                       required>
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-xl-4">
                                <label class="form-label">Middle Name <span class="text-muted">(Optional)</span></label>
                                <input type="text" name="middlename" 
                                       class="form-control @error('middlename') is-invalid @enderror" 
                                       value="{{ old('middlename', $student->middlename) }}">
                                @error('middlename')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-xl-4">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="lastname" 
                                       class="form-control @error('lastname') is-invalid @enderror" 
                                       value="{{ old('lastname', $student->lastname) }}" 
                                       required>
                                @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-xl-12">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $student->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Course -->
                            <div class="col-xl-8">
                                <label class="form-label">Course <span class="text-danger">*</span></label>
                                <input type="text" name="course" 
                                       class="form-control @error('course') is-invalid @enderror" 
                                       value="{{ old('course', $student->course) }}" 
                                       required>
                                @error('course')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Year Level -->
                            <div class="col-xl-4">
                                <label class="form-label">Year Level <span class="text-danger">*</span></label>
                                <select name="year_level" class="form-select @error('year_level') is-invalid @enderror" required>
                                    <option value="">Select Year</option>
                                    <option value="1" {{ old('year_level', $student->year_level) == 1 ? 'selected' : '' }}>1st Year</option>
                                    <option value="2" {{ old('year_level', $student->year_level) == 2 ? 'selected' : '' }}>2nd Year</option>
                                    <option value="3" {{ old('year_level', $student->year_level) == 3 ? 'selected' : '' }}>3rd Year</option>
                                    <option value="4" {{ old('year_level', $student->year_level) == 4 ? 'selected' : '' }}>4th Year</option>
                                    <option value="5" {{ old('year_level', $student->year_level) == 5 ? 'selected' : '' }}>5th Year</option>
                                    <option value="6" {{ old('year_level', $student->year_level) == 6 ? 'selected' : '' }}>6th Year</option>
                                </select>
                                @error('year_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <i class="ri-information-line me-2"></i>
                            <small>This student has <strong>{{ $student->transactions()->count() }}</strong> transaction(s) in the system.</small>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i> Update Student
                            </button>
                            <a href="{{ route('admin.students.index') }}" class="btn btn-light">
                                <i class="ri-close-line me-1"></i> Cancel
                            </a>
                            <a href="{{ route('admin.students.show', $student->id) }}" class="btn btn-info">
                                <i class="ri-eye-line me-1"></i> View Details
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection