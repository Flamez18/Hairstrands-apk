@extends('layouts.app')

@section('title', 'Pembayaran Berhasil - PureStrands')

@section('header')
    <div></div>
    <div class="header-title">Pembayaran Berhasil</div>
    <div></div>
@endsection

@section('content')
<div class="success-container">
    <div class="success-icon-wrapper">
        <i class="fa-solid fa-circle-check"></i>
    </div>
    <h2 class="success-title">Pembayaran Berhasil!</h2>
    <p class="success-message">
        Pesanan <strong>{{ $order->invoice_number }}</strong> telah dikonfirmasi.<br>
        Produk Anda sedang dalam proses pengiriman. Terima kasih telah berbelanja di PureStrands!
    </p>

    <div style="background: var(--primary-light); border-radius: 14px; padding: 16px; margin-bottom: 24px; text-align: left;">
        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 8px;">
            <span style="color: var(--text-muted);">Invoice</span>
            <span style="font-weight: 700;">{{ $order->invoice_number }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; margin-bottom: 8px;">
            <span style="color: var(--text-muted);">Metode Bayar</span>
            <span style="font-weight: 700;">{{ $order->payment_method }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 0.85rem;">
            <span style="color: var(--text-muted);">Total</span>
            <span style="font-weight: 800; color: var(--primary);">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>
    </div>

    <a href="{{ route('payment.invoice', $order->id) }}" class="btn btn-primary" style="margin-bottom: 12px;">
        <i class="fa-solid fa-file-invoice"></i> Lihat Invoice
    </a>
    <a href="{{ route('marketplace') }}" class="btn btn-secondary">
        <i class="fa-solid fa-bag-shopping"></i> Lanjut Belanja
    </a>
    <a href="{{ route('home') }}" style="display: block; text-align: center; margin-top: 14px; font-size: 0.85rem; color: var(--text-muted); text-decoration: none;">Kembali ke Beranda</a>
</div>
@endsection
