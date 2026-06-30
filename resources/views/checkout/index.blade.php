@extends('layouts.app')

@section('title', 'Checkout - PureStrands')

@section('header')
    <a href="{{ route('cart') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">Checkout</div>
    <div></div>
@endsection

@section('content')
<form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
    @csrf

    {{-- Order Summary --}}
    <div style="font-size: 0.9rem; font-weight: 700; margin-bottom: 12px;">Ringkasan Pesanan</div>
    <div class="summary-card" style="margin-bottom: 20px;">
        @foreach($items as $item)
        <div class="summary-row">
            <span>{{ $item->product->name }} <span style="color: var(--text-muted); font-size: 0.8rem;">x{{ $item->quantity }}</span></span>
            <span>Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
        </div>
        @endforeach
        <div class="summary-row total">
            <span>Total</span>
            <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
        </div>
    </div>

    {{-- Shipping Address --}}
    <div style="font-size: 0.9rem; font-weight: 700; margin-bottom: 12px;"><i class="fa-solid fa-location-dot" style="color: var(--primary);"></i> Alamat Pengiriman</div>
    <div class="form-group">
        <textarea name="shipping_address" class="form-textarea" rows="3" placeholder="Masukkan alamat pengiriman lengkap..." required>{{ old('shipping_address', $user->address) }}</textarea>
    </div>

    {{-- Payment Method --}}
    <div style="font-size: 0.9rem; font-weight: 700; margin-bottom: 12px; margin-top: 8px;"><i class="fa-solid fa-credit-card" style="color: var(--primary);"></i> Pilih Metode Pembayaran</div>
    <div class="payment-grid">
        @foreach($paymentMethods as $key => $label)
        <label class="payment-option" id="pm-{{ Str::slug($key) }}" onclick="selectPayment('{{ $key }}', this)">
            <div style="font-size: 1.1rem; margin-bottom: 6px;">
                @if($key === 'QRIS') <i class="fa-solid fa-qrcode"></i>
                @elseif($key === 'BCA VA') <i class="fa-solid fa-building-columns"></i>
                @elseif($key === 'Mandiri VA') <i class="fa-solid fa-building-columns"></i>
                @elseif($key === 'GoPay') <i class="fa-solid fa-mobile-screen-button"></i>
                @elseif($key === 'OVO') <i class="fa-solid fa-wallet"></i>
                @else <i class="fa-solid fa-circle-dollar-to-slot"></i>
                @endif
            </div>
            <div>{{ $key }}</div>
        </label>
        @endforeach
    </div>
    <input type="hidden" name="payment_method" id="payment-method-input" value="" required>

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <button type="submit" class="btn btn-primary" style="margin-top: 16px;">
        <i class="fa-solid fa-lock"></i> Konfirmasi & Bayar
    </button>
</form>
@endsection

@section('scripts')
<script>
    function selectPayment(method, element) {
        document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        document.getElementById('payment-method-input').value = method;
    }

    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        const pm = document.getElementById('payment-method-input').value;
        if (!pm) {
            e.preventDefault();
            alert('Silakan pilih metode pembayaran terlebih dahulu!');
        }
    });
</script>
@endsection
