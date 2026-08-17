@extends('layouts.student')

@section('title', 'My Profile')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">My Profile</h1>
            <p class="text-gray-600">Manage your personal information and account settings</p>
        </div>

        {{-- Profile Card --}}
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            
            {{-- Header Section --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-8">
                <div class="flex items-center">
                    {{-- Avatar --}}
                    <div class="bg-white rounded-full p-1 mr-6">
                        <div class="bg-gradient-to-br from-blue-400 to-indigo-500 rounded-full w-24 h-24 flex items-center justify-center text-white text-3xl font-bold">
                            {{ strtoupper(substr(Auth::user()->firstname ?? 'S', 0, 1)) }}{{ strtoupper(substr(Auth::user()->lastname ?? 'T', 0, 1)) }}
                        </div>  
                    </div>
                    
                    {{-- User Info --}}
                    <div class="text-white">
                        <h2 class="text-2xl font-bold mb-1">
                            {{ Auth::user()->firstname }} {{ Auth::user()->middlename ? Auth::user()->middlename . ' ' : '' }}{{ Auth::user()->lastname }}
                        </h2>
                        <p class="text-blue-100 mb-2">{{ Auth::user()->email }}</p>
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-500 bg-opacity-50">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                            Student
                        </div>
                    </div>
                </div>
            </div>

            {{-- Profile Information Form --}}
            <div class="p-6">
                @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                <form action="{{ route('student.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        
                        {{-- Personal Information Section --}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Personal Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Student ID (Read-only) --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Student ID</label>
                                    <input type="text" value="{{ Auth::user()->student_id }}" disabled
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                                </div>

                                {{-- Course (Read-only) --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Course</label>
                                    <input type="text" value="{{ Auth::user()->course }}" disabled
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                                </div>

                                {{-- First Name --}}
                                <div>
                                    <label for="firstname" class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                                    <input type="text" id="firstname" name="firstname" value="{{ old('firstname', Auth::user()->firstname) }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500{{ $errors->has('firstname') ? ' border-red-500' : '' }}">
                                    @error('firstname')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Middle Name --}}
                                <div>
                                    <label for="middlename" class="block text-sm font-medium text-gray-700 mb-2">Middle Name</label>
                                    <input type="text" id="middlename" name="middlename" value="{{ old('middlename', Auth::user()->middlename) }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                {{-- Last Name --}}
                                <div>
                                    <label for="lastname" class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                                    <input type="text" id="lastname" name="lastname" value="{{ old('lastname', Auth::user()->lastname) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500{{ $errors->has('lastname') ? ' border-red-500' : '' }}">
                                    @error('lastname')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Year Level (Read-only) --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Year Level</label>
                                    <input type="text" value="{{ Auth::user()->year_level }}" disabled
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500 cursor-not-allowed">
                                </div>
                            </div>
                        </div>

                        {{-- Contact Information Section --}}
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 pb-2 border-b">Contact Information</h3>
                            
                            <div class="grid grid-cols-1 gap-6">
                                {{-- Email --}}
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500{{ $errors->has('email') ? ' border-red-500' : '' }}">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center justify-between pt-6 border-t">
                            <a href="{{ route('student.dashboard') }}" 
                               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Account Statistics --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Books Borrowed</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalBorrowed ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Currently Reading</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $currentlyBorrowed ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Account Status</p>
                        <p class="text-lg font-bold text-green-600">Active</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Security Notice --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h4 class="text-sm font-medium text-blue-900 mb-1">Account Security</h4>
                    <p class="text-sm text-blue-700">To update your password or modify your Student ID, Course, or Year Level, please contact the library administration or visit the library desk.</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection