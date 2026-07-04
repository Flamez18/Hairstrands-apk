@extends('layouts.app')

@section('title', 'Poin Saya - PureStrands')

@section('styles')
<style>
.points-hero {
    background: linear-gradient(135deg, #7c3aed 0%, #a855f7 100%);
    border-radius: 18px;
    padding: 24px 20px;
    color: white;
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
}
.points-hero::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 150px; height: 150px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
}
.points-hero::after {
    content: '';
    position: absolute;
    bottom: -20px; left: -20px;
    width: 90px; height: 90px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}
.points-hero-label { font-size: 0.72rem; opacity: 0.8; margin-bottom: 4px; }
.points-hero-number {
    font-size: 3rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.points-hero-number .pts-label { font-size: 1rem; opacity: 0.7; font-weight: 600; }
.points-hero-sub { font-size: 0.75rem; opacity: 0.8; margin-bottom: 20px; }
.points-hero-actions { display: flex; gap: 10px; position: relative; z-index: 1; }
.pts-hero-btn {
    flex: 1;
    padding: 10px;
    border-radius: 12px;
    border: none;
    font-family: 'Outfit', sans-serif;
    font-size: 0.75rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    text-align: center;
}
.pts-hero-btn.white-btn { background: white; color: #7c3aed; }
.pts-hero-btn.outline-btn { background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.3); }

.points-stat-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}
.points-stat-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 14px 10px;
    text-align: center;
}
.pts-stat-num { font-size: 1.2rem; font-weight: 800; color: var(--primary); }
.pts-stat-lbl { font-size: 0.65rem; color: var(--text-muted); margin-top: 2px; }

.earn-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 10px;
}
.earn-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.earn-title { font-size: 0.82rem; font-weight: 700; margin-bottom: 2px; }
.earn-desc { font-size: 0.7rem; color: var(--text-muted); }
.earn-pts {
    margin-left: auto;
    font-size: 0.8rem;
    font-weight: 800;
    color: #7c3aed;
    flex-shrink: 0;
    text-align: right;
}

.tx-item {
    background: white;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 13px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
}
.tx-left { display: flex; align-items: center; gap: 12px; }
.tx-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}
.tx-title { font-size: 0.8rem; font-weight: 600; }
.tx-date { font-size: 0.68rem; color: var(--text-muted); margin-top: 2px; }
.tx-pts-plus { font-size: 0.9rem; font-weight: 800; color: #16a34a; }
.tx-pts-minus { font-size: 0.9rem; font-weight: 800; color: #ef4444; }

.redeem-card {
    background: linear-gradient(135deg, #fef3c7, #fff7ed);
    border: 1px solid #fde68a;
    border-radius: 14px;
    padding: 16px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 14px;
}
.redeem-icon { font-size: 1.8rem; flex-shrink: 0; }
.redeem-title { font-size: 0.82rem; font-weight: 700; color: #92400e; margin-bottom: 2px; }
.redeem-desc { font-size: 0.7rem; color: #b45309; margin-bottom: 8px; }
.redeem-cost { font-size: 0.75rem; font-weight: 800; color: #7c3aed; }
.btn-redeem {
    margin-left: auto;
    padding: 7px 14px;
    border-radius: 50px;
    border: 2px solid #d97706;
    background: white;
    color: #d97706;
    font-size: 0.72rem;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Outfit', sans-serif;
    flex-shrink: 0;
    transition: all 0.2s ease;
}
</style>
@endsection

@section('header')
    <a href="{{ route('home') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">PurePoints</div>
    <div style="width:32px;"></div>
@endsection

@section('content')

{{-- Hero Card --}}
<div class="points-hero">
    <div class="points-hero-label">💜 Poin Anda saat ini</div>
    <div class="points-hero-number">
        1.250
        <span class="pts-label">PTS</span>
    </div>
    <div class="points-hero-sub">≈ Senilai Rp 12.500 · Berlaku s/d Des 2026</div>
    <div class="points-hero-actions">
        <button class="pts-hero-btn white-btn" onclick="document.getElementById('sec-redeem').scrollIntoView({behavior:'smooth'})">
            <i class="fa-solid fa-gift"></i> Tukar Poin
        </button>
        <button class="pts-hero-btn outline-btn" onclick="document.getElementById('sec-earn').scrollIntoView({behavior:'smooth'})">
            <i class="fa-solid fa-plus"></i> Cara Dapat Poin
        </button>
    </div>
</div>

{{-- Stats --}}
<div class="points-stat-grid">
    <div class="points-stat-card">
        <div class="pts-stat-num">3.200</div>
        <div class="pts-stat-lbl">Total Didapat</div>
    </div>
    <div class="points-stat-card">
        <div class="pts-stat-num">1.950</div>
        <div class="pts-stat-lbl">Sudah Ditukar</div>
    </div>
    <div class="points-stat-card">
        <div class="pts-stat-num" style="color:#7c3aed;">1.250</div>
        <div class="pts-stat-lbl">Sisa Aktif</div>
    </div>
</div>

{{-- Recent Transactions --}}
<div class="menu-section-title">Riwayat Poin</div>
<div class="tx-item">
    <div class="tx-left">
        <div class="tx-icon" style="background:#f0fdf4;">🛒</div>
        <div>
            <div class="tx-title">Pembelian Velvet Black Dye</div>
            <div class="tx-date">03 Jul 2026</div>
        </div>
    </div>
    <div class="tx-pts-plus">+95 PTS</div>
</div>
<div class="tx-item">
    <div class="tx-left">
        <div class="tx-icon" style="background:#f0fdf4;">👨‍⚕️</div>
        <div>
            <div class="tx-title">Konsultasi Dr. Jake Damm</div>
            <div class="tx-date">04 Jul 2026</div>
        </div>
    </div>
    <div class="tx-pts-plus">+50 PTS</div>
</div>
<div class="tx-item">
    <div class="tx-left">
        <div class="tx-icon" style="background:#fef2f2;">🎁</div>
        <div>
            <div class="tx-title">Penukaran Voucher 10%</div>
            <div class="tx-date">28 Jun 2026</div>
        </div>
    </div>
    <div class="tx-pts-minus">-500 PTS</div>
</div>
<div class="tx-item">
    <div class="tx-left">
        <div class="tx-icon" style="background:#f0fdf4;">🛒</div>
        <div>
            <div class="tx-title">Pembelian Deep Hydration Balm</div>
            <div class="tx-date">25 Jun 2026</div>
        </div>
    </div>
    <div class="tx-pts-plus">+145 PTS</div>
</div>
<div class="tx-item">
    <div class="tx-left">
        <div class="tx-icon" style="background:#eff6ff;">🎉</div>
        <div>
            <div class="tx-title">Bonus Daftar Member Baru</div>
            <div class="tx-date">20 Jun 2026</div>
        </div>
    </div>
    <div class="tx-pts-plus">+500 PTS</div>
</div>

{{-- How to Earn --}}
<div class="menu-section-title" id="sec-earn">Cara Dapat Poin</div>
<div class="earn-card">
    <div class="earn-icon" style="background:#f0fdf4; color:var(--primary);">🛒</div>
    <div>
        <div class="earn-title">Beli Produk</div>
        <div class="earn-desc">Dapatkan poin dari setiap pembelian produk</div>
    </div>
    <div class="earn-pts">1 PTS<br><span style="font-size:0.62rem; color:var(--text-muted);">per Rp 1.000</span></div>
</div>
<div class="earn-card">
    <div class="earn-icon" style="background:#f0fdf4; color:#16a34a;">👨‍⚕️</div>
    <div>
        <div class="earn-title">Konsultasi Dokter</div>
        <div class="earn-desc">Bonus poin setiap sesi konsultasi selesai</div>
    </div>
    <div class="earn-pts">+50 PTS<br><span style="font-size:0.62rem; color:var(--text-muted);">per sesi</span></div>
</div>
<div class="earn-card">
    <div class="earn-icon" style="background:#faf5ff; color:#7c3aed;">✨</div>
    <div>
        <div class="earn-title">AI Hair Scan</div>
        <div class="earn-desc">Poin bonus setiap melakukan scan rambut</div>
    </div>
    <div class="earn-pts">+30 PTS<br><span style="font-size:0.62rem; color:var(--text-muted);">per scan</span></div>
</div>
<div class="earn-card">
    <div class="earn-icon" style="background:#eff6ff; color:#2563eb;">🎂</div>
    <div>
        <div class="earn-title">Bonus Ulang Tahun</div>
        <div class="earn-desc">Hadiah spesial di hari ulang tahun Anda</div>
    </div>
    <div class="earn-pts">+200 PTS<br><span style="font-size:0.62rem; color:var(--text-muted);">per tahun</span></div>
</div>

{{-- Redeem Section --}}
<div class="menu-section-title" id="sec-redeem">Tukar Poin</div>
<div class="redeem-card">
    <div class="redeem-icon">🎟️</div>
    <div style="flex:1;">
        <div class="redeem-title">Voucher Diskon 10%</div>
        <div class="redeem-desc">Berlaku untuk semua produk di marketplace</div>
        <div class="redeem-cost">🔮 500 Poin</div>
    </div>
    <button class="btn-redeem" onclick="alert('Fitur penukaran poin segera hadir! 🚀')">Tukar</button>
</div>
<div class="redeem-card">
    <div class="redeem-icon">🩺</div>
    <div style="flex:1;">
        <div class="redeem-title">Konsultasi Gratis 1×</div>
        <div class="redeem-desc">Konsultasi dokter tanpa biaya tambahan</div>
        <div class="redeem-cost">🔮 1.000 Poin</div>
    </div>
    <button class="btn-redeem" onclick="alert('Fitur penukaran poin segera hadir! 🚀')">Tukar</button>
</div>
<div class="redeem-card">
    <div class="redeem-icon">💎</div>
    <div style="flex:1;">
        <div class="redeem-title">Upgrade ke Premium 1 Bulan</div>
        <div class="redeem-desc">Nikmati semua fitur Premium selama 30 hari</div>
        <div class="redeem-cost">🔮 2.000 Poin</div>
    </div>
    <button class="btn-redeem" onclick="alert('Fitur penukaran poin segera hadir! 🚀')">Tukar</button>
</div>

@endsection
