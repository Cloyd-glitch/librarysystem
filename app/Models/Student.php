<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'lastname',
        'firstname',
        'middlename',
        'email',
        'course',
        'year_level',
    ];

    protected $casts = [
        'year_level' => 'integer',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'student_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->firstname} {$this->middlename} {$this->lastname}";
    }
}