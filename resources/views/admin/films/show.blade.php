@extends('templates.index')

@section('content')
<div class="container" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="tittle-head">
                <h4 class="latest-text">Detail Film</h4>
            </div>
            <a href="{{ route('admin.films.index') }}" class="btn btn-default" style="margin-bottom: 20px;">Kembali ke Daftar</a>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{ $film->title }}</h3>
                </div>
                <div class="panel-body">
                    @if($film->poster)
                        <div style="margin-bottom: 15px;">
                            <img src="{{ asset($film->poster) }}" alt="{{ $film->title }}" style="max-height: 300px;">
                        </div>
                    @endif
                    <p><strong>Genre:</strong> {{ $film->genre ? $film->genre->name : '-' }}</p>
                    <p><strong>Tahun:</strong> {{ $film->year }}</p>
                    <p><strong>Pemeran:</strong></p>
                    <p>
                        @if($film->cast && $film->cast->count() > 0)
                            @foreach($film->cast as $pemeran)
                                <span class="label label-info" style="margin-right:3px;">{{ $pemeran->name }}@if($pemeran->pivot && $pemeran->pivot->actor) ({{ $pemeran->pivot->actor }})@endif</span>
                            @endforeach
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </p>
                    <p><strong>Sinopsis:</strong></p>
                    <p>{{ $film->sinopsis }}</p>
                </div>

                <div class="panel-footer">
                    <a href="{{ route('admin.films.edit', $film->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.films.destroy', $film->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus film ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
