<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'isbn',
        'author',
        'category_id',
        'isActive',
        'date_added',
        'stock',
    ];

    protected $casts = [
        'isActive' => 'boolean',
        'date_added' => 'datetime',
        'category_id' => 'integer',
    ];

    public function getBorrowedCountAttribute()
    {
        return $this->transactions()
            ->whereNull('date_added') // Assuming null date_added means not returned
            ->count();
    }

    public function getAvailableStockAttribute()
    {
        return $this->stock - $this->borrowedCount;
    }

    public function getIsAvailableAttribute()
    {
        return $this->isActive && $this->availableStock > 0;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'book_id');
    }
}
