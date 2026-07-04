@extends('layouts.app')

@section('title', 'Toko Produk - PureStrands')

@section('header')
    <a href="{{ route('home') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">Toko Produk</div>
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
<!-- Recommendation Banner -->
<div class="promo-banner" style="background: linear-gradient(135deg, #10b981, #064e3b); margin-bottom: 20px;">
    <span class="promo-banner-badge" style="background-color: var(--primary);"><i class="fa-solid fa-wand-magic-sparkles"></i> Rekomendasi AI Khusus Untukmu</span>
    <h4 style="font-size: 0.95rem; font-weight: 700; margin-bottom: 4px;">Berdasarkan hasil analisis rambut terakhirmu</h4>
    <p style="font-size: 0.75rem; opacity: 0.9;">Rekomendasi disesuaikan dengan kondisi rambut Anda yang cenderung agak kering.</p>
</div>

<!-- Search Input -->
<form action="{{ route('marketplace') }}" method="GET" class="search-wrapper">
    <input type="text" name="q" value="{{ $searchQuery }}" class="search-input" placeholder="Cari produk perawatan rambut...">
    <i class="fa-solid fa-magnifying-glass search-icon"></i>
    @if(!empty($activeCategory))
        <input type="hidden" name="category" value="{{ $activeCategory }}">
    @endif
</form>

<!-- Categories Slider -->
<div class="category-filter-list">
    <a href="{{ route('marketplace', ['q' => $searchQuery]) }}" class="category-filter-item {{ empty($activeCategory) ? 'active' : '' }}">Semua</a>
    @foreach($categories as $category)
        <a href="{{ route('marketplace', ['category' => $category->slug, 'q' => $searchQuery]) }}" class="category-filter-item {{ $activeCategory === $category->slug ? 'active' : '' }}">
            {{ $category->name }}
        </a>
    @endforeach
</div>

@if($products->isEmpty())
    <div style="text-align: center; padding: 40px 10px; color: var(--text-muted);">
        <i class="fa-regular fa-face-frown" style="font-size: 2.5rem; margin-bottom: 12px; color: #d1d5db;"></i>
        <div style="font-size: 0.9rem; font-weight: 600;">Produk tidak ditemukan</div>
        <div style="font-size: 0.75rem; margin-top: 4px;">Coba gunakan kata kunci pencarian yang lain.</div>
    </div>
@else
    <!-- Product Grid -->
    <div class="product-grid">
        @foreach($products as $product)
            <a href="{{ route('marketplace.detail', $product->slug) }}" class="product-card">
                <!-- Badge for Recommended/Best Seller -->
                @if($product->rating >= 4.9)
                    <span class="product-card-badge">AI RECOMMENDED</span>
                @elseif($product->stock < 10)
                    <span class="product-card-badge" style="background-color: #fef3c7; color: #d97706;">BEST SELLER</span>
                @endif

                <div class="product-card-image-wrapper">
                    @if($product->image)
                        @if(str_starts_with($product->image, 'http'))
                            <img src="{{ $product->image }}" class="product-card-image" alt="{{ $product->name }}">
                        @elseif(file_exists(public_path('uploads/' . $product->image)))
                            <img src="{{ asset('uploads/' . $product->image) }}" class="product-card-image" alt="{{ $product->name }}">
                        @else
                            <div class="product-placeholder-image">
                                <i class="fa-solid fa-bottle-droplet" style="font-size: 2.5rem; opacity: 0.9;"></i>
                            </div>
                        @endif
                    @else
                        <div class="product-placeholder-image">
                            <i class="fa-solid fa-bottle-droplet" style="font-size: 2.5rem; opacity: 0.9;"></i>
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
@endif
@endsection
