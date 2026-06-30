@extends('layouts.app')

@section('title', 'Dokter Ahli - PureStrands')

@section('header')
    <a href="{{ route('home') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">Konsultasi Dokter</div>
    <div></div>
@endsection

@section('content')
{{-- Top Banner --}}
<div class="promo-banner" style="margin-bottom: 20px;">
    <span class="promo-banner-badge"><i class="fa-solid fa-user-doctor"></i> Spesialis Rambut & Kulit</span>
    <h3 class="promo-banner-title">Konsultasi Langsung ke Ahlinya</h3>
    <p class="promo-banner-subtitle">Hair stylist & dermatologi profesional siap membantu kesehatan rambut Anda.</p>
</div>

{{-- Specialty Filter --}}
<div class="category-filter-list">
    <a href="{{ route('experts') }}" class="category-filter-item {{ empty($activeSpecialty) ? 'active' : '' }}">Semua</a>
    <a href="{{ route('experts', ['specialty' => 'Dermatologi']) }}" class="category-filter-item {{ $activeSpecialty === 'Dermatologi' ? 'active' : '' }}">Dermatologi</a>
    <a href="{{ route('experts', ['specialty' => 'Hair Stylist']) }}" class="category-filter-item {{ $activeSpecialty === 'Hair Stylist' ? 'active' : '' }}">Hair Stylist</a>
</div>

<div style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 16px; font-weight: 600;">
    {{ $experts->count() }} Dokter Tersedia
</div>

{{-- Experts List --}}
<div class="expert-list">
    @foreach($experts as $index => $expert)
    <div class="expert-card">
        <div class="expert-photo-wrapper">
            <div style="width: 76px; height: 76px; border-radius: 14px; background: linear-gradient(135deg, var(--primary-light), #c6eed9); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 700; color: var(--primary);">
                {{ substr($expert->name, 4, 1) }}
            </div>
            @if($index % 2 === 0)
                <span class="status-badge-online">Online</span>
            @endif
        </div>

        <div class="expert-info">
            <div class="expert-name">{{ $expert->name }}</div>
            <div class="expert-specialty">{{ $expert->profile }}</div>
            <div class="expert-meta">
                <span><i class="fa-solid fa-star"></i> {{ $expert->rating }}</span>
                <span><i class="fa-regular fa-clock"></i> {{ $expert->experience }}</span>
            </div>
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <span class="expert-price">Rp {{ number_format($expert->price, 0, ',', '.') }}/sesi</span>
                <a href="{{ route('experts.detail', $expert->id) }}" class="btn btn-primary" style="width: auto; padding: 8px 16px; font-size: 0.8rem; display: inline-block;">
                    Booking
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
