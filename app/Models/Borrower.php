<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_borrower')->withPivot('borrowed_at', 'returned_at')->withTimestamps();
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
