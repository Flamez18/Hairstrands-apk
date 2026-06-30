@extends('layouts.admin')

@section('content')
<h2 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 24px;">Dashboard Overview</h2>

{{-- Stats Grid --}}
<div class="admin-dashboard-stats">
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-box"></i></div>
        <div>
            <div class="stat-value">{{ $stats['products'] }}</div>
            <div class="stat-label">Total Produk</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-list"></i></div>
        <div>
            <div class="stat-value">{{ $stats['categories'] }}</div>
            <div class="stat-label">Kategori</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fa-solid fa-user-doctor"></i></div>
        <div>
            <div class="stat-value">{{ $stats['experts'] }}</div>
            <div class="stat-label">Dokter Ahli</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background-color: #e6fcf6; color: var(--accent);"><i class="fa-solid fa-book-bookmark"></i></div>
        <div>
            <div class="stat-value">{{ $stats['bookings'] }}</div>
            <div class="stat-label">Total Booking</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background-color: #fffbeb; color: #d97706;"><i class="fa-solid fa-shopping-bag"></i></div>
        <div>
            <div class="stat-value">{{ $stats['orders'] }}</div>
            <div class="stat-label">Total Pesanan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background-color: #f0fdf4; color: #16a34a;"><i class="fa-solid fa-sack-dollar"></i></div>
        <div>
            <div class="stat-value" style="font-size: 1.1rem;">Rp {{ number_format($stats['total_sales'], 0, ',', '.') }}</div>
            <div class="stat-label">Total Penjualan</div>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    {{-- Recent Orders --}}
    <div>
        <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 14px;">Pesanan Terbaru</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td style="font-weight: 600; font-size: 0.78rem;">{{ $order->invoice_number }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td><span class="admin-badge badge-{{ $order->status === 'paid' ? 'paid' : 'pending' }}">{{ $order->status }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Recent Bookings --}}
    <div>
        <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 14px;">Booking Terbaru</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Dokter</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentBookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }}</td>
                    <td style="font-size: 0.78rem;">{{ $booking->expert->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->schedule->date)->format('d M') }} {{ $booking->schedule->time_slot }}</td>
                    <td><span class="admin-badge badge-{{ $booking->status === 'completed' ? 'success' : ($booking->status === 'cancelled' ? 'cancelled' : 'pending') }}">{{ $booking->status }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
