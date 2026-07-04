@extends('layouts.app')

@section('title', 'Subscription - PureStrands')

@section('styles')
<style>
.sub-hero {
    background: linear-gradient(135deg, #0d5c3a 0%, #10b981 100%);
    border-radius: 18px;
    padding: 24px 20px;
    color: white;
    margin-bottom: 24px;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.sub-hero::before {
    content: '';
    position: absolute;
    top: -30px; right: -30px;
    width: 120px; height: 120px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
}
.sub-hero::after {
    content: '';
    position: absolute;
    bottom: -20px; left: -20px;
    width: 80px; height: 80px;
    border-radius: 50%;
    background: rgba(255,255,255,0.05);
}
.sub-hero-icon { font-size: 2.5rem; margin-bottom: 10px; }
.sub-hero-title { font-size: 1.3rem; font-weight: 800; margin-bottom: 6px; }
.sub-hero-sub { font-size: 0.8rem; opacity: 0.85; }

.billing-toggle {
    display: flex;
    background: #f0fdf4;
    border-radius: 50px;
    padding: 4px;
    margin-bottom: 20px;
    border: 1px solid #d1fae5;
}
.billing-btn {
    flex: 1;
    padding: 9px 8px;
    border-radius: 50px;
    border: none;
    background: transparent;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    color: var(--text-muted);
    font-family: 'Outfit', sans-serif;
    transition: all 0.25s ease;
    position: relative;
}
.billing-btn.active {
    background: var(--primary);
    color: white;
    box-shadow: 0 4px 12px rgba(16,185,129,0.35);
}
.billing-btn .discount-pill {
    position: absolute;
    top: -8px; right: 4px;
    background: #f59e0b;
    color: white;
    font-size: 0.55rem;
    font-weight: 800;
    padding: 2px 5px;
    border-radius: 20px;
}

.plan-card {
    background: white;
    border: 2px solid var(--border);
    border-radius: 18px;
    padding: 20px;
    margin-bottom: 16px;
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
}
.plan-card.featured {
    border-color: var(--primary);
    background: linear-gradient(180deg, #f0fdf4 0%, white 100%);
}
.plan-card.featured::before {
    content: '⭐ MOST POPULAR';
    position: absolute;
    top: 0; left: 0; right: 0;
    background: var(--primary);
    color: white;
    text-align: center;
    font-size: 0.65rem;
    font-weight: 800;
    letter-spacing: 0.5px;
    padding: 5px;
}
.plan-card.featured { padding-top: 32px; }

.plan-name { font-size: 1rem; font-weight: 800; margin-bottom: 2px; }
.plan-tagline { font-size: 0.72rem; color: var(--text-muted); margin-bottom: 14px; }
.plan-price-big { font-size: 1.8rem; font-weight: 800; color: var(--primary); line-height: 1; }
.plan-price-orig { font-size: 0.75rem; color: var(--text-muted); text-decoration: line-through; }
.plan-price-period { font-size: 0.72rem; color: var(--text-muted); margin-bottom: 16px; }
.plan-save-badge {
    display: inline-block;
    background: #fef3c7;
    color: #d97706;
    font-size: 0.68rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
    margin-bottom: 14px;
}
.plan-features { list-style: none; padding: 0; margin: 0 0 18px; }
.plan-features li {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.78rem;
    padding: 5px 0;
    border-bottom: 1px solid #f3f4f6;
    color: #374151;
}
.plan-features li:last-child { border-bottom: none; }
.plan-features li .feat-check { color: var(--primary); font-size: 0.75rem; flex-shrink: 0; }
.plan-features li .feat-x { color: #d1d5db; font-size: 0.75rem; flex-shrink: 0; }
.plan-features li.disabled { color: #9ca3af; }

.btn-subscribe {
    width: 100%;
    padding: 13px;
    border-radius: 50px;
    border: none;
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Outfit', sans-serif;
    transition: all 0.2s ease;
}
.btn-subscribe.primary-sub {
    background: var(--primary);
    color: white;
}
.btn-subscribe.outline-sub {
    background: white;
    color: var(--primary);
    border: 2px solid var(--primary);
}

.faq-section { margin-top: 8px; }
.faq-item {
    background: white;
    border: 1px solid var(--border);
    border-radius: 12px;
    margin-bottom: 8px;
    overflow: hidden;
}
.faq-q {
    padding: 13px 16px;
    font-size: 0.8rem;
    font-weight: 700;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    gap: 10px;
}
.faq-a {
    padding: 0 16px 12px;
    font-size: 0.75rem;
    color: var(--text-muted);
    line-height: 1.6;
    display: none;
}
.faq-item.open .faq-a { display: block; }
.faq-item.open .faq-icon { transform: rotate(180deg); }
.faq-icon { transition: transform 0.2s ease; color: var(--primary); flex-shrink: 0; }
</style>
@endsection

@section('header')
    <a href="{{ route('home') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">Subscription</div>
    <div style="width:32px;"></div>
@endsection

@section('content')

{{-- Hero --}}
<div class="sub-hero">
    <div class="sub-hero-icon">💎</div>
    <div class="sub-hero-title">Pilih Paket Terbaik Anda</div>
    <div class="sub-hero-sub">Akses fitur premium untuk rambut sehat & indah bersama PureStrands</div>
</div>

{{-- Billing Toggle --}}
<div class="billing-toggle" id="billingToggle">
    <button class="billing-btn active" id="btn-monthly" onclick="switchBilling('monthly')">Bulanan</button>
    <button class="billing-btn" id="btn-6month" onclick="switchBilling('6month')">
        6 Bulan
        <span class="discount-pill">s.d. -15%</span>
    </button>
    <button class="billing-btn" id="btn-yearly" onclick="switchBilling('yearly')">
        Tahunan
        <span class="discount-pill">s.d. -25%</span>
    </button>
</div>

{{-- Standard Plan --}}
<div class="plan-card" id="plan-standard">
    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
        <div>
            <div class="plan-name">🌿 Standard</div>
            <div class="plan-tagline">Cocok untuk pemula perawatan rambut</div>
        </div>
        <div style="width:40px; height:40px; border-radius:10px; background:#f0fdf4; display:flex; align-items:center; justify-content:center; color:var(--primary); font-size:1.1rem; flex-shrink:0;">
            <i class="fa-solid fa-leaf"></i>
        </div>
    </div>

    {{-- Monthly --}}
    <div class="billing-period" id="std-monthly">
        <div class="plan-price-big">Rp 25.000</div>
        <div class="plan-price-period">per bulan</div>
    </div>
    {{-- 6 Month: diskon 10% --}}
    <div class="billing-period" id="std-6month" style="display:none;">
        <div class="plan-price-orig">Rp 150.000</div>
        <div class="plan-price-big">Rp 135.000</div>
        <div class="plan-price-period">per 6 bulan <span style="color:var(--primary); font-weight:700;">(Rp 22.500/bln)</span></div>
        <span class="plan-save-badge">💰 Hemat Rp 15.000 (10%)</span>
    </div>
    {{-- Yearly: diskon 20% --}}
    <div class="billing-period" id="std-yearly" style="display:none;">
        <div class="plan-price-orig">Rp 300.000</div>
        <div class="plan-price-big">Rp 240.000</div>
        <div class="plan-price-period">per tahun <span style="color:var(--primary); font-weight:700;">(Rp 20.000/bln)</span></div>
        <span class="plan-save-badge">💰 Hemat Rp 60.000 (20%)</span>
    </div>

    <ul class="plan-features">
        <li><i class="fa-solid fa-check feat-check"></i> 1× Konsultasi dokter per bulan</li>
        <li><i class="fa-solid fa-check feat-check"></i> Akses marketplace produk</li>
        <li><i class="fa-solid fa-check feat-check"></i> Riwayat perawatan rambut</li>
        <li><i class="fa-solid fa-check feat-check"></i> Rekomendasi produk AI</li>
        <li class="disabled"><i class="fa-solid fa-xmark feat-x"></i> Konsultasi prioritas</li>
        <li class="disabled"><i class="fa-solid fa-xmark feat-x"></i> AI Hair Scan (beta)</li>
        <li class="disabled"><i class="fa-solid fa-xmark feat-x"></i> Diskon produk eksklusif</li>
    </ul>
    <button class="btn-subscribe outline-sub" onclick="alert('Fitur berlangganan segera hadir! 🚀')">Mulai Standard</button>
</div>

{{-- Premium Plan --}}
<div class="plan-card featured" id="plan-premium">
    <div style="display:flex; justify-content:space-between; align-items:flex-start;">
        <div>
            <div class="plan-name">👑 Premium</div>
            <div class="plan-tagline">Solusi lengkap untuk rambut sempurna</div>
        </div>
        <div style="width:40px; height:40px; border-radius:10px; background:var(--primary); display:flex; align-items:center; justify-content:center; color:white; font-size:1.1rem; flex-shrink:0;">
            <i class="fa-solid fa-crown"></i>
        </div>
    </div>

    {{-- Monthly --}}
    <div class="billing-period" id="prem-monthly">
        <div class="plan-price-big">Rp 45.000</div>
        <div class="plan-price-period">per bulan</div>
    </div>
    {{-- 6 Month: diskon 15% --}}
    <div class="billing-period" id="prem-6month" style="display:none;">
        <div class="plan-price-orig">Rp 270.000</div>
        <div class="plan-price-big">Rp 229.500</div>
        <div class="plan-price-period">per 6 bulan <span style="color:var(--primary); font-weight:700;">(Rp 38.250/bln)</span></div>
        <span class="plan-save-badge">💰 Hemat Rp 40.500 (15%)</span>
    </div>
    {{-- Yearly: diskon 25% --}}
    <div class="billing-period" id="prem-yearly" style="display:none;">
        <div class="plan-price-orig">Rp 540.000</div>
        <div class="plan-price-big">Rp 405.000</div>
        <div class="plan-price-period">per tahun <span style="color:var(--primary); font-weight:700;">(Rp 33.750/bln)</span></div>
        <span class="plan-save-badge">💰 Hemat Rp 135.000 (25%)</span>
    </div>

    <ul class="plan-features">
        <li><i class="fa-solid fa-check feat-check"></i> Konsultasi dokter tak terbatas</li>
        <li><i class="fa-solid fa-check feat-check"></i> Akses marketplace produk</li>
        <li><i class="fa-solid fa-check feat-check"></i> Riwayat perawatan rambut</li>
        <li><i class="fa-solid fa-check feat-check"></i> Rekomendasi produk AI</li>
        <li><i class="fa-solid fa-check feat-check"></i> Konsultasi <strong>prioritas</strong></li>
        <li><i class="fa-solid fa-check feat-check"></i> AI Hair Scan (beta access)</li>
        <li><i class="fa-solid fa-check feat-check"></i> Diskon produk eksklusif 15%</li>
    </ul>
    <button class="btn-subscribe primary-sub" onclick="alert('Fitur berlangganan segera hadir! 🚀')">Mulai Premium</button>
</div>

{{-- Compare Table --}}
<div style="background:white; border:1px solid var(--border); border-radius:16px; padding:16px; margin-bottom:20px;">
    <div style="font-size:0.85rem; font-weight:800; margin-bottom:14px; text-align:center;">Perbandingan Paket</div>
    <table style="width:100%; font-size:0.73rem; border-collapse:collapse;">
        <thead>
            <tr style="border-bottom:2px solid #f0fdf4;">
                <th style="padding:8px 4px; text-align:left; color:var(--text-muted);">Fitur</th>
                <th style="padding:8px 4px; text-align:center; color:#6b7280;">Standard</th>
                <th style="padding:8px 4px; text-align:center; color:var(--primary);">Premium</th>
            </tr>
        </thead>
        <tbody>
            <tr style="border-bottom:1px solid #f9fafb;">
                <td style="padding:9px 4px;">Konsultasi Dokter</td>
                <td style="text-align:center; color:#6b7280; font-weight:600;">1×/bln</td>
                <td style="text-align:center; color:var(--primary); font-weight:700;">Unlimited</td>
            </tr>
            <tr style="border-bottom:1px solid #f9fafb;">
                <td style="padding:9px 4px;">Marketplace Produk</td>
                <td style="text-align:center;">✅</td>
                <td style="text-align:center;">✅</td>
            </tr>
            <tr style="border-bottom:1px solid #f9fafb;">
                <td style="padding:9px 4px;">Konsultasi Prioritas</td>
                <td style="text-align:center; color:#d1d5db;">✗</td>
                <td style="text-align:center;">✅</td>
            </tr>
            <tr style="border-bottom:1px solid #f9fafb;">
                <td style="padding:9px 4px;">AI Hair Scan</td>
                <td style="text-align:center; color:#d1d5db;">✗</td>
                <td style="text-align:center;">✅</td>
            </tr>
            <tr>
                <td style="padding:9px 4px;">Diskon Produk</td>
                <td style="text-align:center; color:#d1d5db;">✗</td>
                <td style="text-align:center; color:var(--primary); font-weight:700;">15%</td>
            </tr>
        </tbody>
    </table>
</div>

{{-- FAQ --}}
<div class="menu-section-title">Pertanyaan Umum</div>
<div class="faq-section">
    <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
            Kapan saya bisa mulai berlangganan?
            <i class="fa-solid fa-chevron-down faq-icon"></i>
        </div>
        <div class="faq-a">Fitur berlangganan sedang dalam pengembangan dan akan segera tersedia. Anda akan mendapat notifikasi saat fitur ini diluncurkan!</div>
    </div>
    <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
            Bisa ganti paket kapan saja?
            <i class="fa-solid fa-chevron-down faq-icon"></i>
        </div>
        <div class="faq-a">Ya, Anda bisa upgrade atau downgrade paket kapan saja. Perubahan akan berlaku di awal periode berikutnya.</div>
    </div>
    <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
            Bagaimana cara pembayaran?
            <i class="fa-solid fa-chevron-down faq-icon"></i>
        </div>
        <div class="faq-a">Kami mendukung berbagai metode pembayaran: Transfer Bank, GoPay, OVO, DANA, dan kartu kredit/debit.</div>
    </div>
    <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
            Apakah ada uji coba gratis?
            <i class="fa-solid fa-chevron-down faq-icon"></i>
        </div>
        <div class="faq-a">Ya! Pengguna baru mendapatkan uji coba gratis 7 hari untuk paket Premium tanpa perlu memasukkan info pembayaran.</div>
    </div>
</div>

@endsection

@section('scripts')
<script>
let currentBilling = 'monthly';

function switchBilling(type) {
    currentBilling = type;
    document.querySelectorAll('.billing-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('btn-' + type).classList.add('active');

    // Hide all periods
    document.querySelectorAll('.billing-period').forEach(el => el.style.display = 'none');

    // Show selected
    const map = { monthly: 'std-monthly', '6month': 'std-6month', yearly: 'std-yearly' };
    const pmap = { monthly: 'prem-monthly', '6month': 'prem-6month', yearly: 'prem-yearly' };
    document.getElementById(map[type]).style.display = 'block';
    document.getElementById(pmap[type]).style.display = 'block';
}

function toggleFaq(el) {
    const item = el.closest('.faq-item');
    item.classList.toggle('open');
}
</script>
@endsection