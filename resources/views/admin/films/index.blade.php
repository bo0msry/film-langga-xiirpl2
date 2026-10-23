@extends('templates.index')

@section('content')
<div class="container" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="row">
        <div class="col-md-12">
            <div class="tittle-head">
                <h4 class="latest-text">Film Management (Admin)</h4>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div style="margin-bottom: 20px;">
                <a href="{{ route('admin.films.create') }}" class="btn btn-primary">Tambah Film</a>
                <a href="{{ route('home') }}" class="btn btn-default">Kembali ke Home</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Poster</th>
                            <th>Judul</th>
                            <th>Genre</th>
                            <th>Tahun</th>
                            <th>Pemeran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($films as $film)
                        <tr>
                            <td>{{ ($films->currentPage() - 1) * $films->perPage() + $loop->iteration }}</td>
                            <td>
                                @if($film->poster)
                                    <img src="{{ $film->posterUrl() }}" alt="{{ $film->title }}" style="height: 80px;">
                                @endif
                            </td>
                            <td>{{ $film->title }}</td>
                            <td>{{ $film->genre ? $film->genre->name : '-' }}</td>
                            <td>{{ $film->year }}</td>
                            <td>
                                @if($film->cast && $film->cast->count() > 0)
                                    @foreach($film->cast as $pemeran)
                                        <span class="label label-info" style="margin-right:3px;">{{ $pemeran->name }}@if($pemeran->pivot && $pemeran->pivot->actor) ({{ $pemeran->pivot->actor }})@endif</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.films.show', $film->id) }}" class="btn btn-info btn-xs">Lihat</a>
                                <a href="{{ route('admin.films.edit', $film->id) }}" class="btn btn-warning btn-xs">Edit</a>
                                <form action="{{ route('admin.films.destroy', $film->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus film ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data film.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $films->links() }}
        </div>
    </div>
</div>
@endsection
