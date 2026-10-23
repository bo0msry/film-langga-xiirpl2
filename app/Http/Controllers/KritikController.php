<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKritikRequest;
use App\Http\Requests\UpdateKritikRequest;
use App\Models\Film;
use App\Models\Kritik;
use Illuminate\Support\Facades\Auth;

class KritikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKritikRequest $request, Film $film)
    {
        $film->kritik()->create([
            'user_id' => Auth::id(),
            'isi' => $request->validated('isi'),
        ]);

        return redirect()
            ->route('movies.show', $film->id)
            ->with('success', 'Komentar berhasil dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kritik $kritik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kritik $kritik)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKritikRequest $request, Kritik $kritik)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kritik $kritik)
    {
        //
    }
}
