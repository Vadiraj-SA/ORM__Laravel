<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'author_id', 'published_year', 'available', 'borrowed_at', 'returned_at'
    ];
    
    protected $dates = ['borrowed_at', 'returned_at'];
    
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function borrowers()
    {
        return $this->belongsToMany(Borrower::class, 'book_borrower')->withPivot('borrowed_at', 'returned_at')->withTimestamps();
    }
    
}
