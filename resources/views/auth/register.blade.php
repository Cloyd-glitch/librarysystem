<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Library System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @vite(['resources/css/register.css'])
</head>
<body>
    <div class="register-container">
        <div class="register-card">
            <div class="register-header">
                <h2><i class="bi bi-book-fill"></i> Student Registration</h2>
                <p>Library Management System</p>
            </div>
            
            <div class="register-body">
                <!-- Info Alert -->
                <div class="alert alert-info mb-3" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    <small>Register as a <strong>Student</strong> to browse and borrow books from our library.</small>
                </div>

                <!-- Display validation errors -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Please fix the following errors:</strong>
                        </div>
                        <ul class="mb-0 mt-2 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Hidden Role Field - Always 'student' for registration -->
                    <input type="hidden" name="role" value="student">

                    <!-- Student ID -->
                    <div class="mb-3">
                        <label for="student_id" class="form-label">
                            <i class="bi bi-person-badge"></i> Student ID
                        </label>
                        <input type="text" 
                               class="form-control @error('student_id') is-invalid @enderror" 
                               id="student_id" 
                               name="student_id" 
                               value="{{ old('student_id') }}" 
                               placeholder="e.g., 2021-1234"
                               required 
                               autofocus>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Your unique student identification number</small>
                    </div>

                    <!-- Name Fields Row -->
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" 
                                   class="form-control @error('firstname') is-invalid @enderror" 
                                   id="firstname" 
                                   name="firstname" 
                                   value="{{ old('firstname') }}" 
                                   placeholder="Juan"
                                   required>
                            @error('firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="middlename" class="form-label">
                                Middle Name <span class="text-muted-custom">(Optional)</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('middlename') is-invalid @enderror" 
                                   id="middlename" 
                                   name="middlename" 
                                   value="{{ old('middlename') }}" 
                                   placeholder="Santos">
                            @error('middlename')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" 
                                   class="form-control @error('lastname') is-invalid @enderror" 
                                   id="lastname" 
                                   name="lastname" 
                                   value="{{ old('lastname') }}" 
                                   placeholder="Dela Cruz"
                                   required>
                            @error('lastname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope"></i> Email Address
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="juan.delacruz@example.com"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">We'll use this for notifications and account recovery</small>
                    </div>

                    <!-- Course and Year Level Row -->
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="course" class="form-label">
                                <i class="bi bi-mortarboard"></i> Course
                            </label>
                            <input type="text" 
                                   class="form-control @error('course') is-invalid @enderror" 
                                   id="course" 
                                   name="course" 
                                   value="{{ old('course') }}" 
                                   placeholder="e.g., BS Computer Science"
                                   required>
                            @error('course')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="year_level" class="form-label">Year Level</label>
                            <select class="form-select @error('year_level') is-invalid @enderror" 
                                    id="year_level" 
                                    name="year_level" 
                                    required>
                                <option value="">Select</option>
                                <option value="1" {{ old('year_level') == 1 ? 'selected' : '' }}>1st Year</option>
                                <option value="2" {{ old('year_level') == 2 ? 'selected' : '' }}>2nd Year</option>
                                <option value="3" {{ old('year_level') == 3 ? 'selected' : '' }}>3rd Year</option>
                                <option value="4" {{ old('year_level') == 4 ? 'selected' : '' }}>4th Year</option>
                                <option value="5" {{ old('year_level') == 5 ? 'selected' : '' }}>5th Year</option>
                            </select>
                            @error('year_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock"></i> Password
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Minimum 8 characters"
                               required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Must be at least 8 characters long</small>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">
                            <i class="bi bi-lock-fill"></i> Confirm Password
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               placeholder="Re-enter your password"
                               required>
                    </div>

                    <!-- Terms Agreement (Optional) -->
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="terms" required>
                        <label class="form-check-label small" for="terms">
                            I agree to the library's terms of service and borrowing policies
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-register w-100 mt-3">
                        <i class="bi bi-person-plus"></i> Create Student Account
                    </button>
                </form>

                <!-- Admin/Librarian Notice -->
                <div class="alert alert-warning mt-3 mb-3" role="alert">
                    <small>
                        <i class="bi bi-shield-lock-fill me-1"></i>
                        <strong>Note:</strong> Admin and Librarian accounts must be created by system administrators. 
                        Contact your library staff if you need elevated access.
                    </small>
                </div>

                <!-- Login Link -->
                <div class="divider">
                    <span>Already have an account?</span>
                </div>
                <a href="{{ route('login') }}" class="btn btn-outline-light w-100">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>