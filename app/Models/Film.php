<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Film extends Model
{
    use HasFactory;

    protected $table = 'films';

    protected $fillable = ['title', 'sinopsis', 'year', 'poster', 'genre_id'];

    /**
     * Resolve the public URL for the film poster.
     */
    public function posterUrl(): string
    {
        $poster = trim((string) $this->poster);

        if ($poster === '') {
            return '';
        }

        // Remote images are already full URLs.
        if (Str::startsWith($poster, ['http://', 'https://', '//'])) {
            return $poster;
        }

        $poster = ltrim($poster, '/');

        // Paths that already point to a public location (storage/..., images/...).
        if (Str::startsWith($poster, ['storage/', 'images/'])) {
            return asset($poster);
        }

        // Legacy values that only contain the file name on the public disk.
        return asset('storage/'.$poster);
    }

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
