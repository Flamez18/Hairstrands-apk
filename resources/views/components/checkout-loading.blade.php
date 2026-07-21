<style>
:root {
    --box-main:   #c17f3e;
    --box-dark:   #8a5a2b;
    --box-mid:    #a86f35;
    --box-light:  #d09459;
    --box-right:  #c6894c;
    --box-inside: #5a391a;
    --brand-teal: #22C55E;
}

/* ── Overlay ── */
#checkout-loading-overlay {
    position: fixed;
    inset: 0;
    background-color: var(--primary, #0a3d2b);
    z-index: 9999;
    display: none;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    font-family: 'Outfit', sans-serif;
    opacity: 0;
    transition: opacity 0.4s ease;
    overflow: hidden;
}
#checkout-loading-overlay.active {
    display: flex;
    opacity: 1;
}

/* ── Scene (kamera) ── */
.box-3d-scene {
    width: 200px;
    height: 260px;
    perspective: 900px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 24px;
    position: relative;
    transition: transform 0.9s cubic-bezier(0.4, 0, 0.2, 1);
}
/* Tahap akhir: box slide ke pinggir kanan + rotasi ringan (pakai vw supaya aman di mobile) */
.box-3d-scene.scene-step-slide {
    transform: translateX(85vw) rotateZ(8deg);
}

/* ── Partikel Produk (SVG botol) ── */
.product-particles {
    position: absolute;
    top: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 70px;
    height: 110px;
    z-index: 20;
    perspective: 400px;
}
.particle {
    position: absolute;
    width: 36px;
    height: 88px;
    opacity: 0;
    filter: drop-shadow(0 4px 8px rgba(0,0,0,0.35));
    transition: all 0.75s cubic-bezier(0.34, 1.4, 0.64, 1);
}
.particle.layer-1 { left: 14px; z-index: 3; transform: translateY(-95px) rotateX(40deg) rotateZ(8deg)  scale(0.8); }
.particle.layer-2 { left:  0px; z-index: 2; transform: translateY(-95px) rotateX(40deg) rotateZ(-8deg) scale(0.75); }
.particle.layer-3 { left: 22px; z-index: 1; transform: translateY(-95px) rotateX(40deg) rotateZ(20deg) scale(0.7); }

/* Produk tampil saat kotak terbuka */
.scene-start .particle.layer-1 { opacity: 1; transform: translateY(-55px) rotateX(25deg) rotateZ(6deg)   scale(0.9); }
.scene-start .particle.layer-2 { opacity: 1; transform: translateY(-55px) rotateX(25deg) rotateZ(-10deg) scale(0.85); }
.scene-start .particle.layer-3 { opacity: 1; transform: translateY(-55px) rotateX(25deg) rotateZ(18deg)  scale(0.8); }

/* Produk jatuh masuk kotak */
.scene-step-products .particle.layer-1 { opacity: 0; transform: translateY(55px) scale(0.25); transition-delay: 0.0s; }
.scene-step-products .particle.layer-2 { opacity: 0; transform: translateY(65px) scale(0.25); transition-delay: 0.18s; }
.scene-step-products .particle.layer-3 { opacity: 0; transform: translateY(75px) scale(0.25); transition-delay: 0.36s; }
/* particle layer-3 adalah yang PALING TERAKHIR selesai (delay 0.36s + duration 0.75s = ~1.11s total)
   -> ini elemen yang dipakai JS sebagai patokan "produk sudah masuk semua" */

/* ── Kotak 3D ── */
.box-3d {
    position: relative;
    width: 120px;
    height: 100px;
    transform-style: preserve-3d;
    transform: rotateX(-28deg) rotateY(-38deg) scale(0);
    transition: transform 0.65s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.scene-start .box-3d {
    transform: rotateX(-28deg) rotateY(-38deg) scale(1);
}

/* ── Sisi-sisi Box ── */
.face {
    position: absolute;
    transform-style: preserve-3d;
}
.face-bottom {
    width: 120px; height: 120px;
    background: var(--box-inside);
    transform: rotateX(90deg) translateZ(-50px);
    box-shadow: 0 0 30px rgba(0,0,0,0.7) inset;
}
.face-front {
    width: 120px; height: 100px;
    background: var(--box-main);
    transform: translateZ(60px);
}
.face-back {
    width: 120px; height: 100px;
    background: var(--box-dark);
    transform: rotateY(180deg) translateZ(60px);
}
.face-left {
    width: 120px; height: 100px;
    background: var(--box-mid);
    transform: rotateY(-90deg) translateZ(60px);
}
.face-right {
    width: 120px; height: 100px;
    background: var(--box-right);
    transform: rotateY(90deg) translateZ(60px);
}
.face-front::after {
    content: 'PureStrands';
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    color: #4a2e16;
    font-weight: 800;
    font-size: 0.85rem;
    opacity: 0.35;
    letter-spacing: 0.5px;
    pointer-events: none;
}

/* ── Flap (tutup kardus) ── */
.flap {
    position: absolute;
    transform-origin: bottom center;
    /* Durasi diperlambat sesuai request: proses menutup terasa lebih "berproses" */
    transition: transform 0.55s cubic-bezier(0.42, 0, 0.15, 1);
    border: 1px solid rgba(0,0,0,0.18);
    backface-visibility: hidden;
    z-index: 1;
}
.flap-front, .flap-back, .flap-left, .flap-right {
    width: 120px;
    height: 60px;
    top: -60px;
    left: 0;
    /* Terbuka: flap terlipat KELUAR/jatuh ke belakang menjauhi box (arah negatif) */
    transform: rotateX(-150deg);
}
.flap-front { background: var(--box-light); }
.flap-back  { background: var(--box-dark);  }
.flap-left  { background: var(--box-mid);   }
.flap-right { background: var(--box-right); }

/*
  === FIX UTAMA ===
  Tertutup HARUS pakai arah BERLAWANAN (positif), bukan meneruskan arah buka (negatif).
  rotateX(0deg)   = flap berdiri tegak (posisi netral/dinding box)
  rotateX(-150deg)= flap jatuh KELUAR (posisi terbuka, seperti referensi awal)
  rotateX(90deg)  = flap terlipat ke DALAM menutup lubang atas (posisi tertutup rapat)
  Sebelumnya kode lama pakai rotateX(-90deg) -> salah arah, makanya flap
  "berhenti setengah jalan" dan box kelihatan masih menganga di screenshot.
*/
.scene-step-close-left  .flap-left  { transform: rotateX(90deg); }
.scene-step-close-right .flap-right { transform: rotateX(90deg); }
.scene-step-close-back  .flap-back  { transform: rotateX(90deg); z-index: 3; }
.scene-step-close-front .flap-front { transform: rotateX(90deg); z-index: 5; }

/* ── Tali Pengikat (BARU) — hanya muncul setelah semua flap benar-benar tertutup ── */
.tali-wrap {
    position: absolute;
    top: -60px; left: 0;
    width: 120px; height: 100px;
    transform: translateZ(61.5px); /* sedikit di depan face-front, hindari z-fighting */
    pointer-events: none;
    z-index: 10;
}
.tali-wrap svg {
    width: 100%; height: 100%;
    overflow: visible;
}
.tali-line {
    fill: none;
    stroke: var(--brand-teal);
    stroke-width: 4;
    stroke-linecap: round;
    stroke-dasharray: 220;
    stroke-dashoffset: 220; /* garis "belum digambar" */
    transition: stroke-dashoffset 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
/* Tali horizontal dulu, tali vertikal menyusul (delay), sesuai request "berurutan" */
.tali-line.tali-h { transition-delay: 0s; }
.tali-line.tali-v { transition-delay: 0.35s; }

.tali-knot {
    fill: var(--brand-teal);
    opacity: 0;
    transform: scale(0);
    transform-origin: center;
    transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    transition-delay: 0.65s; /* simpul muncul setelah kedua tali selesai ditarik */
}

.scene-step-tie .tali-line { stroke-dashoffset: 0; }
.scene-step-tie .tali-knot { opacity: 1; transform: scale(1); }

/* Box bounce kecil begitu tali selesai mengikat, sebelum slide keluar */
@keyframes box-bounce {
    0%   { transform: rotateX(-28deg) rotateY(-38deg) scale(1) translateY(0); }
    35%  { transform: rotateX(-28deg) rotateY(-38deg) scale(1) translateY(-8px); }
    65%  { transform: rotateX(-28deg) rotateY(-38deg) scale(1) translateY(2px); }
    100% { transform: rotateX(-28deg) rotateY(-38deg) scale(1) translateY(0); }
}
.scene-step-bounce .box-3d {
    animation: box-bounce 0.5s ease-out;
}

/* Idle animation kecil kalau API belum selesai saat box sudah di posisi akhir kanan */
@keyframes idle-float {
    0%, 100% { transform: translateY(0); }
    50%      { transform: translateY(-5px); }
}
.scene-step-slide.scene-idle .box-3d {
    animation: idle-float 1.4s ease-in-out infinite;
}

/* ── Teks Status & Progress Bar ── */
.checkout-status-text {
    font-size: 1.05rem;
    font-weight: 700;
    margin-bottom: 14px;
    text-align: center;
    letter-spacing: 0.3px;
}
.progress-bar-container {
    width: 180px;
    height: 3px;
    background-color: rgba(255,255,255,0.2);
    border-radius: 4px;
    overflow: hidden;
}
.progress-bar-fill {
    height: 100%;
    width: 0%;
    background-color: var(--brand-teal);
    transition: width 0.4s ease;
}

@media (max-width: 480px) {
    .box-3d-scene.scene-step-slide {
        transform: translateX(78vw) rotateZ(8deg);
    }
}
</style>

<div id="checkout-loading-overlay">
    <div class="box-3d-scene" id="loading-3d-scene">

        {{-- Tiga botol SVG produk --}}
        <div class="product-particles">
            <svg class="particle layer-3" viewBox="0 0 40 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="5"  y="26" width="30" height="69" rx="6" fill="#f8fafc"/>
                <rect x="10" y="50" width="20" height="25" rx="2" fill="#e2e8f0"/>
                <path d="M12 26 L12 10 C12 5 28 5 28 10 L28 26 Z" fill="#22C55E"/>
            </svg>
            <svg class="particle layer-2" viewBox="0 0 40 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="5"  y="26" width="30" height="69" rx="6" fill="#f8fafc"/>
                <rect x="10" y="50" width="20" height="25" rx="2" fill="#e2e8f0"/>
                <path d="M12 26 L12 10 C12 5 28 5 28 10 L28 26 Z" fill="#22C55E"/>
            </svg>
            <svg class="particle layer-1" viewBox="0 0 40 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="5"  y="26" width="30" height="69" rx="6" fill="#f8fafc"/>
                <rect x="10" y="50" width="20" height="25" rx="2" fill="#e2e8f0"/>
                <path d="M12 26 L12 10 C12 5 28 5 28 10 L28 26 Z" fill="#22C55E"/>
            </svg>
        </div>

        {{-- Kardus 3D --}}
        <div class="box-3d">
            <div class="face face-bottom"></div>
            <div class="face face-back">
                <div class="flap flap-back"></div>
            </div>
            <div class="face face-left">
                <div class="flap flap-left"></div>
            </div>
            <div class="face face-right">
                <div class="flap flap-right"></div>
            </div>
            <div class="face face-front">
                <div class="flap flap-front"></div>
            </div>

            {{-- Tali pengikat: child .box-3d supaya ikut transform 3D box --}}
            <div class="tali-wrap">
                <svg viewBox="0 0 120 100">
                    <line class="tali-line tali-h" x1="0" y1="50" x2="120" y2="50" />
                    <line class="tali-line tali-v" x1="60" y1="0" x2="60" y2="100" />
                    <circle class="tali-knot" cx="60" cy="50" r="6" />
                </svg>
            </div>
        </div>

    </div>

    <div class="checkout-status-text" id="loading-status-text">Menyiapkan kotak...</div>

    <div class="progress-bar-container">
        <div class="progress-bar-fill" id="loading-progress-fill"></div>
    </div>
</div>

<script>
(function () {
    const overlay      = document.getElementById('checkout-loading-overlay');
    const scene        = document.getElementById('loading-3d-scene');
    const statusText   = document.getElementById('loading-status-text');
    const progressFill = document.getElementById('loading-progress-fill');

    /**
     * Menunggu transitionend pada elemen tertentu untuk properti tertentu.
     * INI KUNCI FIX BUG: kita TIDAK PERNAH pakai setTimeout dengan angka
     * hardcoded untuk pindah tahap. Setiap tahap menunggu tahap sebelumnya
     * benar-benar selesai secara visual (event asli dari browser),
     * jadi tali tidak akan pernah muncul sebelum box benar-benar tertutup,
     * apapun durasi CSS yang dipakai/diubah nanti.
     */
    function waitTransitionEnd(el, propName, timeoutMs) {
        return new Promise((resolve) => {
            let done = false;
            const fallback = setTimeout(() => {
                if (!done) { done = true; resolve(); }
            }, timeoutMs); // safety net kalau event tidak fire (misal el di-display:none)

            function handler(e) {
                if (propName && e.propertyName !== propName) return;
                if (done) return;
                done = true;
                clearTimeout(fallback);
                el.removeEventListener('transitionend', handler);
                resolve();
            }
            el.addEventListener('transitionend', handler);
        });
    }

    function wait(ms) {
        return new Promise((resolve) => setTimeout(resolve, ms));
    }

    function setStatus(text, progressPercent) {
        statusText.textContent = text;
        progressFill.style.width = progressPercent + '%';
    }

    /**
     * Menjalankan seluruh sequence animasi loading screen.
     * apiPromise: Promise yang resolve dengan { status, redirect } dari fetch checkout.
     */
    async function runCheckoutLoadingSequence(apiPromise) {
        overlay.classList.add('active');
        scene.className = 'box-3d-scene'; // reset state kalau dipanggil ulang

        // ── Tahap 0: Kotak muncul + terbuka ──
        setStatus('Menyiapkan kotak...', 10);
        scene.classList.add('scene-start');
        await wait(650); // durasi scale-in box (.box-3d transition 0.65s)

        // ── Tahap 1: Produk masuk ke kotak ──
        setStatus('Menyiapkan pesananmu...', 30);
        scene.classList.add('scene-step-products');
        const lastParticle = scene.querySelector('.particle.layer-3');
        await waitTransitionEnd(lastParticle, 'transform', 1300);

        // ── Tahap 2: Kotak menutup BERTAHAP, satu-satu, menunggu tiap flap selesai ──
        setStatus('Mengemas paket...', 50);

        scene.classList.add('scene-step-close-left');
        await waitTransitionEnd(scene.querySelector('.flap-left'), 'transform', 700);

        scene.classList.add('scene-step-close-right');
        await waitTransitionEnd(scene.querySelector('.flap-right'), 'transform', 700);

        scene.classList.add('scene-step-close-back');
        await waitTransitionEnd(scene.querySelector('.flap-back'), 'transform', 700);

        scene.classList.add('scene-step-close-front');
        // flap-front adalah penutup TERAKHIR — baru setelah ini box dianggap tertutup penuh
        await waitTransitionEnd(scene.querySelector('.flap-front'), 'transform', 700);

        // ── Tahap 3: Tali pengikat (baru mulai SETELAH box benar-benar tertutup) ──
        setStatus('Mengikat paket...', 75);
        scene.classList.add('scene-step-tie');
        const knot = scene.querySelector('.tali-knot');
        await waitTransitionEnd(knot, 'transform', 1200); // tunggu simpul selesai muncul (delay 0.65s + 0.25s)

        // ── Tahap 4: Bounce kecil menandakan selesai dikemas ──
        scene.classList.add('scene-step-bounce');
        await wait(500);

        // ── Tahap 5: Box slide ke pinggir kanan ──
        setStatus('Paket siap dikirim!', 100);
        scene.classList.add('scene-step-slide');
        await waitTransitionEnd(scene, 'transform', 1000);

        // ── Tahap 6: Sinkronisasi dengan API ──
        // Kalau API checkout belum selesai, box idle (floating halus) di posisi kanan
        // sambil menunggu, TIDAK redirect duluan sebelum response datang.
        scene.classList.add('scene-idle');

        const apiResult = await apiPromise;

        // ── Tahap akhir: fade out & redirect ──
        overlay.style.opacity = '0';
        await wait(400);
        overlay.classList.remove('active');

        if (apiResult && apiResult.status === 'success' && apiResult.redirect) {
            window.location.href = apiResult.redirect;
        } else {
            // Kalau gagal, sembunyikan overlay dan biarkan halaman checkout
            // menampilkan pesan error (ditangani di luar fungsi ini).
            console.error('Checkout gagal:', apiResult);
        }

        return apiResult;
    }

    // Expose ke global scope supaya bisa dipanggil dari checkout/index.blade.php
    window.startCheckoutLoadingAnimation = runCheckoutLoadingSequence;
})();
</script>