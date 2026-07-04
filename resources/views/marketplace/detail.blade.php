@extends('layouts.app')

@section('title', $product->name . ' - PureStrands')

@section('header')
    <a href="{{ route('marketplace') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">Detail Produk</div>
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
<!-- Product Image Container -->
<div class="detail-image-container" style="margin: -20px -20px 20px -20px;">
    @if($product->image)
        @if(str_starts_with($product->image, 'http'))
            <img src="{{ $product->image }}" class="detail-image" style="height: 250px; border-radius: 0; width: 100%; object-fit: cover;" alt="{{ $product->name }}">
        @elseif(file_exists(public_path('uploads/' . $product->image)))
            <img src="{{ asset('uploads/' . $product->image) }}" class="detail-image" style="height: 250px; border-radius: 0; width: 100%; object-fit: cover;" alt="{{ $product->name }}">
        @else
            <div class="product-placeholder-image" style="height: 250px; border-radius: 0;">
                <i class="fa-solid fa-bottle-droplet" style="font-size: 5rem; opacity: 0.9;"></i>
            </div>
        @endif
    @else
        <div class="product-placeholder-image" style="height: 250px; border-radius: 0;">
            <i class="fa-solid fa-bottle-droplet" style="font-size: 5rem; opacity: 0.9;"></i>
        </div>
    @endif
</div>

<div class="detail-info-card">
    <div class="detail-header-row">
        <h2 class="detail-title">{{ $product->name }}</h2>
        <span class="detail-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
    </div>

    <!-- Rating & Reviews -->
    <div class="detail-rating-row">
        <i class="fa-solid fa-star"></i>
        <strong>{{ $product->rating }}</strong>
        <span>(120 ulasan)</span>
        <span style="color: var(--border); margin: 0 4px;">|</span>
        @if($product->stock > 0)
            <span style="color: var(--accent); font-weight: 600;"><i class="fa-solid fa-circle-check"></i> Stok Tersedia ({{ $product->stock }})</span>
        @else
            <span style="color: #ef4444; font-weight: 600;"><i class="fa-solid fa-circle-xmark"></i> Stok Habis</span>
        @endif
    </div>

    <!-- Available Shades (If any) -->
    @if($product->shades)
        <div class="shades-section">
            <div class="shades-title">PILIH WARNA (SHADES):</div>
            <div class="shades-list">
                @foreach($product->shades as $index => $hex)
                    <div class="shade-circle {{ $index === 0 ? 'active' : '' }}" 
                         style="background-color: {{ $hex }};" 
                         data-shade="{{ $hex }}"
                         onclick="selectShade(this)">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Highlights Section -->
    <div class="highlights-grid">
        <div class="highlight-box">
            <i class="fa-regular fa-clock"></i> 20 Menit Proses
        </div>
        <div class="highlight-box">
            <i class="fa-solid fa-seedling"></i> Formula Vegan
        </div>
    </div>

    <!-- Product Description -->
    <div class="shades-title" style="margin-top: 10px;">DESKRIPSI PRODUK:</div>
    <p class="detail-description">
        {{ $product->description }}
    </p>

    <!-- Add To Cart Form -->
    @if($product->stock > 0)
        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="margin-top: 30px;">
            @csrf
            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 20px;">
                <span class="form-label" style="margin: 0; font-weight: 700;">Jumlah:</span>
                <div class="quantity-control" style="background-color: white;">
                    <button type="button" class="qty-btn" onclick="adjustQty(-1)"><i class="fa-solid fa-minus"></i></button>
                    <input type="number" id="qty-input" name="quantity" value="1" min="1" max="{{ $product->stock }}" style="width: 40px; text-align: center; border: none; font-weight: 700; outline: none;" readonly>
                    <button type="button" class="qty-btn" onclick="adjustQty(1)"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-cart-plus"></i> Tambah Ke Keranjang (Rp <span id="btn-price-display">{{ number_format($product->price, 0, ',', '.') }}</span>)
            </button>
        </form>
    @else
        <button class="btn btn-secondary" style="margin-top: 30px; cursor: not-allowed;" disabled>Stok Habis</button>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function selectShade(element) {
        const circles = document.querySelectorAll('.shade-circle');
        circles.forEach(c => c.classList.remove('active'));
        element.classList.add('active');
    }

    const price = {{ $product->price }};
    const maxStock = {{ $product->stock }};
    const qtyInput = document.getElementById('qty-input');
    const priceDisplay = document.getElementById('btn-price-display');

    function adjustQty(amount) {
        let currentVal = parseInt(qtyInput.value);
        let newVal = currentVal + amount;
        if (newVal >= 1 && newVal <= maxStock) {
            qtyInput.value = newVal;
            let totalPrice = newVal * price;
            priceDisplay.textContent = new Intl.NumberFormat('id-ID').format(totalPrice);
        }
    }
</script>
@endsection
