<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'file_cover',
        'file_books',
        'name',
        'author',
        'publisher',
        'published_year',
        'isbn',
        'describe',
        'category_id',
        'status',
        'views_count',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_year' => 'integer',
            'category_id' => 'integer',
            'views_count' => 'integer',
        ];
    }

    /**
     * Get the category that owns the book.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get reading logs for this book.
     */
    public function readingLogs(): HasMany
    {
        return $this->hasMany(ReadingLog::class);
    }

    /**
     * Get favorites for this book.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Accessor for full cover image URL with fallback.
     */
    public function getCoverUrlAttribute(): string
    {
        $cover = $this->file_cover;

        if (! empty($cover)) {
            if (str_starts_with($cover, 'http://') || str_starts_with($cover, 'https://')) {
                return $cover;
            }

            if (file_exists(public_path($cover))) {
                return asset($cover);
            }

            if (file_exists(storage_path('app/public/'.$cover))) {
                return asset('storage/'.$cover);
            }

            // Check if there is an alternative extension
            $cleanPath = preg_replace('/\.(webp|svg|jpg|jpeg|png)$/i', '', (string) $cover);
            foreach (['jpg', 'webp', 'jpeg', 'svg', 'png'] as $ext) {
                if (file_exists(public_path("{$cleanPath}.{$ext}"))) {
                    return asset("{$cleanPath}.{$ext}");
                }
            }
        }

        return asset('assets/images/cover-buku1.jpg');
    }

    /**
     * Accessor for full PDF file URL.
     */
    public function getPdfUrlAttribute(): string
    {
        $pdf = $this->file_books;

        if (! empty($pdf)) {
            if (str_starts_with($pdf, 'http://') || str_starts_with($pdf, 'https://')) {
                return $pdf;
            }

            if (file_exists(public_path($pdf))) {
                return asset($pdf);
            }

            if (file_exists(storage_path('app/public/'.$pdf))) {
                return asset('storage/'.$pdf);
            }
        }

        return asset('assets/file/pdf/file1.pdf');
    }

    /**
     * Scope for keyword search (title, author, publisher, description, isbn, or published year).
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (empty($term)) {
            return $query;
        }

        $term = trim($term);

        return $query->where(function (Builder $q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('author', 'like', "%{$term}%")
                ->orWhere('publisher', 'like', "%{$term}%")
                ->orWhere('isbn', 'like', "%{$term}%")
                ->orWhere('describe', 'like', "%{$term}%")
                ->orWhere('published_year', 'like', "%{$term}%");
        });
    }

    /**
     * Scope for category filter.
     */
    public function scopeFilterCategory(Builder $query, $category): Builder
    {
        if (empty($category) || $category === 'all') {
            return $query;
        }

        if (is_numeric($category)) {
            return $query->where('category_id', (int) $category);
        }

        return $query->whereHas('category', function (Builder $q) use ($category) {
            $q->where('name', $category);
        });
    }

    /**
     * Scope for status filter.
     */
    public function scopeFilterStatus(Builder $query, ?string $status): Builder
    {
        if (empty($status) || $status === 'all') {
            return $query;
        }

        return $query->where('status', $status);
    }

    /**
     * Scope for year filter.
     */
    public function scopeFilterYear(Builder $query, $year): Builder
    {
        if (empty($year) || $year === 'all') {
            return $query;
        }

        return $query->where('published_year', (int) $year);
    }
}
