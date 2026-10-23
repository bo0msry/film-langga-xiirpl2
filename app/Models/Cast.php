<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    use HasFactory;

    protected $table = 'casts';

    protected $fillable = ['name', 'age', 'bio'];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'perans', 'cast_id', 'film_id')
            ->withPivot('actor')
            ->withTimestamps();
    }

    /**
     * Relasi Many-to-Many dengan Film lewat tabel pivot cast_movie.
     */
    public function castMovie()
    {
        return $this->belongsToMany(Film::class, 'cast_movie', 'cast_id', 'film_id')
            ->withPivot('role')
            ->withTimestamps();
    }
}
