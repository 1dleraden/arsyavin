<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<BookFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'author',
        'publisher',
        'year',
        'category',
        'stock',
        'available_stock',
        'shelf_location',
        'cover_url',
        'description',
    ];

    /**
     * Get loans associated with this book.
     */
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Get active loans.
     */
    public function activeLoans()
    {
        return $this->hasMany(Loan::class)->where('status', 'borrowed');
    }
}
