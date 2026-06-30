@extends('layouts.app')

@section('title', 'Booking Berhasil - PureStrands')

@section('header')
    <div></div>
    <div class="header-title">Booking Berhasil</div>
    <div></div>
@endsection

@section('content')
<div class="success-container">
    <div class="success-icon-wrapper">
        <i class="fa-solid fa-calendar-check"></i>
    </div>
    <h2 class="success-title">Booking Berhasil!</h2>
    <p class="success-message">
        Jadwal konsultasi Anda dengan <strong>{{ $booking->expert->name }}</strong> telah dikonfirmasi.
    </p>

    <div style="background: white; border: 1px solid var(--border); border-radius: 14px; padding: 16px; margin-bottom: 24px; text-align: left;">
        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid var(--border);">
            <span style="color: var(--text-muted);">Dokter</span>
            <span style="font-weight: 700;">{{ $booking->expert->name }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 10px;">
            <span style="color: var(--text-muted);">Spesialisasi</span>
            <span style="font-weight: 600;">{{ $booking->expert->specialty }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 10px;">
            <span style="color: var(--text-muted);">Tanggal</span>
            <span style="font-weight: 700; color: var(--primary);">
                {{ \Carbon\Carbon::parse($booking->schedule->date)->format('d M Y') }}
            </span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 10px;">
            <span style="color: var(--text-muted);">Jam</span>
            <span style="font-weight: 700; color: var(--primary);">{{ $booking->schedule->time_slot }} WIB</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 0.85rem;">
            <span style="color: var(--text-muted);">Tipe</span>
            <span class="history-status-badge badge-paid">{{ $booking->type }}</span>
        </div>
    </div>

    <a href="{{ route('profile') }}" class="btn btn-primary" style="margin-bottom: 12px;">
        <i class="fa-solid fa-clock-rotate-left"></i> Lihat Riwayat Booking
    </a>
    <a href="{{ route('experts') }}" class="btn btn-secondary">
        <i class="fa-solid fa-user-doctor"></i> Lihat Dokter Lain
    </a>
    <a href="{{ route('home') }}" style="display: block; text-align: center; margin-top: 14px; font-size: 0.85rem; color: var(--text-muted); text-decoration: none;">Kembali ke Beranda</a>
</div>
@endsection
