@extends('layouts.app')

@section('title', 'PurePoints - PureStrands')

@section('styles')
<style>
/* =====================================================
   HERO CARD — Green, matching Redeem Voucher page
   ===================================================== */
.points-hero {
    background: linear-gradient(135deg, #004B38 0%, #007A55 50%, #00A878 100%);
    border-radius: 20px;
    padding: 22px 20px 18px;
    color: white;
    margin-bottom: 16px;
    position: relative;
    overflow: hidden;
}
.points-hero::before {
    content: '';
    position: absolute;
    top: -50px; right: -30px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    pointer-events: none;
}
.points-hero::after {
    content: '';
    position: absolute;
    bottom: -30px; left: -20px;
    width: 100px; height: 100px;
    border-radius: 50%;
    background: rgba(255,255,255,0.04);
    pointer-events: none;
}
.hero-top-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 2px;
}
.points-hero-label { font-size: 0.7rem; opacity: 0.75; letter-spacing: 0.02em; }
.hero-coin-badge {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: rgba(255,255,255,0.18);
    border: 2px solid rgba(255,255,255,0.35);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    position: relative; z-index: 1;
}
.points-hero-number {
    font-size: 2.8rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 2px;
    display: flex;
    align-items: baseline;
    gap: 8px;
}
.points-hero-number .pts-label { font-size: 1rem; opacity: 0.65; font-weight: 600; }
.points-hero-sub { font-size: 0.72rem; opacity: 0.75; margin-bottom: 4px; }

/* Progress bar */
.pts-progress-bar {
    width: 100%;
    height: 5px;
    background: rgba(255,255,255,0.2);
    border-radius: 3px;
    margin: 12px 0 16px;
    overflow: hidden;
}
.pts-progress-fill {
    height: 100%;
    width: 62%;
    background: rgba(255,255,255,0.8);
    border-radius: 3px;
    animation: progressGrow 1s ease-out both;
}
@keyframes progressGrow {
    from { width: 0; }
    to { width: 62%; }
}
.pts-progress-label {
    display: flex;
    justify-content: space-between;
    font-size: 0.63rem;
    opacity: 0.7;
    margin-bottom: 14px;
}

.points-hero-actions { display: flex; gap: 10px; position: relative; z-index: 1; }
.pts-hero-btn {
    flex: 1;
    padding: 9px 6px;
    border-radius: 12px;
    border: none;
    font-family: 'Outfit', sans-serif;
    font-size: 0.72rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.18s ease;
    text-align: center;
}
.pts-hero-btn:active { transform: scale(0.94); }
.pts-hero-btn.white-btn { background: white; color: #004B38; }
.pts-hero-btn.outline-btn {
    background: rgba(255,255,255,0.15);
    color: white;
    border: 1.5px solid rgba(255,255,255,0.35);
}

/* =====================================================
   STATS ROW
   ===================================================== */
.points-stat-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    margin-bottom: 16px;
}
.points-stat-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 12px 8px;
    text-align: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.points-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 18px rgba(0, 75, 56, 0.12);
}
.pts-stat-num { font-size: 1.15rem; font-weight: 800; color: var(--primary); }
.pts-stat-lbl { font-size: 0.6rem; color: var(--text-muted); margin-top: 3px; line-height: 1.2; }

/* =====================================================
   TAB SYSTEM
   ===================================================== */
.pts-tab-list {
    display: flex;
    align-items: center;
    background: #f3f4f2;
    border-radius: 12px;
    padding: 4px;
    margin-bottom: 18px;
    position: relative;
    overflow: hidden;
    border: 1px solid var(--border);
}
.pts-tab-pill {
    position: absolute;
    top: 4px;
    left: 4px;
    height: calc(100% - 8px);
    background: var(--primary);
    border-radius: 9px;
    transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1),
                width 0.28s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 0;
    will-change: transform, width;
}
.pts-tab-item {
    flex: 1;
    padding: 8px 4px;
    text-align: center;
    font-size: 0.71rem;
    font-weight: 600;
    color: var(--text-muted);
    cursor: pointer;
    border-radius: 9px;
    position: relative;
    z-index: 1;
    transition: color 0.25s ease;
    user-select: none;
    white-space: nowrap;
}
.pts-tab-item.active { color: white; }

/* =====================================================
   TAB PANES
   ===================================================== */
.pts-tab-pane { display: none; }
.pts-tab-pane.active { display: block; }

/* =====================================================
   VOUCHER / RIWAYAT CARD — like screenshot
   ===================================================== */
.voucher-list-item {
    background: white;
    border: 1px solid var(--border);
    border-radius: 14px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
}
.voucher-list-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 75, 56, 0.12);
}
.voucher-img {
    width: 80px;
    min-width: 80px;
    height: 80px;
    object-fit: cover;
    display: block;
}
.voucher-img-placeholder {
    width: 80px;
    min-width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    flex-shrink: 0;
}
.voucher-body {
    flex: 1;
    padding: 10px 12px;
    min-width: 0;
}
.voucher-badge {
    display: inline-block;
    font-size: 0.55rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    padding: 2px 7px;
    border-radius: 50px;
    margin-bottom: 4px;
}
.voucher-badge.green { background: #e6f5ee; color: #004B38; }
.voucher-badge.blue  { background: #eff6ff; color: #1d4ed8; }
.voucher-badge.orange { background: #fef3c7; color: #92400e; }
.voucher-badge.red { background: #fef2f2; color: #b91c1c; }
.voucher-title {
    font-size: 0.82rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.voucher-sub { font-size: 0.67rem; color: var(--text-muted); }
.voucher-right {
    padding: 10px 14px 10px 6px;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 6px;
    flex-shrink: 0;
}
.tx-pts-plus {
    font-size: 0.88rem;
    font-weight: 800;
    color: #16a34a;
}
.tx-pts-minus {
    font-size: 0.88rem;
    font-weight: 800;
    color: #ef4444;
}
.btn-redeem {
    padding: 6px 14px;
    border-radius: 50px;
    border: 1.5px solid #004B38;
    background: white;
    color: #004B38;
    font-size: 0.7rem;
    font-weight: 700;
    cursor: pointer;
    font-family: 'Outfit', sans-serif;
    transition: all 0.18s ease;
    white-space: nowrap;
}
.btn-redeem:hover { background: #004B38; color: white; }
.btn-redeem:active { transform: scale(0.9); }
.btn-redeem.disabled {
    border-color: #ccc;
    color: #999;
    cursor: default;
}
.btn-redeem.disabled:hover { background: white; color: #999; }

/* =====================================================
   CARA DAPAT — AI card (full width featured)
   ===================================================== */
.ai-earn-card {
    border-radius: 18px;
    overflow: hidden;
    margin-bottom: 12px;
    border: 1px solid #c6eed9;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.ai-earn-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(0, 75, 56, 0.15);
}
.ai-earn-card-img {
    width: 100%;
    height: 130px;
    object-fit: cover;
    display: block;
}
.ai-earn-card-body {
    background: linear-gradient(135deg, #f0fdf6, #e6f5ee);
    padding: 16px;
}
.ai-earn-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #004B38;
    color: white;
    font-size: 0.6rem;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 50px;
    margin-bottom: 8px;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}
.ai-earn-title {
    font-size: 0.95rem;
    font-weight: 800;
    color: #004B38;
    margin-bottom: 4px;
}
.ai-earn-desc {
    font-size: 0.72rem;
    color: #555;
    line-height: 1.5;
    margin-bottom: 12px;
}
.ai-earn-pts-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: white;
    border: 1.5px solid #00A878;
    border-radius: 50px;
    padding: 5px 14px;
    font-size: 0.75rem;
    font-weight: 700;
    color: #004B38;
}

.earn-rule-card {
    background: white;
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 13px 16px;
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 8px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.earn-rule-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(0,75,56,0.08);
}
.earn-rule-num {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: var(--primary);
    color: white;
    font-size: 0.75rem;
    font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
}
.earn-rule-title { font-size: 0.8rem; font-weight: 700; color: #1a1a1a; margin-bottom: 2px; }
.earn-rule-desc { font-size: 0.68rem; color: var(--text-muted); line-height: 1.4; }

/* =====================================================
   SCROLL REVEAL
   ===================================================== */
.reveal-card {
    opacity: 0;
    transform: translateY(18px);
    transition: opacity 0.42s ease, transform 0.42s ease;
}
.reveal-card.revealed {
    opacity: 1;
    transform: translateY(0);
}
</style>
@endsection

@section('header')
    <a href="{{ route('home') }}" class="back-btn"><i class="fa-solid fa-arrow-left"></i></a>
    <div class="header-title">PurePoints</div>
    <div style="width:32px;"></div>
@endsection

@section('content')

{{-- ─── Hero Card ──────────────────────────────────────── --}}
<div class="points-hero">
    <div class="hero-top-row">
        <div class="points-hero-label">Poin kamu saat ini</div>
        <div class="hero-coin-badge">🪙</div>
    </div>
    <div class="points-hero-number">
        1.250
        <span class="pts-label">poin</span>
    </div>
    <div class="points-hero-sub">≈ Senilai Rp 125.000 · 1 PTS = Rp 100</div>

    <div class="pts-progress-bar">
        <div class="pts-progress-fill"></div>
    </div>
    <div class="pts-progress-label">
        <span>1.250 / 2.000 PTS menuju Gold</span>
        <span>Cari Tahu →</span>
    </div>

    <div class="points-hero-actions">
        <button class="pts-hero-btn white-btn" onclick="switchTab('redeem')">
            <i class="fa-solid fa-gift"></i> Tukar Poin
        </button>
        <button class="pts-hero-btn outline-btn" onclick="switchTab('earn')">
            <i class="fa-solid fa-sparkles"></i> Cara Dapat
        </button>
    </div>
</div>

{{-- ─── Stats (always visible) ─────────────────────────── --}}
<div class="points-stat-grid">
    <div class="points-stat-card">
        <div class="pts-stat-num">3.200</div>
        <div class="pts-stat-lbl">Total<br>Didapat</div>
    </div>
    <div class="points-stat-card">
        <div class="pts-stat-num">1.950</div>
        <div class="pts-stat-lbl">Sudah<br>Ditukar</div>
    </div>
    <div class="points-stat-card">
        <div class="pts-stat-num">1.250</div>
        <div class="pts-stat-lbl">Sisa<br>Aktif</div>
    </div>
</div>

{{-- ─── Tab Navigation ─────────────────────────────────── --}}
<div class="pts-tab-list" id="pts-tabs">
    <div class="pts-tab-pill" id="pts-tab-pill"></div>
    <div class="pts-tab-item active" id="tab-riwayat" onclick="switchTab('riwayat')">Riwayat</div>
    <div class="pts-tab-item" id="tab-earn"    onclick="switchTab('earn')">Cara Dapat</div>
    <div class="pts-tab-item" id="tab-redeem"  onclick="switchTab('redeem')">Tukar Poin</div>
</div>

{{-- ═══════════════════════════════════════════════════════
     TAB PANE — Riwayat
     ═══════════════════════════════════════════════════════ --}}
<div class="pts-tab-pane active" id="pane-riwayat">

    {{-- Pembelian Velvet Black Dye --}}
    <div class="voucher-list-item reveal-card">
        <img class="voucher-img"
             src="https://images.unsplash.com/photo-1522337660859-02fbefca4702?w=160&q=80&fit=crop"
             alt="Produk">
        <div class="voucher-body">
            <span class="voucher-badge green">Pembelian</span>
            <div class="voucher-title">Velvet Black Dye</div>
            <div class="voucher-sub">03 Jul 2026</div>
        </div>
        <div class="voucher-right">
            <div class="tx-pts-plus">+95 PTS</div>
            <div style="font-size:0.6rem;color:var(--text-muted);">≈ Rp 9.500</div>
        </div>
    </div>

    {{-- Konsultasi --}}
    <div class="voucher-list-item reveal-card">
        <img class="voucher-img"
             src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=160&q=80&fit=crop"
             alt="Dokter">
        <div class="voucher-body">
            <span class="voucher-badge blue">Konsultasi</span>
            <div class="voucher-title">Dr. Jake Damm</div>
            <div class="voucher-sub">04 Jul 2026</div>
        </div>
        <div class="voucher-right">
            <div class="tx-pts-plus">+50 PTS</div>
            <div style="font-size:0.6rem;color:var(--text-muted);">≈ Rp 5.000</div>
        </div>
    </div>

    {{-- Penukaran voucher --}}
    <div class="voucher-list-item reveal-card">
        <img class="voucher-img"
             src="https://images.unsplash.com/photo-1607083206968-13611e3d76db?w=160&q=80&fit=crop"
             alt="Voucher">
        <div class="voucher-body">
            <span class="voucher-badge orange">Tukar Poin</span>
            <div class="voucher-title">Voucher Diskon 10%</div>
            <div class="voucher-sub">28 Jun 2026</div>
        </div>
        <div class="voucher-right">
            <div class="tx-pts-minus">−500 PTS</div>
            <div style="font-size:0.6rem;color:var(--text-muted);">≈ Rp 50.000</div>
        </div>
    </div>

    {{-- Pembelian Deep Hydration --}}
    <div class="voucher-list-item reveal-card">
        <img class="voucher-img"
             src="https://images.unsplash.com/photo-1521590832167-7bfc17484d20?w=160&q=80&fit=crop"
             alt="Produk">
        <div class="voucher-body">
            <span class="voucher-badge green">Pembelian</span>
            <div class="voucher-title">Deep Hydration Balm</div>
            <div class="voucher-sub">25 Jun 2026</div>
        </div>
        <div class="voucher-right">
            <div class="tx-pts-plus">+145 PTS</div>
            <div style="font-size:0.6rem;color:var(--text-muted);">≈ Rp 14.500</div>
        </div>
    </div>

    {{-- Bonus daftar --}}
    <div class="voucher-list-item reveal-card">
        <div class="voucher-img-placeholder" style="background:#f0fdf4;">🎉</div>
        <div class="voucher-body">
            <span class="voucher-badge green">Bonus</span>
            <div class="voucher-title">Daftar Member Baru</div>
            <div class="voucher-sub">20 Jun 2026</div>
        </div>
        <div class="voucher-right">
            <div class="tx-pts-plus">+500 PTS</div>
            <div style="font-size:0.6rem;color:var(--text-muted);">≈ Rp 50.000</div>
        </div>
    </div>

    {{-- Tanya AI --}}
    <div class="voucher-list-item reveal-card">
        <div class="voucher-img-placeholder" style="background: linear-gradient(135deg,#e6f5ee,#c6eed9);">✨</div>
        <div class="voucher-body">
            <span class="voucher-badge green">AI Chat</span>
            <div class="voucher-title">Tanya AI — 5 Pertanyaan</div>
            <div class="voucher-sub">18 Jun 2026</div>
        </div>
        <div class="voucher-right">
            <div class="tx-pts-plus">+25 PTS</div>
            <div style="font-size:0.6rem;color:var(--text-muted);">≈ Rp 2.500</div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     TAB PANE — Cara Dapat Poin
     ═══════════════════════════════════════════════════════ --}}
<div class="pts-tab-pane" id="pane-earn">

    {{-- Featured AI Card --}}
    <div class="ai-earn-card reveal-card">
        <img class="ai-earn-card-img"
             src="https://images.unsplash.com/photo-1676299082056-75c53f5e1fa2?w=700&q=85&fit=crop"
             alt="AI Hair Chat">
        <div class="ai-earn-card-body">
            <div class="ai-earn-badge">
                <i class="fa-solid fa-robot" style="font-size:0.65rem;"></i>
                Satu-satunya cara
            </div>
            <div class="ai-earn-title">Bertanya kepada AI PureStrands</div>
            <div class="ai-earn-desc">
                Ajukan pertanyaan seputar perawatan rambut ke AI kami. Setiap pertanyaan yang kamu kirimkan akan memberikan poin yang bisa ditukarkan dengan voucher dan reward eksklusif.
            </div>
            <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                <div class="ai-earn-pts-chip">
                    ✨ +5 PTS per pertanyaan
                </div>
                <div style="font-size:0.65rem; color:#555;">= Rp 500 per tanya</div>
            </div>
        </div>
    </div>

    {{-- Rules --}}
    <div style="font-size:0.75rem; font-weight:700; color:var(--primary); margin-bottom:10px; margin-top:4px;">
        📋 Ketentuan
    </div>

    <div class="earn-rule-card reveal-card">
        <div class="earn-rule-num">1</div>
        <div>
            <div class="earn-rule-title">Login & buka fitur AI Chat</div>
            <div class="earn-rule-desc">Pastikan kamu sudah login dan buka menu AI dari halaman utama PureStrands.</div>
        </div>
    </div>
    <div class="earn-rule-card reveal-card">
        <div class="earn-rule-num">2</div>
        <div>
            <div class="earn-rule-title">Kirim pertanyaan seputar rambut</div>
            <div class="earn-rule-desc">Setiap satu pesan yang kamu kirimkan ke AI akan otomatis dicatat sebagai satu poin aktivitas.</div>
        </div>
    </div>
    <div class="earn-rule-card reveal-card">
        <div class="earn-rule-num">3</div>
        <div>
            <div class="earn-rule-title">Poin dikreditkan otomatis</div>
            <div class="earn-rule-desc">+5 PTS (= Rp 500) dikreditkan ke akun kamu sesaat setelah AI membalas pertanyaanmu.</div>
        </div>
    </div>
    <div class="earn-rule-card reveal-card">
        <div class="earn-rule-num">4</div>
        <div>
            <div class="earn-rule-title">Maks. 20 pertanyaan per hari</div>
            <div class="earn-rule-desc">Kamu bisa mengumpulkan hingga +100 PTS (= Rp 10.000) per hari dari fitur AI Chat.</div>
        </div>
    </div>

    {{-- Info box --}}
    <div style="background:#f0fdf4; border:1px solid #c6eed9; border-radius:12px; padding:14px 16px; margin-top:4px; display:flex; align-items:flex-start; gap:10px;" class="reveal-card">
        <span style="font-size:1.2rem; flex-shrink:0; margin-top:1px;">💡</span>
        <div style="font-size:0.7rem; color:#004B38; line-height:1.55;">
            <strong>Ingat:</strong> Saat ini satu-satunya cara mendapatkan PurePoints adalah melalui fitur <strong>Tanya AI</strong>. Cara lain (pembelian, konsultasi, dll.) sedang dalam pengembangan dan akan hadir segera.
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════
     TAB PANE — Tukar Poin
     ═══════════════════════════════════════════════════════ --}}
<div class="pts-tab-pane" id="pane-redeem">

    <div style="font-size:0.72rem; color:var(--text-muted); margin-bottom:14px; display:flex; align-items:center; gap:6px;">
        <i class="fa-solid fa-circle-info" style="color:var(--primary);"></i>
        Saldo kamu: <strong style="color:var(--primary);">1.250 PTS</strong> &nbsp;·&nbsp; Pilih reward di bawah
    </div>

    {{-- Voucher Diskon 10% --}}
    <div class="voucher-list-item reveal-card">
        <img class="voucher-img"
             src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=160&q=80&fit=crop"
             alt="Voucher Diskon">
        <div class="voucher-body">
            <span class="voucher-badge green">Voucher</span>
            <div class="voucher-title">Diskon 10% Marketplace</div>
            <div class="voucher-sub" style="color:#004B38; font-weight:700;">500 PTS · ≈ Rp 50.000</div>
        </div>
        <div class="voucher-right">
            <button class="btn-redeem" onclick="alert('Fitur penukaran poin segera hadir! 🚀')">Tukar</button>
        </div>
    </div>

    {{-- Potongan Rp 50.000 --}}
    <div class="voucher-list-item reveal-card">
        <img class="voucher-img"
             src="https://images.unsplash.com/photo-1607083206869-4c7672e72a8a?w=160&q=80&fit=crop"
             alt="Potongan">
        <div class="voucher-body">
            <span class="voucher-badge blue">Cashback</span>
            <div class="voucher-title">Potongan Rp 50.000</div>
            <div class="voucher-sub" style="color:#004B38; font-weight:700;">750 PTS · ≈ Rp 75.000</div>
        </div>
        <div class="voucher-right">
            <button class="btn-redeem" onclick="alert('Fitur penukaran poin segera hadir! 🚀')">Tukar</button>
        </div>
    </div>

    {{-- Konsultasi Gratis --}}
    <div class="voucher-list-item reveal-card">
        <img class="voucher-img"
             src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=160&q=80&fit=crop"
             alt="Konsultasi">
        <div class="voucher-body">
            <span class="voucher-badge blue">Konsultasi</span>
            <div class="voucher-title">Konsultasi Gratis 1×</div>
            <div class="voucher-sub" style="color:#004B38; font-weight:700;">1.000 PTS · ≈ Rp 100.000</div>
        </div>
        <div class="voucher-right">
            <button class="btn-redeem" onclick="alert('Fitur penukaran poin segera hadir! 🚀')">Tukar</button>
        </div>
    </div>

    {{-- Ongkir Gratis --}}
    <div class="voucher-list-item reveal-card">
        <img class="voucher-img"
             src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=160&q=80&fit=crop"
             alt="Ongkir">
        <div class="voucher-body">
            <span class="voucher-badge green">Pengiriman</span>
            <div class="voucher-title">Voucher Gratis Ongkir</div>
            <div class="voucher-sub" style="color:#004B38; font-weight:700;">300 PTS · ≈ Rp 30.000</div>
        </div>
        <div class="voucher-right">
            <button class="btn-redeem" onclick="alert('Fitur penukaran poin segera hadir! 🚀')">Tukar</button>
        </div>
    </div>

    {{-- Upgrade Premium --}}
    <div class="voucher-list-item reveal-card">
        <img class="voucher-img"
             src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?w=160&q=80&fit=crop"
             alt="Premium">
        <div class="voucher-body">
            <span class="voucher-badge orange">Premium</span>
            <div class="voucher-title">Upgrade Premium 1 Bulan</div>
            <div class="voucher-sub" style="color:#92400e; font-weight:700;">2.000 PTS · ≈ Rp 200.000</div>
        </div>
        <div class="voucher-right">
            <button class="btn-redeem disabled">Kurang</button>
        </div>
    </div>

    {{-- Expired area note --}}
    <div style="text-align:center; padding:18px 0 4px; color:var(--text-muted); font-size:0.7rem;">
        <i class="fa-regular fa-clock" style="margin-right:4px;"></i>
        Riwayat penukaran akan muncul di tab <strong>Riwayat</strong>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const panes  = { riwayat: 'pane-riwayat', earn: 'pane-earn', redeem: 'pane-redeem' };
    const tabEls = { riwayat: 'tab-riwayat',  earn: 'tab-earn',  redeem: 'tab-redeem'  };
    const pill   = document.getElementById('pts-tab-pill');

    function movePill(tabEl) {
        if (!pill || !tabEl) return;
        pill.style.width     = `${tabEl.offsetWidth}px`;
        pill.style.transform = `translateX(${tabEl.offsetLeft - 4}px)`;
    }

    // Global so onclick="" handlers can call it
    window.switchTab = function(name) {
        Object.keys(tabEls).forEach(k => {
            const t = document.getElementById(tabEls[k]);
            const p = document.getElementById(panes[k]);
            if (t) t.classList.remove('active');
            if (p) p.classList.remove('active');
        });

        const activeTab  = document.getElementById(tabEls[name]);
        const activePane = document.getElementById(panes[name]);
        if (activeTab)  activeTab.classList.add('active');
        if (activePane) activePane.classList.add('active');

        movePill(activeTab);

        // Staggered reveal for newly shown cards
        if (activePane) {
            activePane.querySelectorAll('.reveal-card').forEach((card, i) => {
                card.classList.remove('revealed');
                card.style.transitionDelay = `${i * 70}ms`;
                requestAnimationFrame(() =>
                    requestAnimationFrame(() => card.classList.add('revealed'))
                );
            });
        }
    };

    // Init pill position
    movePill(document.getElementById('tab-riwayat'));

    // Scroll reveal for default visible tab (Riwayat)
    const observer = new IntersectionObserver((entries) => {
        let idx = 0;
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.transitionDelay = `${idx * 70}ms`;
                requestAnimationFrame(() => entry.target.classList.add('revealed'));
                idx++;
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -10px 0px' });

    document.querySelectorAll('#pane-riwayat .reveal-card').forEach(c => observer.observe(c));
});
</script>
@endsection
