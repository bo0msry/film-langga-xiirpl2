<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $table = 'films';

    protected $fillable = ['title', 'sinopsis', 'year', 'poster', 'genre_id'];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function cast()
    {
        return $this->belongsToMany(Cast::class, 'perans', 'film_id', 'cast_id')
            ->withPivot('actor')
            ->withTimestamps();
    }

    /**
     * Relasi Many-to-Many dengan Cast lewat tabel pivot cast_movie.
     */
    public function castMovie()
    {
        return $this->belongsToMany(Cast::class, 'cast_movie', 'film_id', 'cast_id')
            ->withPivot('role')
            ->withTimestamps();
    }
}
