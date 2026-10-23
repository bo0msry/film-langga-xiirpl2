@extends('templates.index')

@section('content')
<div class="container" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="tittle-head">
                <h4 class="latest-text">Tambah Film</h4>
            </div>
            <a href="{{ route('admin.films.index') }}" class="btn btn-default" style="margin-bottom: 20px;">Kembali</a>
            <form action="{{ route('admin.films.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Judul Film</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="genre_id">Genre</label>
                    <select class="form-control" id="genre_id" name="genre_id" required>
                        <option value="">Pilih Genre</option>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ old('genre_id') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                        @endforeach
                    </select>
                    @error('genre_id')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="year">Tahun</label>
                    <input type="number" class="form-control" id="year" name="year" value="{{ old('year') }}" required>
                    @error('year')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="poster">Poster (gambar)</label>
                    <input type="file" class="form-control" id="poster" name="poster">
                    @error('poster')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="sinopsis">Sinopsis</label>
                    <textarea class="form-control" id="sinopsis" name="sinopsis" rows="6" required>{{ old('sinopsis') }}</textarea>
                    @error('sinopsis')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
