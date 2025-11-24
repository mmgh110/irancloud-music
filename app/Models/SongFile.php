<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongFile extends Model
{
    use HasFactory;

    protected $fillable = ['song_id', 'quality', 'file_url'];

    public function song()
    {
        return $this->belongsTo(Song::class);
    }
}
