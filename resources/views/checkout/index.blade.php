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
        <div class="summary-row" style="align-items: center; margin-bottom: 12px; border-bottom: 1px solid #f3f4f6; padding-bottom: 12px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                @if($item->product->image)
                    @if(str_starts_with($item->product->image, 'http'))
                        <img src="{{ $item->product->image }}" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border);" alt="{{ $item->product->name }}">
                    @else
                        <img src="{{ asset('uploads/' . $item->product->image) }}" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; border: 1px solid var(--border);" alt="{{ $item->product->name }}">
                    @endif
                @else
                    <div style="width: 48px; height: 48px; border-radius: 8px; background: #e5e7eb; display: flex; align-items: center; justify-content: center; color: #9ca3af; border: 1px solid var(--border);">
                        <i class="fa-solid fa-box"></i>
                    </div>
                @endif
                <div style="display: flex; flex-direction: column;">
                    <span style="font-weight: 600; font-size: 0.85rem;">{{ $item->product->name }}</span>
                    <span style="color: var(--text-muted); font-size: 0.75rem;">Qty: {{ $item->quantity }}</span>
                </div>
            </div>
            <span style="font-weight: 600; font-size: 0.9rem;">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
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
    <input type="hidden" name="payment_method" id="payment-method-input" value="">

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

@include('components.checkout-loading')

@endsection

@section('scripts')
<script>
    function selectPayment(method, element) {
        document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        document.getElementById('payment-method-input').value = method;
    }

    document.getElementById('checkout-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const pm = document.getElementById('payment-method-input').value;
        const address = document.querySelector('textarea[name="shipping_address"]').value.trim();
        
        if (!address) {
            alert('Silakan isi alamat pengiriman terlebih dahulu!');
            return;
        }
        
        if (!pm) {
            alert('Silakan pilih metode pembayaran terlebih dahulu!');
            return;
        }

        // Mulai animasi loading
        startCheckoutAnimation(this);
    });

    // Tunggu CSS transition selesai pada properti tertentu
    function waitTransition(el, prop) {
        return new Promise(resolve => {
            function handler(e) {
                if (e.propertyName === prop) {
                    el.removeEventListener('transitionend', handler);
                    resolve();
                }
            }
            el.addEventListener('transitionend', handler);
        });
    }

    function delay(ms) {
        return new Promise(r => setTimeout(r, ms));
    }

    async function startCheckoutAnimation(form) {
        const overlay      = document.getElementById('checkout-loading-overlay');
        const scene        = document.getElementById('loading-3d-scene');
        const statusText   = document.getElementById('loading-status-text');
        const progressFill = document.getElementById('loading-progress-fill');

        // Reset state
        scene.className = 'box-3d-scene';
        overlay.classList.add('active');
        progressFill.style.width = '5%';

        // ── Fetch API di background ──
        const formData   = new FormData(form);
        const apiPromise = fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(r => r.json());

        // ── Timeline Animasi ──
        const animPromise = (async () => {

            // TAHAP 1 – Kotak muncul & terbuka (0.1s)
            await delay(100);
            scene.classList.add('scene-start');
            progressFill.style.width = '15%';

            // TAHAP 2 – Produk melayang, lalu jatuh masuk (1.2s setelah terbuka)
            await delay(1200);
            scene.classList.add('scene-step-products');
            statusText.innerText = 'Menyiapkan pesananmu...';
            progressFill.style.width = '35%';

            // Tunggu produk terakhir selesai animasi masuk (~0.75s + 0.36s delay = ~1.2s)
            await delay(1200);

            // TAHAP 3 – Tutup flap satu per satu (setiap flap tunggu transitionend)
            statusText.innerText = 'Mengemas paket...';
            progressFill.style.width = '50%';

            const flapLeft  = scene.querySelector('.flap-left');
            const flapRight = scene.querySelector('.flap-right');
            const flapBack  = scene.querySelector('.flap-back');
            const flapFront = scene.querySelector('.flap-front');

            scene.classList.add('scene-step-close-left');
            await waitTransition(flapLeft, 'transform');

            scene.classList.add('scene-step-close-right');
            await waitTransition(flapRight, 'transform');

            scene.classList.add('scene-step-close-back');
            await waitTransition(flapBack, 'transform');

            scene.classList.add('scene-step-close-front');
            await waitTransition(flapFront, 'transform');

            // Kotak sekarang 100% tertutup rapat
            progressFill.style.width = '80%';
            statusText.innerText = 'Paket siap dikirim!';

            // Jeda singkat biar user lihat kotak tertutup
            await delay(500);

            // TAHAP 4 – Kotak meluncur ke kanan
            scene.classList.add('scene-step-slide');
            progressFill.style.width = '100%';

            // Tunggu slide selesai (~0.9s)
            await delay(900);

        })();

        // ── Tunggu animasi DAN API keduanya selesai ──
        Promise.all([apiPromise, animPromise])
            .then(([data]) => {
                if (data && data.redirect) {
                    overlay.style.opacity = '0';
                    setTimeout(() => { window.location.href = data.redirect; }, 400);
                } else {
                    window.location.reload();
                }
            })
            .catch(() => {
                alert('Terjadi kesalahan saat memproses pesanan.');
                window.location.reload();
            });
    }
</script>
@endsection
