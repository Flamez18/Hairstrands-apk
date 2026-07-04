@extends('layouts.app')

@section('title', 'Login - PureStrands')

@section('header')
    <div></div>
    <div class="header-title">PureStrands</div>
    <div></div>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-logo-wrapper">
        <!-- PureStrands Logo Icon -->
        <i class="fa-solid fa-scissors" style="font-size: 3rem; color: var(--primary);"></i>
        <h2 class="auth-title">PureStrands</h2>
        <p class="auth-subtitle">Masuk ke akun Anda untuk berkonsultasi & berbelanja</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="list-style: none;">
                @foreach ($errors->all() as $error)
                    <li><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-input" placeholder="contoh@gmail.com" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-input" placeholder="Masukkan password" required>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 24px;">Masuk</button>
    </form>

    <div class="auth-footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
    </div>
</div>
@endsection
