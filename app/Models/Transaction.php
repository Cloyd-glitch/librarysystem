<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'txn_no',
        'student_id',
        'book_id',
        'date_borrowed',
        'by',
        'date_added',
        'due_date',
        'date_returned',
    ];

    protected $casts = [
        'date_borrowed' => 'datetime',
        'date_added' => 'datetime',
        'due_date' => 'date',
        'student_id' => 'integer',
        'book_id' => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function isOverdue()
    {
        return $this->due_date < now();
    }
}