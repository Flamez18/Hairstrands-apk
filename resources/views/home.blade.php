@extends('layouts.app')

@section('title', 'PureStrands - Home')

@section('header')
    <div style="display: flex; align-items: center; gap: 8px;">
        <i class="fa-solid fa-scissors" style="color: var(--primary); font-size: 1.25rem;"></i>
        <span style="font-weight: 800; font-size: 1.1rem; color: var(--primary); letter-spacing: -0.5px;">PureStrands</span>
    </div>
    <form action="{{ route('marketplace') }}" method="GET" style="flex: 1; margin: 0 12px; position: relative;">
        <input type="text" name="q" class="search-input" placeholder="Pencarian..." style="padding: 8px 12px 8px 32px; font-size: 0.8rem; margin: 0; background-color: #f3f4f6; border-radius: 20px;">
        <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); font-size: 0.75rem; color: var(--text-muted);"></i>
    </form>
    <a href="{{ route('cart') }}" class="cart-icon-btn">
        <i class="fa-solid fa-cart-shopping"></i>
        @php
            $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
            $cartCount = $cart ? $cart->items()->sum('quantity') : 0;
        @endphp
        @if($cartCount > 0)
            <span class="cart-badge">{{ $cartCount }}</span>
        @endif
    </a>
@endsection

@section('content')
<!-- Top Hero Banner -->
<div class="promo-banner">
    <span class="promo-banner-badge">Start Transforming Today</span>
    <h3 class="promo-banner-title">Dapatkan Solusi Rambut Sehat Alami</h3>
    <p class="promo-banner-subtitle">Konsultasi dokter & produk pilihan terbaik untuk Anda</p>
</div>

<!-- User Card -->
<a href="{{ route('profile') }}" style="text-decoration: none; color: inherit;">
    <div class="user-card">
        <div class="user-card-left">
            <div class="user-avatar" style="display: flex; align-items: center; justify-content: center; background-color: var(--primary-light); color: var(--primary); font-weight: bold; font-size: 1.2rem;">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <div class="user-name-title">Halo, {{ $user->name }} 👋</div>
                <span class="user-role-badge"><i class="fa-solid fa-star"></i> PREMIUM MEMBER</span>
            </div>
        </div>
        <i class="fa-solid fa-chevron-right" style="color: var(--text-muted); font-size: 0.9rem;"></i>
    </div>
</a>

<!-- Menu Utama -->
<div class="menu-section-title">Menu Utama</div>
<div class="menu-grid">
    <a onclick="alert('HairJourney is on our next feature roadmap!')" class="menu-item">
        <div class="menu-item-icon-wrapper" style="background-color: #e6fcf6; color: var(--accent);">
            <i class="fa-regular fa-calendar-check"></i>
        </div>
        <span class="menu-item-name">HairJourney</span>
    </a>
    <a href="{{ route('profile') }}#history" class="menu-item">
        <div class="menu-item-icon-wrapper" style="background-color: #fffbeb; color: #d97706;">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
        <span class="menu-item-name">History</span>
    </a>
    <a onclick="alert('Subscription is coming soon in future releases!')" class="menu-item">
        <div class="menu-item-icon-wrapper" style="background-color: #fef2f2; color: #ef4444;">
            <i class="fa-regular fa-gem"></i>
        </div>
        <span class="menu-item-name">Subscription</span>
    </a>
    <a href="{{ route('marketplace') }}" class="menu-item">
        <div class="menu-item-icon-wrapper" style="background-color: #eff6ff; color: #2563eb;">
            <i class="fa-solid fa-box-open"></i>
        </div>
        <span class="menu-item-name">Produk</span>
    </a>
    <a onclick="alert('AI Hair Scan is currently on our development roadmap!')" class="menu-item">
        <div class="menu-item-icon-wrapper" style="background-color: #faf5ff; color: #7c3aed;">
            <i class="fa-solid fa-wand-magic-sparkles"></i>
        </div>
        <span class="menu-item-name">Scan</span>
    </a>
    <a href="{{ route('experts') }}" class="menu-item">
        <div class="menu-item-icon-wrapper" style="background-color: #f0fdf4; color: #16a34a;">
            <i class="fa-solid fa-user-doctor"></i>
        </div>
        <span class="menu-item-name">Dokter</span>
    </a>
</div>

<!-- Video Section -->
<div class="menu-section-title">Panduan Perawatan</div>
<div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-bottom: 20px;">
    <!-- Video Card 1 -->
    <div style="background-color: white; border-radius: 12px; border: 1px solid var(--border); overflow: hidden;">
        <div style="background: linear-gradient(135deg, #10b981, #047857); height: 90px; position: relative; display: flex; align-items: center; justify-content: center; color: white;">
            <i class="fa-regular fa-circle-play" style="font-size: 1.8rem; opacity: 0.85;"></i>
        </div>
        <div style="padding: 10px;">
            <div style="font-size: 0.75rem; font-weight: 700; line-height: 1.2; height: 2.4em; overflow: hidden;">Prompt Scan Rambut</div>
            <div style="font-size: 0.65rem; color: var(--text-muted); margin-top: 4px;">Analisis Rambut Lengkap</div>
        </div>
    </div>
    <!-- Video Card 2 -->
    <div style="background-color: white; border-radius: 12px; border: 1px solid var(--border); overflow: hidden;">
        <div style="background: linear-gradient(135deg, #3b82f6, #1d4ed8); height: 90px; position: relative; display: flex; align-items: center; justify-content: center; color: white;">
            <i class="fa-regular fa-circle-play" style="font-size: 1.8rem; opacity: 0.85;"></i>
        </div>
        <div style="padding: 10px;">
            <div style="font-size: 0.75rem; font-weight: 700; line-height: 1.2; height: 2.4em; overflow: hidden;">Cara Menggunakan Aplikasi</div>
            <div style="font-size: 0.65rem; color: var(--text-muted); margin-top: 4px;">Tutorial Lengkap &amp; Mudah</div>
        </div>
    </div>
</div>

<!-- Recommendations section -->
<div class="menu-section-title" style="display: flex; justify-content: space-between; align-items: center;">
    <span>Rekomendasi Untukmu</span>
    <a href="{{ route('marketplace') }}" style="font-size: 0.75rem; color: var(--primary); font-weight: 600; text-decoration: none;">Lihat Semua</a>
</div>
<div class="product-grid" style="margin-bottom: 20px;">
    @foreach($recommendations as $product)
        <a href="{{ route('marketplace.detail', $product->slug) }}" class="product-card">
            <div class="product-card-image-wrapper">
                @if($product->image)
                    @if(str_starts_with($product->image, 'http'))
                        <img src="{{ $product->image }}" class="product-card-image" alt="{{ $product->name }}">
                    @elseif(file_exists(public_path('uploads/' . $product->image)))
                        <img src="{{ asset('uploads/' . $product->image) }}" class="product-card-image" alt="{{ $product->name }}">
                    @else
                        <div class="product-placeholder-image">
                            <i class="fa-solid fa-bottle-droplet" style="font-size: 2rem;"></i>
                        </div>
                    @endif
                @else
                    <div class="product-placeholder-image">
                        <i class="fa-solid fa-bottle-droplet" style="font-size: 2rem;"></i>
                    </div>
                @endif
            </div>
            <div class="product-card-info">
                <div class="product-card-name">{{ $product->name }}</div>
                <div class="product-card-price-row">
                    <span class="product-card-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="add-cart-mini-btn" onclick="event.stopPropagation();"><i class="fa-solid fa-plus"></i></button>
                    </form>
                </div>
            </div>
        </a>
    @endforeach
</div>
@endsection
