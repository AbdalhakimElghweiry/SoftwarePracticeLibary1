<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['name', 'author', 'ISBN', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowings()
    {
        return $this->belongsToMany(Customer::class, 'borrowings')
            ->withPivot(['borrowing_date', 'return_date', 'is_returned'])
            ->withTimestamps();
    }
}
