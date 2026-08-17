<!-- File: resources/views/partials/welcome-main.blade.php -->
<!-- Updated to handle both Admin/Librarian and Student roles -->

<div class="w-full">
    <!-- Hero Section -->
    <section class="w-full">
        <div class="w-full max-w-[2000px] mx-auto">
            <!-- Hero Card -->
            <div class="bg-[#1a1a2e]/95 border border-white/10 rounded-2xl overflow-hidden shadow-2xl backdrop-blur-sm">
                <div class="flex flex-col lg:flex-row">
                    <!-- Left: Content -->
                    <div class="lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center bg-gradient-to-br from-green-600/10 to-green-800/10">
                        <!-- Title with Gradient -->
                        <h1 class="text-4xl lg:text-5xl font-extrabold mb-6 bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent leading-tight">
                            📚 Library System Management
                        </h1>
                        
                        <!-- Description -->
                        <p class="text-white/80 text-lg leading-relaxed mb-8">
                            Manage books, users, and loans with an intuitive, lightweight system built for libraries of any size. Search the catalog, track loans, and keep your collection organized.
                        </p>

                        <!-- Dynamic Action Buttons Based on Auth Status and Role -->
                        <div class="flex flex-col sm:flex-row gap-4 mb-8">
                            @auth
                                <!-- If User is LOGGED IN - Check Role -->
                                
                                @if(Auth::user()->isStaff())
                                    <!-- ADMIN/LIBRARIAN Dashboard -->
                                    <a href="{{ route('admin.dashboard') }}" 
                                       class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-semibold shadow-lg shadow-blue-500/40 hover:shadow-blue-500/60 hover:-translate-y-1 transition-all duration-300">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Admin Dashboard
                                    </a>
                                @elseif(Auth::user()->isStudent())
                                    <!-- STUDENT Dashboard -->
                                    <a href="{{ route('student.dashboard') }}" 
                                       class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg font-semibold shadow-lg shadow-green-500/40 hover:shadow-green-500/60 hover:-translate-y-1 transition-all duration-300">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        My Library
                                    </a>
                                @else
                                    <!-- Fallback for unknown roles -->
                                    <a href="{{ route('login') }}" 
                                       class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-lg font-semibold shadow-lg hover:-translate-y-1 transition-all duration-300">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        Go to Dashboard
                                    </a>
                                @endif

                                <!-- Logout Button (for all logged-in users) -->
                                <form method="POST" action="{{ route('logout') }}" class="inline-block w-full sm:w-auto">
                                    @csrf
                                    <button type="submit"
                                            class="w-full inline-flex items-center justify-center px-6 py-3 border-2 border-red-500/50 text-white/90 rounded-lg font-semibold hover:bg-red-500/20 hover:border-red-500 hover:-translate-y-1 transition-all duration-300">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            @else
                                <!-- If User is NOT LOGGED IN -->
                                
                                <!-- Login Button -->
                                <a href="{{ route('login') }}" 
                                   class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg font-semibold shadow-lg shadow-green-500/40 hover:shadow-green-500/60 hover:-translate-y-1 transition-all duration-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    Login
                                </a>

                                <!-- Register Button -->
                                <a href="{{ route('register') }}" 
                                   class="inline-flex items-center justify-center px-6 py-3 border-2 border-green-200/20 text-white/90 rounded-lg font-semibold hover:bg-white/10 hover:border-white/50 hover:-translate-y-1 transition-all duration-300">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                    </svg>
                                    Register Now
                                </a>
                            @endauth
                        </div>

                        <!-- Stats -->
                        <div class="flex gap-8 mb-8 flex-wrap">
                            <div class="text-center">
                                <div class="text-3xl font-bold bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent">
                                    5000+
                                </div>
                                <div class="text-white/60 text-sm mt-1">Books</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent">
                                    500+
                                </div>
                                <div class="text-white/60 text-sm mt-1">Users</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold bg-gradient-to-r from-green-400 to-green-600 bg-clip-text text-transparent">
                                    99%
                                </div>
                                <div class="text-white/60 text-sm mt-1">Uptime</div>
                            </div>
                        </div>

                        <!-- Features List -->
                        <div class="bg-black/20 rounded-xl p-6">
                            <div class="text-white font-semibold mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                                Key Features
                            </div>
                            <ul class="space-y-3">
                                <li class="flex items-start text-white/80">
                                    <svg class="w-5 h-5 mr-3 mt-0.5 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Book catalog with advanced search and filters</span>
                                </li>
                                <li class="flex items-start text-white/60">
                                    <svg class="w-5 h-5 mr-3 mt-0.5 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>User management and borrowing history tracking</span>
                                </li>
                                <li class="flex items-start text-white/50">
                                    <svg class="w-5 h-5 mr-3 mt-0.5 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Loan tracking with automated due-date reminders</span>
                                </li>
                                <li class="flex items-start text-white/40">
                                    <svg class="w-5 h-5 mr-3 mt-0.5 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Import/export tools for seamless catalog data management</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Right: Image -->
                    <div class="lg:w-1/2 relative overflow-hidden group">
                        <div class="h-64 sm:h-80 lg:h-full min-h-[400px] relative">
                            <img src="{{ asset('images/books-image.jpg') }}" 
                                 alt="Library Management System" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=800&auto=format&fit=crop'">
                            
                            <!-- Gradient Overlay on Hover -->
                            <div class="absolute inset-0 bg-gradient-to-br from-green-600/20 to-green-800/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Feature Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                <!-- Fast & Efficient -->
                <div class="bg-[#1a1a2e]/95 border border-white/10 rounded-xl p-6 text-center backdrop-blur-sm hover:border-green-200/20 transition-all duration-300 hover:-translate-y-2">
                    <div class="text-yellow-400 text-5xl mb-4">⚡</div>
                    <h3 class="text-white text-xl font-semibold mb-3">Fast & Efficient</h3>
                    <p class="text-white/60 text-sm">Lightning-fast search and processing for seamless library management.</p>
                </div>

                <!-- Secure & Reliable -->
                <div class="bg-[#1a1a2e]/95 border border-white/10 rounded-xl p-6 text-center backdrop-blur-sm hover:border-green-200/20 transition-all duration-300 hover:-translate-y-2">
                    <div class="text-green-400 text-5xl mb-4">🛡️</div>
                    <h3 class="text-white text-xl font-semibold mb-3">Secure & Reliable</h3>
                    <p class="text-white/60 text-sm">Enterprise-grade security to protect your data and user privacy.</p>
                </div>

                <!-- Mobile Friendly -->
                <div class="bg-[#1a1a2e]/95 border border-white/10 rounded-xl p-6 text-center backdrop-blur-sm hover:border-green-200/20 transition-all duration-300 hover:-translate-y-2">
                    <div class="text-blue-400 text-5xl mb-4">📱</div>
                    <h3 class="text-white text-xl font-semibold mb-3">Mobile Friendly</h3>
                    <p class="text-white/60 text-sm">Access your library system anywhere, anytime, on any device.</p>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    /* Additional custom styles for gradient text and animations */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
</style>