<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    protected $table = 'musics';

    protected $fillable = [
        'name',
        'cover',
        'length',
        'file',
        'date_of_creation',
        'user_id',
        'album_id'
    ];

    public $timestamps = false;

    protected $with=['album'];

    public function playlists() {
        return $this->belongsToMany(Playlist::class, 'pivot_table_playlist_musics');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function album() {
        return $this->belongsTo(Album::class);
    }

}
