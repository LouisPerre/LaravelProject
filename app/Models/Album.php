<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cover',
        'date_of_creation',
        'user_id'
    ];

    public function musics() {
        return $this->hasMany(Music::class);
    }

    public function users() {
        return $this->belongsTo(User::class);
    }
}
