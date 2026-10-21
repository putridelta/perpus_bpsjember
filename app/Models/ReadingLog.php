<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReadingLog extends Model
{
    use HasFactory;

    protected $table = 'reading_logs';

    protected $fillable = [
        'user_id',
        'book_id',
        'user_name',
        'ip_address',
        'read_duration_minutes',
        'activity_note',
    ];

    /**
     * Get the user that made the reading log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book being read.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }
}
