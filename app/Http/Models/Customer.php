<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = ['name', 'email', 'phone_number', 'password'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    public function borrowings()
    {
        return $this->belongsToMany(Book::class, 'borrowings')
            ->withPivot(['borrowing_date', 'return_date', 'is_returned'])
            ->withTimestamps();
    }
}
