@extends('layouts.app')

@section('title', 'PurePoints - PureStrands')

@section('styles')
<style>
/* ── Hero Card ── */
.pts-hero {
    background: linear-gradient(135deg, #003d28 0%, #005c3a 60%, #007a4d 100%);
    border-radius: 20px;
    padding: 20px 18px 16px;
    color: white;
    margin-bottom: 16px;
    position: relative;
    overflow: hidden;
}
.pts-hero::before {
    content: '';
    position: absolute;
    top: -30px; right: -30px;
    width: 140px; height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}
.pts-hero-label { font-size: 0.72rem; opacity: 0.75; margin-bottom: 4px; }
.pts-hero-number {
    font-size: 2.6rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 14px;
}
.pts-hero-number span { font-size: 1.1rem; font-weight: 500; opacity: 0.7; margin-left: 4px; }
.pts-coin-icon {
    position: absolute;
    top: 16px; right: 18px;
    width: 44px; height: 44px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    box-shadow: 0 4px 12px rgba(245,158,11,0.4);
}
.pts-progress-bar-bg {
    height: 5px;
    background: rgba(255,255,255,0.2);
    border-radius: 10px;
    margin-bottom: 10px;
    overflow: hidden;
}
.pts-progress-bar-fg {
    height: 100%;
    width: 95%;
    background: linear-gradient(90deg, #4ade80, #22c55e);
    border-radius: 10px;
}
.pts-hero-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.pts-hero-footer-text { font-size: 0.68rem; opacity: 0.7; }
.pts-cara-btn {
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 5px 12px;
    border-radius: 20px;
    cursor: pointer;
    font-family: 'Outfit', sans-serif;
    text-decoration: none;
}

/* ── Stats Row ── */
.pts-stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    margin-bottom: 20px;
}
.pts-stat-box {
    background: white;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 12px 8px;
    text-align: center;
}
.pts-stat-num { font-size: 1.2rem; font-weight: 800; color: var(--primary); }
.pts-stat-lbl { font-size: 0.62rem; color: var(--text-muted); margin-top: 3px; line-height: 1.3; }

/* ── Tabs ── */
.pts-tabs {
    display: flex;
    border-bottom: 2px solid var(--border);
    margin-bottom: 16px;
    gap: 0;
}
.pts-tab-btn {
    flex: 1;
    padding: 10px 4px;
    font-size: 0.8rem;
    font-weight: 600;
    text-align: center;
    cursor: pointer;
    border: none;
    background: none;
    color: var(--text-muted);
    font-family: 'Outfit', sans-serif;
    border-bottom: 2px solid transparent;
    margin-bottom: -2px;
    transition: all 0.2s ease;
}
.pts-tab-btn.active {
    color: var(--primary);
    border-bottom-color: var(--primary);
    font-weight: 700;
}
.pts-tab-content { display: none; }
.pts-tab-content.active { display: block; }

/* ── Voucher Cards ── */
.voucher-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
    overflow: hidden;
    position: relative;
}
.voucher-img {
    width: 60px; height: 60px;
    border-radius: 10px;
    object-fit: cover;
    flex-shrink: 0;
    background: linear-gradient(135deg, var(--primary-light), #d1fae5);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem;
}
.voucher-info { flex: 1; min-width: 0; }
.voucher-name { font-size: 0.82rem; font-weight: 700; margin-bottom: 2px; }
.voucher-validity { font-size: 0.68rem; color: var(--text-muted); margin-bottom: 4px; }
.voucher-source { font-size: 0.65rem; color: var(--primary); font-weight: 600; }
.voucher-price {
    font-size: 0.75rem;
    font-weight: 800;
    color: var(--primary);
    text-decoration: line-through;
    opacity: 0.6;
}
.voucher-price.new { text-decoration: none; opacity: 1; font-size: 0.85rem; }
.btn-tukar {
    padding: 7px 16px;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 0.72rem;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Outfit', sans-serif;
    flex-shrink: 0;
    transition: all 0.2s ease;
}
.btn-tukar.locked {
    background: #e5e7eb;
    color: #9ca3af;
}
.voucher-lock-overlay {
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0.6);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem; color: var(--text-muted); font-weight: 600;
    gap: 6px;
}

/* ── Redeem Cards ── */
.redeem-active-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 16px;
    margin-bottom: 12px;
}
.redeem-card-top {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    margin-bottom: 14px;
}
.redeem-thumb {
    width: 52px; height: 52px;
    border-radius: 10px;
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}
.redeem-title { font-size: 0.88rem; font-weight: 700; }
.redeem-subtitle { font-size: 0.72rem; color: var(--text-muted); margin-top: 2px; }
.redeem-expiry {
    font-size: 0.7rem;
    color: var(--text-muted);
    margin-bottom: 12px;
}
.redeem-expiry strong { color: var(--text-main); }
.redeem-actions {
    display: flex;
    gap: 8px;
    margin-bottom: 10px;
}
.btn-salin {
    flex: 1;
    padding: 9px;
    border: 2px solid var(--primary);
    background: white;
    color: var(--primary);
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Outfit', sans-serif;
    display: flex; align-items: center; justify-content: center; gap: 6px;
}
.btn-qr {
    padding: 9px 14px;
    border: 2px solid #e5e7eb;
    background: white;
    color: #6b7280;
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Outfit', sans-serif;
    display: flex; align-items: center; gap: 5px;
}
.redeem-status-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 10px;
    border-top: 1px solid #f3f4f6;
}
.redeem-type-badge {
    font-size: 0.65rem;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 8px;
    background: #f0fdf4;
    color: var(--primary);
}
.status-siap {
    font-size: 0.72rem;
    font-weight: 700;
    color: #16a34a;
    display: flex; align-items: center; gap: 4px;
}
.challenge-banner {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 1px solid #bbf7d0;
    border-radius: 14px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 4px;
    cursor: pointer;
}
.challenge-title { font-size: 0.82rem; font-weight: 700; color: var(--primary); margin-bottom: 3px; }
.challenge-desc { font-size: 0.7rem; color: #047857; }

/* ── Expired Cards ── */
.expired-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 12px 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
    opacity: 0.8;
}
.expired-thumb {
    width: 52px; height: 52px;
    border-radius: 10px;
    object-fit: cover;
    background: #f3f4f6;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
    filter: grayscale(0.4);
}
.expired-name { font-size: 0.8rem; font-weight: 700; color: #6b7280; margin-bottom: 2px; }
.expired-date { font-size: 0.67rem; color: var(--text-muted); margin-bottom: 4px; }
.expired-badge {
    font-size: 0.62rem;
    font-weight: 800;
    letter-spacing: 0.3px;
    padding: 3px 8px;
    border-radius: 6px;
}
.badge-used { background: #f0fdf4; color: #16a34a; }
.badge-expired { background: #fef2f2; color: #ef4444; }

/* ── Earn Cards ── */
.earn-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.02);
}
.earn-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.35rem;
    flex-shrink: 0;
}
.earn-title { font-size: 0.95rem; font-weight: 700; color: var(--text-main); margin-bottom: 3px; }
.earn-desc { font-size: 0.75rem; color: var(--text-muted); line-height: 1.3; }
.earn-pts {
    margin-left: auto;
    font-size: 1rem;
    font-weight: 800;
    color: var(--primary);
    flex-shrink: 0;
    text-align: right;
    line-height: 1.2;
}
</style>
@endsection

@section('header')
    <a href="{{ route('home') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">Redeem Voucher</div>
    <i class="fa-regular fa-bell" style="font-size:1.1rem; color:var(--text-muted); cursor:pointer;"></i>
@endsection

@section('content')

{{-- Hero Card --}}
<div class="pts-hero">
    <div class="pts-coin-icon">🪙</div>
    <div class="pts-hero-label">Poin kamu saat ini</div>
    <div class="pts-hero-number">1.250 <span>poin</span></div>
    <div class="pts-progress-bar-bg">
        <div class="pts-progress-bar-fg" style="width: 95%;"></div>
    </div>
    <div class="pts-hero-footer">
        <span class="pts-hero-footer-text">66 poin lagi untuk level berikutnya</span>
        <a href="#sec-earn" class="pts-cara-btn" onclick="scrollToEarn(event)">Cara dapat poin</a>
    </div>
</div>

{{-- Stats --}}
<div class="pts-stats-row">
    <div class="pts-stat-box">
        <div class="pts-stat-num">3.200</div>
        <div class="pts-stat-lbl">Total Didapat</div>
    </div>
    <div class="pts-stat-box">
        <div class="pts-stat-num">1.950</div>
        <div class="pts-stat-lbl">Sudah Ditukar</div>
    </div>
    <div class="pts-stat-box">
        <div class="pts-stat-num" style="color:#7c3aed;">1.250</div>
        <div class="pts-stat-lbl">Sisa Aktif</div>
    </div>
</div>

{{-- Tabs --}}
<div class="pts-tabs">
    <button class="pts-tab-btn active" onclick="switchPtsTab('voucher', this)">Voucher</button>
    <button class="pts-tab-btn" onclick="switchPtsTab('redeem', this)">Redeem</button>
    <button class="pts-tab-btn" onclick="switchPtsTab('expired', this)">Expired</button>
</div>

{{-- TAB: Voucher --}}
<div class="pts-tab-content active" id="pts-tab-voucher">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
        <div style="font-size:0.82rem; font-weight:700;">Voucher tersedia (5)</div>
        <a href="#" style="font-size:0.72rem; color:var(--primary); font-weight:600; text-decoration:none;">Lihat semua &rsaquo;</a>
    </div>

    <div class="voucher-card">
        <div class="voucher-img">🧴</div>
        <div class="voucher-info">
            <div class="voucher-name">Diskon Produk 25%</div>
            <div class="voucher-validity">Berlaku sampai 30 Des 2024</div>
            <div class="voucher-source">PureStrand · Semua Produk</div>
        </div>
        <button class="btn-tukar" onclick="alert('Fitur tukar poin segera hadir! 🚀')">Tukar</button>
    </div>

    <div class="voucher-card">
        <div class="voucher-img">🪮</div>
        <div class="voucher-info">
            <div class="voucher-name">Voucher Shampoo</div>
            <div class="voucher-validity">Berlaku sampai 30 Des 2024</div>
            <div class="voucher-source">PureStrand · Shampoo Series</div>
        </div>
        <button class="btn-tukar" onclick="alert('Fitur tukar poin segera hadir! 🚀')">Tukar</button>
    </div>

    <div class="voucher-card">
        <div class="voucher-img">💆</div>
        <div class="voucher-info">
            <div class="voucher-name">Voucher Hair Serum</div>
            <div class="voucher-validity">Berlaku sampai 30 Des 2024</div>
            <div class="voucher-source">PureStrand · Serum Collection</div>
        </div>
        <button class="btn-tukar" onclick="alert('Fitur tukar poin segera hadir! 🚀')">Tukar</button>
    </div>

    <div class="voucher-card">
        <div class="voucher-img">🧪</div>
        <div class="voucher-info">
            <div class="voucher-name">Voucher Scalp Care</div>
            <div class="voucher-validity">Berlaku sampai 30 Des 2024</div>
            <div class="voucher-source">PureStrand Center · Scalp Treatment</div>
        </div>
        <button class="btn-tukar" onclick="alert('Fitur tukar poin segera hadir! 🚀')">Tukar</button>
    </div>

    <div class="voucher-card" style="position:relative;">
        <div class="voucher-img" style="opacity:0.5;">🎁</div>
        <div class="voucher-info" style="opacity:0.5;">
            <div class="voucher-name">Konsultasi Gratis 1×</div>
            <div class="voucher-validity">Berlaku sampai 30 Des 2024</div>
            <div class="voucher-source">PureStrand · Doctor Session</div>
        </div>
        <button class="btn-tukar locked" disabled>Terkunci</button>
        <div class="voucher-lock-overlay">
            <i class="fa-solid fa-lock" style="font-size:0.9rem;"></i>
            500 poin lagi
        </div>
    </div>
</div>

{{-- TAB: Redeem --}}
<div class="pts-tab-content" id="pts-tab-redeem">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
        <div style="font-size:0.88rem; font-weight:800;">Voucher Aktif</div>
        <a href="#" style="font-size:0.72rem; color:var(--primary); font-weight:600; text-decoration:none;">Lihat Semua &rsaquo;</a>
    </div>

    <div class="redeem-active-card">
        <div class="redeem-card-top">
            <div class="redeem-thumb">💊</div>
            <div>
                <div class="redeem-title">Potongan Rp 50.000</div>
                <div class="redeem-subtitle">PureStrand Scalp Treatment</div>
            </div>
        </div>
        <div class="redeem-expiry">BERLAKU HINGGA <strong>31 Okt 2024</strong></div>
        <div class="redeem-actions">
            <button class="btn-salin" onclick="copyCode('PURE50K')">
                <i class="fa-regular fa-copy"></i> Salin Kode
            </button>
        </div>
        <div class="redeem-status-row">
            <span class="redeem-type-badge">E-Voucher</span>
            <span class="status-siap"><i class="fa-solid fa-circle-check"></i> Siap Pakai</span>
        </div>
    </div>

    <div class="redeem-active-card">
        <div class="redeem-card-top">
            <div class="redeem-thumb">🧴</div>
            <div>
                <div class="redeem-title">Diskon 20%</div>
                <div class="redeem-subtitle">All Serum &amp; Tonics</div>
            </div>
        </div>
        <div class="redeem-expiry">BERLAKU HINGGA <strong>15 Nov 2024</strong></div>
        <div class="redeem-actions">
            <button class="btn-salin" onclick="copyCode('SERUM20')">
                <i class="fa-regular fa-copy"></i> Salin Kode
            </button>
            <button class="btn-qr" onclick="alert('QR Code akan tampil di sini')">
                <i class="fa-solid fa-qrcode"></i> Lihat QR
            </button>
        </div>
        <div class="redeem-status-row">
            <span class="redeem-type-badge">E-Voucher</span>
            <span class="status-siap"><i class="fa-solid fa-circle-check"></i> Siap Pakai</span>
        </div>
    </div>

    <div class="redeem-active-card">
        <div class="redeem-card-top">
            <div class="redeem-thumb">🩺</div>
            <div>
                <div class="redeem-title">Free Consultation</div>
                <div class="redeem-subtitle">With Professional Dermatologist</div>
            </div>
        </div>
        <div class="redeem-expiry">BERLAKU HINGGA <strong>01 Des 2024</strong></div>
        <div class="redeem-actions">
            <button class="btn-salin" onclick="copyCode('FREECONSULT')">
                <i class="fa-regular fa-copy"></i> Salin Kode
            </button>
        </div>
        <div class="redeem-status-row">
            <span class="redeem-type-badge">E-Voucher</span>
            <span class="status-siap"><i class="fa-solid fa-circle-check"></i> Siap Pakai</span>
        </div>
    </div>

    {{-- Challenge Banner --}}
    <div class="challenge-banner" onclick="alert('Tantangan harian segera hadir! 🚀')">
        <div>
            <div class="challenge-title">Ingin poin lebih banyak?</div>
            <div class="challenge-desc">Selesaikan tantangan harian dan dapatkan ribuan poin tambahan.</div>
        </div>
        <i class="fa-solid fa-chevron-right" style="color:var(--primary); font-size:0.9rem;"></i>
    </div>
</div>

{{-- TAB: Expired --}}
<div class="pts-tab-content" id="pts-tab-expired">
    <div style="font-size:0.82rem; font-weight:700; margin-bottom:12px; color:var(--text-muted);">Riwayat Voucher (3)</div>

    <div class="expired-card">
        <div class="expired-thumb">🌿</div>
        <div style="flex:1; min-width:0;">
            <div style="font-size:0.62rem; font-weight:700; color:var(--text-muted); letter-spacing:0.5px; margin-bottom:2px;">DISKON 20%</div>
            <div class="expired-name">Potongan Produk Herbal Essence</div>
            <div class="expired-date">Berlaku hingga 12 Okt 2023</div>
            <span class="expired-badge badge-used">SUDAH DIGUNAKAN</span>
        </div>
    </div>

    <div class="expired-card">
        <div class="expired-thumb">🚚</div>
        <div style="flex:1; min-width:0;">
            <div style="font-size:0.62rem; font-weight:700; color:var(--text-muted); letter-spacing:0.5px; margin-bottom:2px;">GRATIS ONGKIR</div>
            <div class="expired-name">Voucher Gratis Ongkir Toko</div>
            <div class="expired-date">Berlaku hingga 05 Okt 2023</div>
            <span class="expired-badge badge-expired">KADALUWARSA</span>
        </div>
    </div>

    <div class="expired-card">
        <div class="expired-thumb">💰</div>
        <div style="flex:1; min-width:0;">
            <div style="font-size:0.62rem; font-weight:700; color:var(--text-muted); letter-spacing:0.5px; margin-bottom:2px;">CASHBACK 5K</div>
            <div class="expired-name">Konsultasi Dokter Kulit</div>
            <div class="expired-date">Berlaku hingga 01 Okt 2023</div>
            <span class="expired-badge badge-used">SUDAH DIGUNAKAN</span>
        </div>
    </div>

    <div style="text-align:center; padding:24px 0 8px; color:var(--text-muted);">
        <i class="fa-regular fa-clock-rotate-left" style="font-size:2rem; opacity:0.3; display:block; margin-bottom:8px;"></i>
        <div style="font-size:0.75rem;">Riwayat voucher Anda akan muncul di sini</div>
    </div>
</div>

{{-- ── Cara Dapat Poin ── --}}
<div id="sec-earn" style="margin-top:24px; margin-bottom:16px;">
    <div class="menu-section-title">Cara Dapat Poin</div>
    
    <div class="earn-card">
        <div class="earn-icon" style="background:#f0fdf4; color:var(--primary);">🛒</div>
        <div style="flex:1;">
            <div class="earn-title">Beli Produk</div>
            <div class="earn-desc">Dapatkan poin dari setiap pembelian produk</div>
        </div>
        <div class="earn-pts">
            1 PTS
            <div style="font-size:0.65rem; color:var(--text-muted); font-weight:700; margin-top:2px;">per Rp 1.000</div>
        </div>
    </div>
    
    <div class="earn-card">
        <div class="earn-icon" style="background:#f0fdf4; color:#16a34a;">👨‍⚕️</div>
        <div style="flex:1;">
            <div class="earn-title">Konsultasi Dokter</div>
            <div class="earn-desc">Bonus poin setiap sesi konsultasi selesai</div>
        </div>
        <div class="earn-pts">
            +50 PTS
            <div style="font-size:0.65rem; color:var(--text-muted); font-weight:700; margin-top:2px;">per sesi</div>
        </div>
    </div>
    
    <div class="earn-card">
        <div class="earn-icon" style="background:#faf5ff; color:#7c3aed;">✨</div>
        <div style="flex:1;">
            <div class="earn-title">AI Hair Scan</div>
            <div class="earn-desc">Poin bonus setiap melakukan scan rambut</div>
        </div>
        <div class="earn-pts">
            +30 PTS
            <div style="font-size:0.65rem; color:var(--text-muted); font-weight:700; margin-top:2px;">per scan</div>
        </div>
    </div>
    
    <div class="earn-card">
        <div class="earn-icon" style="background:#eff6ff; color:#2563eb;">🎂</div>
        <div style="flex:1;">
            <div class="earn-title">Bonus Ulang Tahun</div>
            <div class="earn-desc">Hadiah spesial di hari ulang tahun Anda</div>
        </div>
        <div class="earn-pts">
            +200 PTS
            <div style="font-size:0.65rem; color:var(--text-muted); font-weight:700; margin-top:2px;">per tahun</div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
function switchPtsTab(tab, el) {
    document.querySelectorAll('.pts-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.pts-tab-content').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('pts-tab-' + tab).classList.add('active');
}

function copyCode(code) {
    navigator.clipboard.writeText(code).then(() => {
        alert('Kode "' + code + '" berhasil disalin! ✅');
    }).catch(() => {
        alert('Kode: ' + code);
    });
}

function scrollToEarn(e) {
    e.preventDefault();
    document.getElementById('sec-earn').scrollIntoView({ behavior: 'smooth' });
}
</script>
@endsection
