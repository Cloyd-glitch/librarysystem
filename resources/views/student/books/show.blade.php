@extends('layouts.student')

@section('title', $book->name ?? 'Book Details')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('student.books.index') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Browse
            </a>
        </div>

        {{-- Book Details Card --}}
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                
                {{-- Book Cover Section --}}
                <div class="md:w-1/3 bg-gradient-to-br from-blue-100 to-indigo-200 p-8 flex items-center justify-center">
                    <div class="text-center">
                        <div class="bg-white rounded-lg shadow-xl p-8 inline-block">
                            <svg class="w-32 h-32 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Book Information Section --}}
                <div class="md:w-2/3 p-8">
                    
                    {{-- Availability Badge --}}
                    <div class="mb-4">
                        @if($book->isActive ?? true)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200">
                                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse"></span>
                                Available for borrowing
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 border border-red-200">
                                <span class="w-2 h-2 mr-2 bg-red-500 rounded-full"></span>
                                Currently borrowed
                            </span>
                        @endif
                    </div>

                    {{-- Book Title --}}
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $book->name }}</h1>
                    
                    {{-- Author --}}
                    <p class="text-xl text-gray-600 mb-6">by {{ $book->author }}</p>

                    {{-- Book Details Grid --}}
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        
                        <div class="border-l-4 border-blue-500 pl-4">
                            <p class="text-sm font-medium text-gray-500 uppercase mb-1">ISBN</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $book->isbn }}</p>
                        </div>

                        <div class="border-l-4 border-purple-500 pl-4">
                            <p class="text-sm font-medium text-gray-500 uppercase mb-1">Category</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $book->category->name ?? 'Uncategorized' }}</p>
                        </div>

                        <div class="border-l-4 border-indigo-500 pl-4">
                            <p class="text-sm font-medium text-gray-500 uppercase mb-1">Date Added</p>
                            <p class="text-lg font-semibold text-gray-900">{{ \Carbon\Carbon::parse($book->date_added)->format('M d, Y') }}</p>
                        </div>

                        <div class="border-l-4 border-teal-500 pl-4">
                            <p class="text-sm font-medium text-gray-500 uppercase mb-1">Status</p>
                            <p class="text-lg font-semibold {{ ($book->isActive ?? true) ? 'text-green-600' : 'text-red-600' }}">
                                {{ ($book->isActive ?? true) ? 'In Library' : 'On Loan' }}
                            </p>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-4">
                        @if($book->isActive && $book->available_stock > 0)
                            {{-- Borrow Form --}}
                            <form action="{{ route('student.books.borrow', $book->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to borrow this book?');"
                                        class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition transform hover:scale-105 shadow-md flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    Borrow Now
                                </button>
                            </form>
                        @else
                            <button disabled 
                                    class="flex-1 bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-medium cursor-not-allowed">
                                Currently Unavailable
                            </button>
                        @endif
                        
                        <button onclick="alert('Added to reading list!')" 
                                class="px-6 py-3 border-2 border-blue-600 text-blue-600 rounded-lg font-medium hover:bg-blue-50 transition">
                            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                            Save
                        </button>
                    </div>

                    {{-- Additional Info --}}
                    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h4 class="text-sm font-medium text-blue-900 mb-1">Borrowing Information</h4>
                                <p class="text-sm text-blue-700">Books can be borrowed for up to 14 days. Visit the library desk with your student ID to check out this book.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Books Section --}}
        @if(isset($relatedBooks) && count($relatedBooks) > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">More from this Category</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($relatedBooks as $relatedBook)
                <a href="{{ route('student.books.show', $relatedBook->id) }}" class="group">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
                        <div class="bg-gradient-to-br from-gray-100 to-gray-200 h-48 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                        </div>
                        <div class="p-3">
                            <h3 class="font-medium text-sm text-gray-900 group-hover:text-blue-600 truncate">{{ $relatedBook->name }}</h3>
                            <p class="text-xs text-gray-600 truncate">{{ $relatedBook->author }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection