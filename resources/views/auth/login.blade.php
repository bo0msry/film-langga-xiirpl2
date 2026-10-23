@extends('templates.index')

@section('content')
<div class="container" style="padding-top: 50px; padding-bottom: 50px;">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="tittle-head">
                <h4 class="latest-text">Login</h4>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.attempt') }}" method="POST">
                @csrf
                @if (request('redirect'))
                    <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                @endif
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                <a href="{{ route('home') }}" class="btn btn-default">Kembali</a>
                <p style="margin-top: 15px;">
                    Belum punya akun?
                    <a href="{{ route('register', request('redirect') ? ['redirect' => request('redirect')] : []) }}">Daftar sekarang</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
