<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Genre;
use App\Http\Requests\StoreFilmRequest;
use App\Http\Requests\UpdateFilmRequest;
use Illuminate\Support\Facades\Storage;

class AdminFilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $films = Film::with(['genre', 'cast'])->orderByDesc('created_at')->paginate(10);
        return view('admin.films.index', compact('films'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::all();
        return view('admin.films.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFilmRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('posters', 'public');
            $data['poster'] = 'storage/' . $path;
        }

        Film::create($data);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        $film->load('cast');
        return view('admin.films.show', compact('film'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Film $film)
    {
        $genres = Genre::all();
        return view('admin.films.edit', compact('film', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilmRequest $request, Film $film)
    {
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('posters', 'public');
            $data['poster'] = 'storage/' . $path;
        }

        $film->update($data);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Film $film)
    {
        $film->delete();
        return redirect()->route('admin.films.index')->with('success', 'Film berhasil dihapus!');
    }
}
