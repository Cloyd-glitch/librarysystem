<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
           $table->id();
            $table->string('txn_no');
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('book_id')->constrained('books');
            $table->dateTime('date_borrowed');
            $table->dateTime('date_added')->useCurrent();
            $table->date('due_date');
            $table->string('by');
            $table->dateTime('date_returned')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
