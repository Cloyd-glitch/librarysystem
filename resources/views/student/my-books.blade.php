@extends('layouts.student')

@section('title', 'My Borrowed Books')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">My Borrowed Books</h1>
            <p class="text-gray-600">Manage your current loans and view borrowing history</p>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <p class="text-sm font-medium text-gray-600 uppercase mb-1">Active Loans</p>
                <p class="text-3xl font-bold text-gray-900">{{ $activeLoans ?? 0 }}</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                <p class="text-sm font-medium text-gray-600 uppercase mb-1">Overdue</p>
                <p class="text-3xl font-bold text-red-600">{{ $overdueLoans ?? 0 }}</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <p class="text-sm font-medium text-gray-600 uppercase mb-1">Returned</p>
                <p class="text-3xl font-bold text-gray-900">{{ $returnedLoans ?? 0 }}</p>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button onclick="showTab('current')" id="tab-current" 
                            class="tab-button border-b-2 border-blue-500 text-blue-600 py-4 px-1 text-sm font-medium">
                        Current Loans
                    </button>
                    <button onclick="showTab('history')" id="tab-history" 
                            class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium">
                        History
                    </button>
                </nav>
            </div>
        </div>

        {{-- Current Loans Tab --}}
        <div id="content-current" class="tab-content">
            @if(isset($currentTransactions) && count($currentTransactions) > 0)
                <div class="space-y-4">
                    @foreach($currentTransactions as $transaction)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                
                                {{-- Book Info --}}
                                <div class="flex items-start mb-4 md:mb-0 flex-1">
                                    <div class="bg-gradient-to-br from-blue-100 to-indigo-200 rounded-lg w-20 h-24 flex items-center justify-center mr-4 flex-shrink-0">
                                        <svg class="w-10 h-10 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                        </svg>
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $transaction->book->name }}</h3>
                                        <p class="text-sm text-gray-600 mb-2">by {{ $transaction->book->author }}</p>
                                        <p class="text-xs text-gray-500">Transaction #{{ $transaction->txn_no }}</p>
                                    </div>
                                </div>

                                {{-- Date Info --}}
                                <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-8">
                                    <div class="text-sm">
                                        <p class="text-gray-500 mb-1">Borrowed</p>
                                        <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($transaction->date_borrowed)->format('M d, Y') }}</p>
                                    </div>
                                    
                                    <div class="text-sm">
                                        <p class="text-gray-500 mb-1">Due Date</p>
                                        <p class="font-medium {{ \Carbon\Carbon::parse($transaction->due_date)->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                                            {{ \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y') }}
                                        </p>
                                    </div>

                                    <div>
                                        @if(\Carbon\Carbon::parse($transaction->due_date)->isPast())
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                Overdue
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Active
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Overdue Warning --}}
                            @if(\Carbon\Carbon::parse($transaction->due_date)->isPast())
                            <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-3">
                                <p class="text-sm text-red-800">
                                    <span class="font-medium">⚠️ This book is overdue.</span> 
                                    Please return it to the library as soon as possible to avoid late fees.
                                </p>
                            </div>
                            @endif

                            {{-- Due Soon Warning --}}
                            @php
                                $dueDate = \Carbon\Carbon::parse($transaction->due_date);
                                $now = \Carbon\Carbon::now();
                                // Calculate difference in days (ignoring time for cleaner logic)
                                $daysUntilDue = $now->diffInDays($dueDate, false);
                            @endphp

                            {{-- Only show if NOT overdue (days >= 0) AND due within 3 days --}}
                            @if($daysUntilDue >= 0 && $daysUntilDue <= 7)
                            <div class="mt-4 bg-amber-50 border border-amber-200 rounded-lg p-3">
                                <p class="text-sm text-amber-800">
                                    <span class="font-medium">📅 Due soon:</span> 
                                    {{-- Use ceil() to round up (e.g., 0.5 days becomes "1 day") --}}
                                    This book is due in {{ ceil($daysUntilDue) }} day(s).
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No active loans</h3>
                    <p class="text-gray-600 mb-4">You don't have any books borrowed at the moment</p>
                    <a href="{{ route('student.books.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Browse Books
                    </a>
                </div>
            @endif
        </div>

        {{-- History Tab --}}
        <div id="content-history" class="tab-content hidden">
            @if(isset($historyTransactions) && count($historyTransactions) > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Borrowed</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Returned</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($historyTransactions as $transaction)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="bg-gray-200 rounded w-10 h-12 flex items-center justify-center mr-3">
                                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $transaction->book->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $transaction->book->author }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($transaction->date_borrowed)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($transaction->date_added)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Returned
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No borrowing history</h3>
                    <p class="text-gray-600">Your past transactions will appear here</p>
                </div>
            @endif
        </div>

    </div>
</div>

<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active styles from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Add active styles to selected tab button
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.remove('border-transparent', 'text-gray-500');
    activeButton.classList.add('border-blue-500', 'text-blue-600');
}
</script>
@endsection