<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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
        'avatar',
    ];

    /** هنرمند مربوط به این کاربر */
    public function artist()
    {
        return $this->hasOne(Artist::class);
    }


    // پلی‌لیست‌های کاربر
    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }


    public function likes()
    {
        return $this->belongsToMany(Song::class, 'likes');
    }

    // هنرمندانی که دنبال کرده
    public function follows()
    {
        return $this->belongsToMany(Artist::class, 'follows');
    }


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
}
