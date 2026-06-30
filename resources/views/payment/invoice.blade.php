@extends('layouts.app')

@section('title', 'Invoice #{{ $order->invoice_number }} - PureStrands')

@section('header')
    <a href="{{ route('profile') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">Invoice</div>
    <div></div>
@endsection

@section('content')
<div class="invoice-wrapper">
    {{-- Header --}}
    <div class="invoice-header">
        <div style="font-size: 1.5rem; color: var(--primary); font-weight: 800; margin-bottom: 4px;">
            <i class="fa-solid fa-scissors"></i> PureStrands
        </div>
        <div style="font-size: 0.7rem; color: var(--text-muted);">Platform Perawatan Rambut & Konsultasi</div>
        <div style="margin-top: 12px;">
            <span class="invoice-number">Invoice #{{ $order->invoice_number }}</span>
        </div>
    </div>

    {{-- Details --}}
    <div class="invoice-details-row">
        <span style="color: var(--text-muted);">Tanggal</span>
        <span style="font-weight: 600;">{{ $order->created_at->format('d M Y, H:i') }}</span>
    </div>
    <div class="invoice-details-row">
        <span style="color: var(--text-muted);">Status</span>
        <span class="history-status-badge {{ $order->status === 'paid' ? 'badge-paid' : 'badge-pending' }}">
            {{ strtoupper($order->status) }}
        </span>
    </div>
    <div class="invoice-details-row">
        <span style="color: var(--text-muted);">Metode Bayar</span>
        <span style="font-weight: 600;">{{ $order->payment_method }}</span>
    </div>
    <div class="invoice-details-row">
        <span style="color: var(--text-muted);">Tujuan Pengiriman</span>
        <span style="font-weight: 600; text-align: right; max-width: 200px;">{{ $order->shipping_address }}</span>
    </div>

    {{-- Items Table --}}
    <table class="invoice-table">
        <thead>
            <tr>
                <th>Produk</th>
                <th style="text-align: center;">Qty</th>
                <th class="amount-col">Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td style="text-align: center;">{{ $item->quantity }}</td>
                <td class="amount-col">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="font-weight: 700; padding-top: 12px; border-top: 1px solid var(--border);">Total</td>
                <td class="amount-col" style="font-weight: 800; color: var(--primary); padding-top: 12px; border-top: 1px solid var(--border);">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    @if($order->payment)
    <div style="background: var(--primary-light); border-radius: 10px; padding: 12px; margin-top: 16px; font-size: 0.75rem;">
        <div class="invoice-details-row" style="margin-bottom: 4px;">
            <span style="color: var(--text-muted);">Transaction ID</span>
            <span style="font-weight: 600;">{{ $order->payment->transaction_id }}</span>
        </div>
        <div class="invoice-details-row" style="margin-bottom: 0;">
            <span style="color: var(--text-muted);">Status Bayar</span>
            <span style="font-weight: 700; color: var(--accent);">SUKSES</span>
        </div>
    </div>
    @endif

    <div style="text-align: center; margin-top: 20px; padding-top: 16px; border-top: 1px dashed var(--border); font-size: 0.7rem; color: var(--text-muted);">
        Terima kasih telah berbelanja di PureStrands.<br>
        Hubungi kami di support@purestrands.com untuk bantuan.
    </div>
</div>

<a href="{{ route('marketplace') }}" class="btn btn-primary" style="margin-bottom: 12px;">
    <i class="fa-solid fa-bag-shopping"></i> Lanjut Belanja
</a>
@endsection
