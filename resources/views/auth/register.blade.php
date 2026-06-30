@extends('layouts.app')

@section('title', 'Register - PureStrands')

@section('header')
    <a href="{{ route('login') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">Daftar Akun</div>
    <div></div>
@endsection

@section('content')
<div class="auth-container">
    <div class="auth-logo-wrapper">
        <h2 class="auth-title">Buat Akun Baru</h2>
        <p class="auth-subtitle">Gabung bersama PureStrands hari ini</p>
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

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label" for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" class="form-input" placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-input" placeholder="contoh@gmail.com" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="phone">Nomor Telepon</label>
            <input type="text" id="phone" name="phone" class="form-input" placeholder="Contoh: 08123456789" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label class="form-label" for="address">Alamat Pengiriman</label>
            <textarea id="address" name="address" class="form-textarea" rows="3" placeholder="Masukkan alamat lengkap Anda">{{ old('address') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-input" placeholder="Minimal 6 karakter" required>
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Ulangi password" required>
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 24px;">Daftar</button>
    </form>

    <div class="auth-footer">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
    </div>
</div>
@endsection
