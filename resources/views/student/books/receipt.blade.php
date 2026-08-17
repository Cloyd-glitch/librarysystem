@extends('layouts.student')

@section('title', 'Borrowing Receipt')

@section('content')
<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Success Message --}}
        @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        {{-- Receipt Card --}}
        <div class="bg-white rounded-lg shadow-xl overflow-hidden print:shadow-none" id="receipt-area">
            {{-- Receipt Header --}}
            <div class="bg-blue-600 px-6 py-4 text-white text-center print:bg-white print:text-black">
                <h2 class="text-2xl font-bold uppercase tracking-wider">Official Receipt</h2>
                <p class="text-blue-100 text-sm print:text-gray-600">University Library System</p>
            </div>

            <div class="p-8">
                {{-- Transaction ID --}}
                <div class="text-center mb-8 border-b pb-6">
                    <p class="text-gray-500 text-sm uppercase mb-1">Transaction No.</p>
                    <p class="text-2xl font-mono font-bold text-gray-900">{{ $transaction->txn_no }}</p>
                </div>

                {{-- Details Grid --}}
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Student Name:</span>
                        <span class="font-medium text-gray-900 text-right">{{ $transaction->student->firstname }} {{ $transaction->student->lastname }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Student ID:</span>
                        <span class="font-medium text-gray-900 text-right">{{ $transaction->student->student_id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Book Borrowed:</span>
                        <span class="font-medium text-gray-900 text-right">{{ $transaction->book->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">ISBN:</span>
                        <span class="font-medium text-gray-900 text-right">{{ $transaction->book->isbn }}</span>
                    </div>
                    <div class="border-t border-dashed my-4"></div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Date Borrowed:</span>
                        <span class="font-medium text-gray-900 text-right">{{ \Carbon\Carbon::parse($transaction->date_borrowed)->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-red-600 font-medium">Due Date:</span>
                        <span class="font-bold text-red-600 text-right">{{ \Carbon\Carbon::parse($transaction->due_date)->format('M d, Y') }}</span>
                    </div>
                </div>

                {{-- Barcode / Footer --}}
                <div class="text-center pt-4">
                    <div class="inline-block bg-gray-100 rounded px-4 py-2 mb-2">
                        <p class="font-mono text-xs text-gray-500 tracking-widest">AUTHORIZED TRANSACTION</p>
                    </div>
                    <p class="text-xs text-gray-400">Please present this receipt if requested by the librarian.</p>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center print:hidden">
            <button onclick="window.print()" class="flex-1 bg-gray-800 text-white px-6 py-3 rounded-lg font-medium hover:bg-gray-900 transition flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Receipt
            </button>
            <a href="{{ route('student.dashboard') }}" class="flex-1 bg-white border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-50 transition text-center">
                Back to Dashboard
            </a>
        </div>

    </div>
</div>

{{-- Print Styles --}}
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #receipt-area, #receipt-area * {
            visibility: visible;
        }
        #receipt-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none;
        }
    }
</style>
@endsection