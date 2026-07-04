@extends('layouts.app')

@section('title', 'Profil Saya - PureStrands')

@section('header')
    <a href="{{ route('home') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">Profil Saya</div>
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="font-size: 0.8rem; color: #ef4444; font-weight: 600; text-decoration: none;">
        <i class="fa-solid fa-right-from-bracket"></i>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
@endsection

@section('content')

{{-- Hair Scan Profile Card (mock) --}}
<div class="scan-profile-card">
    <div style="font-size: 0.7rem; opacity: 0.75; margin-bottom: 4px;">Hasil Scan Terakhir - {{ $analysis['date'] }}</div>
    <div style="font-size: 1.3rem; font-weight: 800; margin-bottom: 16px;">{{ strtoupper($user->name) }}</div>

    <div class="scan-badge-container">
        <span class="scan-badge"><i class="fa-solid fa-circle" style="font-size: 0.5rem;"></i> {{ $analysis['type'] }}</span>
        <span class="scan-badge" style="background: rgba(255,200,100,0.25);"><i class="fa-solid fa-circle" style="font-size: 0.5rem; color: #fcd34d;"></i> {{ $analysis['scalp'] }}</span>
        <span class="scan-badge"><i class="fa-solid fa-circle" style="font-size: 0.5rem;"></i> {{ $analysis['porosity'] }}</span>
    </div>

    <div class="health-stat-row">
        <div class="health-stat-label"><span>Kelembapan</span><span>{{ $analysis['moisture'] }}%</span></div>
        <div class="health-stat-bar-bg"><div class="health-stat-bar-fg" style="width: {{ $analysis['moisture'] }}%; background-color: #4ade80;"></div></div>
    </div>
    <div class="health-stat-row">
        <div class="health-stat-label"><span>Kekuatan</span><span>{{ $analysis['strength'] }}%</span></div>
        <div class="health-stat-bar-bg"><div class="health-stat-bar-fg" style="width: {{ $analysis['strength'] }}%; background-color: #fbbf24;"></div></div>
    </div>
    <div class="health-stat-row" style="margin-bottom: 0;">
        <div class="health-stat-label"><span>Kesehatan</span><span>{{ $analysis['health'] }}%</span></div>
        <div class="health-stat-bar-bg"><div class="health-stat-bar-fg" style="width: {{ $analysis['health'] }}%; background-color: #f87171;"></div></div>
    </div>
</div>

{{-- Edit Profile Form --}}
<div style="background: white; border: 1px solid var(--border); border-radius: 14px; padding: 16px; margin-bottom: 20px;">
    <div style="font-size: 0.9rem; font-weight: 700; margin-bottom: 16px;"><i class="fa-regular fa-user" style="color: var(--primary);"></i> Edit Profil</div>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">Nomor Telepon</label>
            <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" placeholder="08xxx">
        </div>
        <div class="form-group">
            <label class="form-label">Alamat</label>
            <textarea name="address" class="form-textarea" rows="2" placeholder="Alamat pengiriman Anda">{{ old('address', $user->address) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="padding: 10px;">Simpan Perubahan</button>
    </form>
</div>

{{-- History Tabs --}}
<div id="history" style="font-size: 0.9rem; font-weight: 700; margin-bottom: 12px;">Riwayat Aktivitas</div>
<div class="tabs-container">
    <div class="tab-btn active" onclick="switchTab('produk', this)">Produk</div>
    <div class="tab-btn" onclick="switchTab('konsultasi', this)">Konsultasi</div>
    <div class="tab-btn" onclick="switchTab('scan', this)">AI Scan</div>
</div>

{{-- Tab: Order History --}}
<div class="tab-content active" id="tab-produk">
    @if($orders->isEmpty())
        <div style="text-align: center; padding: 20px; color: var(--text-muted); font-size: 0.85rem;">Belum ada riwayat pembelian.</div>
    @else
        @foreach($orders as $order)
        <div class="history-item-card">
            <div class="history-item-header">
                <span>{{ $order->created_at->format('d M Y') }} · ID: {{ $order->invoice_number }}</span>
                <span class="history-status-badge badge-{{ $order->status === 'paid' ? 'paid' : ($order->status === 'pending' ? 'pending' : 'cancelled') }}">
                    {{ strtoupper($order->status) }}
                </span>
            </div>
            @foreach($order->items->take(1) as $item)
            <div class="history-item-details">
                @php $prod = $item->product; @endphp
                @if($prod && $prod->image && file_exists(public_path('uploads/' . $prod->image)))
                    <img src="{{ asset('uploads/' . $prod->image) }}" alt="{{ $prod->name }}" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; flex-shrink: 0;">
                @else
                    <div style="width: 48px; height: 48px; border-radius: 8px; background: var(--primary-light); display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fa-solid fa-bottle-droplet"></i>
                    </div>
                @endif
                <div>
                    <div class="history-item-title">{{ $item->product->name }}</div>
                    <div style="font-size: 0.8rem; font-weight: 700; color: var(--primary); margin-top: 4px;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                </div>
            </div>
            @endforeach
            @if($order->items->count() > 1)
                <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 6px;">+{{ $order->items->count() - 1 }} produk lainnya</div>
            @endif
            <div style="margin-top: 10px;">
                <a href="{{ route('payment.invoice', $order->id) }}" style="font-size: 0.8rem; color: var(--primary); font-weight: 600; text-decoration: none;">
                    <i class="fa-solid fa-file-invoice"></i> Lihat Invoice
                </a>
            </div>
        </div>
        @endforeach
    @endif
</div>

{{-- Tab: Booking History --}}
<div class="tab-content" id="tab-konsultasi">
    @if($bookings->isEmpty())
        <div style="text-align: center; padding: 20px; color: var(--text-muted); font-size: 0.85rem;">Belum ada riwayat konsultasi.</div>
    @else
        @foreach($bookings as $booking)
        <div class="history-item-card">
            <div class="history-item-header">
                <span><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($booking->schedule->date)->format('d M Y') }}</span>
                <span class="history-status-badge badge-{{ $booking->status === 'completed' ? 'success' : ($booking->status === 'cancelled' ? 'cancelled' : 'pending') }}">
                    {{ strtoupper($booking->status) }}
                </span>
            </div>
            <div class="history-item-details">
                @php $exp = $booking->expert; @endphp
                @if($exp && $exp->photo && file_exists(public_path('uploads/' . $exp->photo)))
                    <img src="{{ asset('uploads/' . $exp->photo) }}" alt="{{ $exp->name }}" style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; flex-shrink: 0;">
                @else
                    <div style="width: 48px; height: 48px; border-radius: 8px; background: var(--primary-light); display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.2rem; flex-shrink: 0;">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                @endif
                <div>
                    <div class="history-item-title">{{ $booking->expert->name }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;">{{ $booking->expert->specialty }}</div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;">
                        <i class="fa-solid fa-clock"></i> {{ $booking->schedule->time_slot }} WIB · 
                        <i class="fa-regular fa-comment-dots"></i> {{ $booking->type }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    @endif
</div>

{{-- Tab: AI Scan History (Mock) --}}
<div class="tab-content" id="tab-scan">
    @foreach($scans as $scan)
    <div class="history-item-card">
        <div class="history-item-header">
            <span>{{ $scan['date'] }}</span>
            <span style="font-weight: 700; color: var(--primary); font-size: 0.8rem;">{{ $scan['score'] }}</span>
        </div>
        <div class="history-item-details">
            <div style="width: 48px; height: 48px; border-radius: 8px; background: linear-gradient(135deg, var(--primary-light), #c6eed9); display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.2rem; flex-shrink: 0;">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div>
                <div class="history-item-title">{{ $scan['issue'] }}</div>
                <div style="display: flex; gap: 6px; margin-top: 4px;">
                    <span style="font-size: 0.65rem; font-weight: 700; padding: 2px 7px; border-radius: 8px; background: var(--primary-light); color: var(--primary);">{{ $scan['type'] }}</span>
                    <span style="font-size: 0.65rem; font-weight: 700; padding: 2px 7px; border-radius: 8px; background: #fef3c7; color: #d97706;">{{ $scan['status'] }}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection

@section('scripts')
<script>
    function switchTab(tab, element) {
        document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        document.getElementById('tab-' + tab).classList.add('active');
    }
</script>
@endsection
