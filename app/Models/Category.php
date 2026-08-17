<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'isActive',
        'date_added',
    ];

    protected $casts = [
        'isActive' => 'boolean',
        'date_added' => 'datetime',
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'category_id');
    }
}