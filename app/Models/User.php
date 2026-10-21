<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'phone',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Reading logs for this user.
     */
    public function readingLogs(): HasMany
    {
        return $this->hasMany(ReadingLog::class);
    }

    /**
     * Favorites for this user.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Check if user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user account is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Get count of unique books read by this user.
     */
    public function getBooksReadCountAttribute(): int
    {
        return $this->readingLogs()->distinct('book_id')->count('book_id');
    }

    /**
     * Get avatar url or fallback.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
                return $this->avatar;
            }
            if (file_exists(public_path($this->avatar))) {
                return asset($this->avatar);
            }
            if (file_exists(storage_path('app/public/'.$this->avatar))) {
                return asset('storage/'.$this->avatar);
            }
        }

        // Initials avatar fallback
        $name = urlencode($this->name);

        return "https://ui-avatars.com/api/?name={$name}&background=082b62&color=ffffff&bold=true";
    }
}
