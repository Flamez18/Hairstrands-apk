@extends('layouts.app')

@section('title', 'Keranjang Belanja - PureStrands')

@section('header')
    <a href="{{ route('marketplace') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">Keranjang Belanja</div>
    <div></div>
@endsection

@section('content')
@if($items->isEmpty())
    <div style="text-align: center; padding: 60px 10px; color: var(--text-muted);">
        <i class="fa-solid fa-cart-shopping" style="font-size: 3rem; margin-bottom: 16px; color: #d1d5db;"></i>
        <div style="font-size: 0.95rem; font-weight: 600;">Keranjang Anda Kosong</div>
        <p style="font-size: 0.8rem; margin-top: 6px; margin-bottom: 24px;">Temukan produk perawatan rambut terbaik di toko kami.</p>
        <a href="{{ route('marketplace') }}" class="btn btn-primary" style="display: inline-block; width: auto; padding: 12px 24px;">Mulai Belanja</a>
    </div>
@else
    <!-- Cart Items List -->
    <div class="cart-list">
        @foreach($items as $item)
            <div class="cart-item">
                <div class="cart-item-image" style="overflow: hidden; padding: 0; background-color: var(--primary-light);">
                    @php
                        $img = $item->product->image ?? null;
                        $imgSrc = null;
                        if ($img) {
                            if (str_starts_with($img, 'http')) {
                                $imgSrc = $img;
                            } elseif (file_exists(public_path('uploads/' . $img))) {
                                $imgSrc = asset('uploads/' . $img);
                            }
                        }
                    @endphp
                    @if($imgSrc)
                        <img src="{{ $imgSrc }}"
                             alt="{{ $item->product->name }}"
                             style="width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 8px;">
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--primary);">
                            <i class="fa-solid fa-bottle-droplet" style="font-size: 1.5rem;"></i>
                        </div>
                    @endif
                </div>
                
                <div class="cart-item-info">
                    <div class="cart-item-name">{{ $item->product->name }}</div>
                    <div class="cart-item-price">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                </div>

                <div class="cart-item-actions">
                    <!-- Remove Form -->
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="remove-item-btn" title="Hapus produk"><i class="fa-regular fa-trash-can"></i></button>
                    </form>

                    <!-- Quantity Control Form -->
                    <form action="{{ route('cart.update', $item->id) }}" method="POST" id="update-form-{{ $item->id }}" style="margin: 0;">
                        @csrf
                        <div class="quantity-control">
                            <button type="button" class="qty-btn" onclick="updateQty({{ $item->id }}, -1)"><i class="fa-solid fa-minus"></i></button>
                            <input type="number" id="qty-{{ $item->id }}" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" style="width: 30px; text-align: center; border: none; font-weight: 700; font-size: 0.8rem;" readonly>
                            <button type="button" class="qty-btn" onclick="updateQty({{ $item->id }}, 1)"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Ringkasan Harga -->
    <div class="summary-card">
        <div class="summary-row">
            <span>Subtotal Produk</span>
            <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span>Biaya Pengiriman</span>
            <span style="color: var(--accent); font-weight: 600;">GRATIS</span>
        </div>
        <div class="summary-row total">
            <span>Total Harga</span>
            <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
        </div>
    </div>

    <a href="{{ route('checkout') }}" class="btn btn-primary">
        <i class="fa-solid fa-credit-card"></i> Lanjut ke Checkout
    </a>
@endif
@endsection

@section('scripts')
<script>
    function updateQty(itemId, change) {
        const input = document.getElementById('qty-' + itemId);
        const form = document.getElementById('update-form-' + itemId);
        let currentVal = parseInt(input.value);
        let maxVal = parseInt(input.getAttribute('max'));
        
        let newVal = currentVal + change;
        if (newVal >= 0 && newVal <= maxVal) {
            input.value = newVal;
            form.submit();
        }
    }
</script>
@endsection
