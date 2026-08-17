@extends('layouts.student')


@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Welcome Header --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-lg shadow-lg p-8 mb-8 text-white">
            <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->firstname }}! 📚</h1>
            <p class="text-blue-100">Explore our collection and manage your borrowed books</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Currently Borrowed --}}
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase">Currently Borrowed</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $currentlyBorrowed ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Overdue Books --}}
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase">Overdue Books</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $overdueBooks ?? 0 }}</p>
                    </div>
                    <div class="bg-red-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Total Borrowed --}}
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 uppercase">Total Borrowed</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalBorrowed ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <a href="{{ route('student.books.index') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="bg-indigo-100 rounded-lg p-4 mr-4">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Browse Books</h3>
                        <p class="text-sm text-gray-600">Explore our library collection</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('student.my-books') }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="bg-purple-100 rounded-lg p-4 mr-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">My Books</h3>
                        <p class="text-sm text-gray-600">View your borrowed books</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Currently Reading Section --}}
        @if(isset($recentBorrowedBooks) && count($recentBorrowedBooks) > 0)
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Currently Reading</h2>
                <a href="{{ route('student.my-books') }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">View All →</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($recentBorrowedBooks as $transaction)
                <div class="border rounded-lg p-4 hover:shadow-md transition">
                    <div class="flex items-start mb-3">
                        <div class="bg-gray-200 rounded w-16 h-20 flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-gray-900 truncate">{{ $transaction->book->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $transaction->book->author }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Due:</span>
                        <span class="font-medium {{ \Carbon\Carbon::parse($transaction->due_date)->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                            {{ \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y') }}
                        </span>
                    </div>
                    
                    @if(\Carbon\Carbon::parse($transaction->due_date)->isPast())
                    <div class="mt-2 bg-red-50 border border-red-200 rounded px-3 py-1 text-xs text-red-700 font-medium">
                        ⚠️ Overdue
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $recentBorrowedBooks->links() }}
            </div> 

        </div>
        @endif

        {{-- Recent Announcements or Tips --}}
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-lg p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-amber-900">Library Reminder</h3>
                    <p class="mt-1 text-sm text-amber-700">Please return books on or before the due date to avoid late fees. You can renew books online through your account.</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection