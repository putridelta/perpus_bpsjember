<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';

    protected $fillable = [
        'user_id',
        'book_id',
    ];

    /**
     * Get the user that favorited the book.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book that was favorited.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
