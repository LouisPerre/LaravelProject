<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cover',
        'visibility',
        'created_at',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function musics() {
        return $this->belongsToMany(Music::class, 'pivot_table_playlist_musics');
    }
}
