@extends('layouts.app')

@section('title', 'Pembayaran - PureStrands')

@section('header')
    <a href="{{ route('cart') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">Pembayaran</div>
    <div></div>
@endsection

@section('content')
{{-- Payment Instructions Card --}}
<div style="text-align: center; margin-bottom: 24px; padding-top: 10px;">
    <div style="width: 64px; height: 64px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin: 0 auto 14px;">
        @if($order->payment_method === 'QRIS')
            <i class="fa-solid fa-qrcode"></i>
        @elseif(str_contains($order->payment_method, 'VA'))
            <i class="fa-solid fa-building-columns"></i>
        @else
            <i class="fa-solid fa-mobile-screen-button"></i>
        @endif
    </div>
    <div style="font-size: 1.1rem; font-weight: 700;">{{ $paymentDetails['title'] }}</div>
    <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 6px; line-height: 1.5; padding: 0 10px;">{{ $paymentDetails['instruction'] }}</div>
</div>

{{-- Payment Value (QR / VA Number / Phone) --}}
<div style="background-color: white; border: 1px solid var(--border); border-radius: 16px; padding: 20px; text-align: center; margin-bottom: 20px;">
    @if($order->payment_method === 'QRIS')
        {{-- Simulated QR Code --}}
        <div style="width: 160px; height: 160px; background: linear-gradient(135deg, #004B38 0%, #00A878 100%); border-radius: 12px; margin: 0 auto 12px; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; position: relative; overflow: hidden;">
            <i class="fa-solid fa-qrcode"></i>
            <div style="position: absolute; bottom: 8px; font-size: 0.5rem; letter-spacing: 0.5px; opacity: 0.8;">PureStrands QR</div>
        </div>
        <div style="font-size: 0.75rem; color: var(--text-muted);">Scan dengan aplikasi e-wallet Anda</div>
    @else
        <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 8px;">Nomor Tujuan Transfer:</div>
        <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary); letter-spacing: 2px;">{{ $paymentDetails['value'] }}</div>
        <button onclick="copyToClipboard('{{ $paymentDetails['value'] }}')" style="margin-top: 10px; background: none; border: 1px solid var(--primary); color: var(--primary); border-radius: 8px; padding: 6px 16px; font-size: 0.75rem; font-weight: 600; cursor: pointer;">
            <i class="fa-regular fa-copy"></i> Salin Nomor
        </button>
    @endif
</div>

{{-- Invoice Info --}}
<div style="background-color: white; border: 1px solid var(--border); border-radius: 14px; padding: 16px; margin-bottom: 24px;">
    <div class="summary-row" style="margin-bottom: 8px;">
        <span style="color: var(--text-muted);">No. Invoice</span>
        <span style="font-weight: 700;">{{ $order->invoice_number }}</span>
    </div>
    <div class="summary-row" style="margin-bottom: 8px;">
        <span style="color: var(--text-muted);">Metode</span>
        <span style="font-weight: 700;">{{ $order->payment_method }}</span>
    </div>
    <div class="summary-row total">
        <span>Total Pembayaran</span>
        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
    </div>
</div>

{{-- Simulate Payment Button --}}
<div id="pay-btn-wrapper">
    <button id="simulate-pay-btn" onclick="simulatePayment()" class="btn btn-primary">
        <i class="fa-solid fa-bolt"></i> Simulasi Pembayaran Berhasil
    </button>
    <p style="text-align: center; font-size: 0.75rem; color: var(--text-muted); margin-top: 8px;">
        *Ini adalah tombol simulasi untuk keperluan demo MVP
    </p>
</div>

{{-- Loading Overlay --}}
<div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.95); z-index: 999; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
    <div class="spinner"></div>
    <div style="font-size: 1rem; font-weight: 700; color: var(--primary);">Memproses Pembayaran...</div>
    <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 6px;">Mohon tunggu sebentar</div>
</div>
@endsection

@section('scripts')
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Nomor berhasil disalin!');
        });
    }

    function simulatePayment() {
        // Show loading overlay
        const overlay = document.getElementById('loading-overlay');
        overlay.style.display = 'flex';

        // Wait 3 seconds then call the process endpoint
        setTimeout(() => {
            fetch('{{ route("payment.process", $order->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.href = data.redirect;
                }
            })
            .catch(() => {
                overlay.style.display = 'none';
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }, 3000);
    }
</script>
@endsection
