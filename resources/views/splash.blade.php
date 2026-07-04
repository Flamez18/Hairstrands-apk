<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>PureStrand AI</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<style>
/* ═══════════════════════════════════════════
   SPLASH CONTAINER (Fills mobile-wrapper)
═══════════════════════════════════════════ */
.splash {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
    background: #0F3D2E;
    z-index: 9999;
    flex-shrink: 0;
}

.scene {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
}

/* ═══════════════════════════════════════════
   SCENE 1 — Walking Street (0s – 4.8s)
═══════════════════════════════════════════ */
#scene1 {
    opacity: 1;
    animation: s1-out 1s ease-in-out 4.7s forwards;
}
@keyframes s1-out {
    0%   { opacity: 1; transform: scale(1); }
    100% { opacity: 0; transform: scale(1.05); }
}

/* Sky */
.sky {
    position: absolute; inset: 0;
    background: linear-gradient(180deg,
        #0A2C1F 0%, #0F3D2E 20%, #156038 50%, #22C55E 83%, #4ADE80 100%);
}

/* Ambient dots */
.sky-dot {
    position: absolute; border-radius: 50%;
    background: rgba(255,255,255,0.2);
    animation: sky-bob ease-in-out infinite alternate;
}
@keyframes sky-bob {
    from { transform: translateY(0); opacity: 0.2; }
    to   { transform: translateY(-8px); opacity: 0.4; }
}

/* Clouds */
.cloud { position: absolute; opacity: 0.1; animation: cloud-move linear infinite; }
@keyframes cloud-move { from { transform: translateX(0); } to { transform: translateX(30px); } }

/* Background parallax (40% speed) */
.bg-layer {
    position: absolute; bottom: 145px; left: 0; width: 3500px;
    animation: bg-pan 4.5s linear 0.2s forwards;
}
@keyframes bg-pan { from { transform: translateX(0); } to { transform: translateX(-680px); } }

/* Main world (full speed) */
.world {
    position: absolute; bottom: 0; left: 0;
    width: 2600px; height: 780px;
    animation: world-pan 4.5s linear 0.2s forwards;
}
@keyframes world-pan { from { transform: translateX(0); } to { transform: translateX(-1720px); } }

.ground {
    position: absolute; bottom: 0; left: 0; right: 0; height: 145px;
    background: linear-gradient(to bottom, #0c2e1a 0%, #07150d 100%);
}
.sidewalk {
    position: absolute; bottom: 100px; left: 0; right: 0; height: 46px;
    background: #163b24; border-top: 2px solid rgba(255,255,255,0.06);
}
.sidewalk::after {
    content: ''; position: absolute; inset: 0;
    background: repeating-linear-gradient(90deg, transparent 0, transparent 88px, rgba(0,0,0,0.18) 88px, rgba(0,0,0,0.18) 90px);
}
.road {
    position: absolute; bottom: 0; left: 0; right: 0; height: 100px;
    background: #0a1e12;
}
.road::after {
    content: ''; position: absolute; top: 46px; left: 0; right: 0; height: 5px;
    background: repeating-linear-gradient(90deg, rgba(255,255,255,0.15) 0, rgba(255,255,255,0.15) 45px, transparent 45px, transparent 90px);
}

/* ── CHARACTER ── */
.character { position: absolute; bottom: 144px; left: 165px; z-index: 30; }
.char-svg { animation: c-bob 0.28s ease-in-out infinite alternate; }
@keyframes c-bob { from { transform: translateY(0); } to { transform: translateY(-4px); } }
.leg-l { transform-box: fill-box; transform-origin: top center; animation: ll 0.56s ease-in-out infinite; }
.leg-r { transform-box: fill-box; transform-origin: top center; animation: lr 0.56s ease-in-out infinite; }
@keyframes ll { 0%,100% { transform: rotate(-32deg); } 50% { transform: rotate(32deg); } }
@keyframes lr { 0%,100% { transform: rotate(32deg); } 50% { transform: rotate(-32deg); } }
.arm-l { transform-box: fill-box; transform-origin: top center; animation: al 0.56s ease-in-out infinite; }
.arm-r { transform-box: fill-box; transform-origin: top center; animation: ar 0.56s ease-in-out infinite; }
@keyframes al { 0%,100% { transform: rotate(24deg); } 50% { transform: rotate(-24deg); } }
@keyframes ar { 0%,100% { transform: rotate(-24deg); } 50% { transform: rotate(24deg); } }

/* ── SPEED LINES ── */
.speed-lines {
    position: absolute; inset: 0; pointer-events: none; z-index: 25; overflow: hidden;
    animation: speed-lines-life 4.5s ease-in-out 0.2s forwards;
}
@keyframes speed-lines-life {
    0% { opacity: 0; } 10% { opacity: 1; } 85% { opacity: 0.6; } 100% { opacity: 0; }
}
.speed-line {
    position: absolute; left: 0; right: 0; height: 1.5px;
    background: linear-gradient(to right, transparent 0%, rgba(255,255,255,0.14) 35%, rgba(255,255,255,0.08) 70%, transparent 100%);
    animation: streak linear infinite;
}
@keyframes streak { from { transform: translateX(0); } to { transform: translateX(-60px); } }

/* ── LOCATION CHIP ── */
.loc-chip {
    position: absolute; top: 62%; left: 50%;
    transform: translateX(-50%) translateY(8px);
    background: rgba(6,30,18,0.75); backdrop-filter: blur(10px);
    color: #4ADE80; border: 1.5px solid rgba(74,222,128,0.35);
    border-radius: 50px; padding: 6px 20px;
    font-size: 0.74rem; font-weight: 800; font-family: 'Outfit', sans-serif;
    letter-spacing: 0.5px; white-space: nowrap; pointer-events: none; opacity: 0;
}
.loc-chip.salon  { animation: chip-in 0.5s ease 0.8s forwards, chip-out 0.4s ease 1.8s forwards; }
.loc-chip.barber { animation: chip-in 0.5s ease 2.1s forwards, chip-out 0.4s ease 3.1s forwards; }
.loc-chip.klinik { animation: chip-in 0.5s ease 3.4s forwards, chip-out 0.4s ease 4.4s forwards; }
@keyframes chip-in  { from { opacity:0; transform:translateX(-50%) translateY(12px); } to { opacity:1; transform:translateX(-50%) translateY(0); } }
@keyframes chip-out { from { opacity:1; } to { opacity:0; } }

/* ── PROGRESS INDICATOR ── */
.loc-progress {
    position: absolute; bottom: 48px; left: 50%; transform: translateX(-50%);
    display: flex; align-items: center; gap: 0; z-index: 40;
    opacity: 0; animation: lp-appear 0.4s ease 0.5s forwards;
}
@keyframes lp-appear { from { opacity:0; } to { opacity:1; } }
.lp-step { display: flex; flex-direction: column; align-items: center; gap: 6px; }
.lp-dot {
    width: 10px; height: 10px; border-radius: 50%;
    background: rgba(255,255,255,0.2); border: 1.5px solid rgba(255,255,255,0.3);
    transition: background 0.3s ease, transform 0.3s ease;
}
.lp-dot.active {
    background: #4ADE80; border-color: #4ADE80;
    transform: scale(1.35); box-shadow: 0 0 8px rgba(74,222,128,0.6);
}
.lp-dot.done { background: rgba(74,222,128,0.5); border-color: rgba(74,222,128,0.5); }
.lp-line {
    width: 48px; height: 1.5px; background: rgba(255,255,255,0.15);
    position: relative; overflow: hidden;
}
.lp-line-fill {
    position: absolute; left: 0; top: 0; bottom: 0; width: 0%;
    background: #4ADE80; transition: width 1.5s linear;
}
.lp-label { font-size: 0.6rem; font-family:'Outfit',sans-serif; font-weight:600; letter-spacing:0.5px; color:rgba(255,255,255,0.45); white-space:nowrap; }

/* ── CAMERA SHAKE ── */
#scene1.shake { animation: s1-out 1s ease-in-out 4.7s forwards, cam-shake 0.4s ease-in-out 4.55s; }
@keyframes cam-shake {
    0%  { transform: translateX(0); }
    20% { transform: translateX(-5px) translateY(2px); }
    40% { transform: translateX(5px) translateY(-2px); }
    60% { transform: translateX(-3px) translateY(1px); }
    80% { transform: translateX(3px) translateY(-1px); }
    100%{ transform: translateX(0); }
}

/* ── GHOST CHARACTER ── */
.char-ghost {
    position: absolute; bottom: 144px; left: 130px; z-index: 15; pointer-events: none; opacity: 0;
    animation: ghost-breathe 0.56s ease-in-out infinite alternate, ghost-appear 4.5s ease 0.2s forwards;
}
@keyframes ghost-appear { 0%{opacity:0;} 5%{opacity:0.09;} 90%{opacity:0.09;} 100%{opacity:0;} }
@keyframes ghost-breathe { from{transform:translateY(0) scaleX(1.05);} to{transform:translateY(-4px) scaleX(1.05);} }

/* ═══════════════════════════════════════════
   SCENE 2 — Flash
═══════════════════════════════════════════ */
#scene2 {
    pointer-events: none; opacity: 0;
    background: radial-gradient(circle at 50% 50%, #4ADE80 0%, #22C55E 30%, #0F3D2E 100%);
    animation: s2-flash 1.2s ease-in-out 4.6s forwards;
}
@keyframes s2-flash {
    0%  { opacity:0; transform:scale(0.8); }
    40% { opacity:0.9; transform:scale(1); }
    100%{ opacity:0; transform:scale(1); }
}

/* ═══════════════════════════════════════════
   SCENE 3 — Logo Reveal
═══════════════════════════════════════════ */
#scene3 {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    background: linear-gradient(175deg, #091C12 0%, #0F3D2E 35%, #1a6640 70%, #22C55E 100%);
    opacity: 0;
    animation: s3-in 0.8s ease-out 5.2s forwards;
}
@keyframes s3-in { from{opacity:0;} to{opacity:1;} }

.s3-blob { position: absolute; border-radius: 50%; pointer-events: none; }
.s3-helix { position: absolute; opacity: 0.06; }

/* Welcome message */
.welcome-msg {
    position: absolute; top: 88px; left: 0; right: 0;
    text-align: center;
    opacity: 0;
    animation: wm-in 0.6s ease 5.6s forwards;
}
@keyframes wm-in { from{opacity:0; transform:translateY(-8px);} to{opacity:1; transform:translateY(0);} }
.welcome-msg .hi { font-family:'Outfit',sans-serif; font-size:0.75rem; font-weight:600; color:rgba(255,255,255,0.55); letter-spacing:1px; text-transform:uppercase; display:block; margin-bottom:4px; }
.welcome-msg .name { font-family:'Outfit',sans-serif; font-size:1.1rem; font-weight:800; color:white; }

/* Logo card */
.logo-card {
    background: white; border-radius: 30px; padding: 34px 44px 28px;
    box-shadow: 0 28px 80px rgba(0,0,0,0.4), 0 0 60px rgba(74,222,128,0.15);
    opacity: 0; transform: scale(0.8) translateY(30px);
    animation: card-in 1s cubic-bezier(0.175, 0.885, 0.32, 1.4) 5.4s forwards;
}
@keyframes card-in {
    from{ opacity:0; transform:scale(0.8) translateY(30px); }
    to  { opacity:1; transform:scale(1) translateY(0); }
}

/* Loading dots */
.loading-dots { display:flex; gap:11px; margin-top:46px; opacity:0; animation:dots-in 0.4s ease 6.5s forwards; }
@keyframes dots-in { from{opacity:0;} to{opacity:1;} }
.ld { width:11px; height:11px; border-radius:50%; background:#4ADE80; animation:ld-p 1.1s ease-in-out infinite; }
.ld:nth-child(1){animation-delay:6.5s;}
.ld:nth-child(2){animation-delay:6.7s;}
.ld:nth-child(3){animation-delay:6.9s;}
@keyframes ld-p { 0%,100%{transform:scale(0.65);opacity:0.35;} 50%{transform:scale(1.35);opacity:1;} }

.tagline {
    position:absolute; bottom:75px; text-align:center; width:100%;
    font-family:'Outfit',sans-serif; font-size:11.5px; letter-spacing:2px;
    text-transform:uppercase; color:rgba(255,255,255,0.4);
    opacity:0; animation:tl-in 0.6s ease 7s forwards;
}
@keyframes tl-in { from{opacity:0;transform:translateY(6px);} to{opacity:1;transform:translateY(0);} }

/* ── Skip button ── */
.skip-btn {
    position: absolute; top: 24px; right: 20px; z-index: 100;
    background: rgba(0,0,0,0.25); backdrop-filter: blur(8px);
    color: rgba(255,255,255,0.6); border: 1px solid rgba(255,255,255,0.15);
    border-radius: 50px; padding: 5px 14px;
    font-size: 0.7rem; font-weight: 600; font-family: 'Outfit', sans-serif;
    cursor: pointer; opacity: 0;
    animation: skip-appear 0.5s ease 1s forwards;
    transition: background 0.2s, color 0.2s;
}
.skip-btn:hover { background: rgba(74,222,128,0.25); color: #4ADE80; border-color: rgba(74,222,128,0.4); }
@keyframes skip-appear { from{opacity:0;} to{opacity:1;} }
</style>
</head>
<body>
<div class="mobile-wrapper">
<div class="splash">

<!-- ══════════ SCENE 1 — Walking ══════════ -->
<div class="scene" id="scene1">
  <div class="sky"></div>

  <!-- Sky dots -->
  <div class="sky-dot" style="width:5px;height:5px; top:8%;left:18%; animation-duration:3.2s;"></div>
  <div class="sky-dot" style="width:7px;height:7px; top:13%;right:22%;animation-duration:4s;animation-delay:0.5s;"></div>
  <div class="sky-dot" style="width:4px;height:4px; top:20%;left:65%; animation-duration:3.8s;animation-delay:1s;"></div>
  <div class="sky-dot" style="width:9px;height:9px; top:6%;right:38%; animation-duration:4.2s;animation-delay:0.8s;background:rgba(74,222,128,0.25);"></div>

  <!-- Clouds -->
  <svg class="cloud" style="top:5%;left:-10%;animation-duration:18s;" width="200" height="55" viewBox="0 0 200 55">
    <ellipse cx="100" cy="35" rx="90" ry="18" fill="white"/>
    <ellipse cx="75"  cy="30" rx="50" ry="15" fill="white"/>
    <ellipse cx="135" cy="28" rx="55" ry="13" fill="white"/>
  </svg>
  <svg class="cloud" style="top:12%;right:-5%;animation-duration:22s;animation-delay:3s;" width="160" height="45" viewBox="0 0 160 45">
    <ellipse cx="80"  cy="28" rx="72" ry="16" fill="white"/>
    <ellipse cx="55"  cy="24" rx="38" ry="12" fill="white"/>
    <ellipse cx="112" cy="22" rx="42" ry="11" fill="white"/>
  </svg>

  <!-- DNA deco -->
  <svg style="position:absolute;top:5%;left:4%;opacity:0.1;width:48px;" viewBox="0 0 48 140">
    <path d="M6,0 Q42,35 6,70 Q42,105 6,140" stroke="white" stroke-width="1.5" fill="none"/>
    <path d="M42,0 Q6,35 42,70 Q6,105 42,140" stroke="white" stroke-width="1.5" fill="none"/>
    <line x1="6" y1="20"  x2="42" y2="22"  stroke="white" stroke-width="0.8" opacity="0.6"/>
    <line x1="6" y1="50"  x2="42" y2="50"  stroke="white" stroke-width="0.8" opacity="0.6"/>
    <line x1="6" y1="80"  x2="42" y2="80"  stroke="white" stroke-width="0.8" opacity="0.6"/>
    <line x1="6" y1="110" x2="42" y2="108" stroke="white" stroke-width="0.8" opacity="0.6"/>
  </svg>

  <!-- BG layer -->
  <div class="bg-layer">
    <svg width="3500" height="190" viewBox="0 0 3500 190">
      <g opacity="0.3">
        <rect x="0"  y="100" width="22" height="90" fill="#0a2e1c" rx="2"/>
        <rect x="28" y="70"  width="18" height="120" fill="#0b3320" rx="2"/>
        <rect x="52" y="85"  width="26" height="105" fill="#0a2e1c" rx="2"/>
        <rect x="84" y="50"  width="22" height="140" fill="#0d3a24" rx="2"/>
        <rect x="112" y="72" width="16" height="118" fill="#0a2e1c" rx="2"/>
        <rect x="134" y="38" width="24" height="152" fill="#0b3320" rx="2"/>
        <rect x="165" y="78" width="20" height="112" fill="#0d3a24" rx="2"/>
        <rect x="192" y="55" width="32" height="135" fill="#0a2e1c" rx="2"/>
        <rect x="232" y="42" width="18" height="148" fill="#0b3320" rx="2"/>
        <rect x="87" y="60" width="7" height="4" fill="rgba(74,222,128,0.15)" rx="1"/>
        <rect x="138" y="50" width="5" height="4" fill="rgba(74,222,128,0.12)" rx="1"/>
      </g>
      <g opacity="0.3" transform="translate(400,0)"><rect x="0" y="100" width="22" height="90" fill="#0a2e1c" rx="2"/><rect x="28" y="70" width="18" height="120" fill="#0b3320" rx="2"/><rect x="52" y="85" width="26" height="105" fill="#0a2e1c" rx="2"/><rect x="84" y="50" width="22" height="140" fill="#0d3a24" rx="2"/><rect x="112" y="72" width="16" height="118" fill="#0a2e1c" rx="2"/><rect x="134" y="38" width="24" height="152" fill="#0b3320" rx="2"/></g>
      <g opacity="0.3" transform="translate(800,0)"><rect x="0" y="100" width="22" height="90" fill="#0a2e1c" rx="2"/><rect x="28" y="70" width="18" height="120" fill="#0b3320" rx="2"/><rect x="52" y="85" width="26" height="105" fill="#0a2e1c" rx="2"/><rect x="84" y="50" width="22" height="140" fill="#0d3a24" rx="2"/></g>
      <g opacity="0.3" transform="translate(1200,0)"><rect x="0" y="100" width="22" height="90" fill="#0a2e1c" rx="2"/><rect x="28" y="70" width="18" height="120" fill="#0b3320" rx="2"/><rect x="52" y="85" width="26" height="105" fill="#0a2e1c" rx="2"/></g>
      <g opacity="0.3" transform="translate(1600,0)"><rect x="0" y="100" width="22" height="90" fill="#0a2e1c" rx="2"/><rect x="28" y="70" width="18" height="120" fill="#0b3320" rx="2"/></g>
    </svg>
  </div>

  <!-- ════ WORLD ════ -->
  <div class="world">
    <div class="ground"></div>
    <div class="sidewalk"></div>
    <div class="road"></div>

    <!-- Lampposts -->
    <svg style="position:absolute;bottom:142px;left:270px;" width="20" height="170" viewBox="0 0 20 170"><rect x="8" y="20" width="4" height="150" fill="#0a2e1c" rx="2"/><path d="M12,28 Q42,28 42,55" stroke="#0a2e1c" stroke-width="3.5" fill="none"/><ellipse cx="42" cy="58" rx="9" ry="6" fill="rgba(74,222,128,0.5)"/><ellipse cx="42" cy="58" rx="5" ry="3" fill="#4ADE80"/></svg>
    <svg style="position:absolute;bottom:142px;left:808px;" width="20" height="170" viewBox="0 0 20 170"><rect x="8" y="20" width="4" height="150" fill="#0a2e1c" rx="2"/><path d="M12,28 Q42,28 42,55" stroke="#0a2e1c" stroke-width="3.5" fill="none"/><ellipse cx="42" cy="58" rx="9" ry="6" fill="rgba(74,222,128,0.5)"/><ellipse cx="42" cy="58" rx="5" ry="3" fill="#4ADE80"/></svg>
    <svg style="position:absolute;bottom:142px;left:1310px;" width="20" height="170" viewBox="0 0 20 170"><rect x="8" y="20" width="4" height="150" fill="#0a2e1c" rx="2"/><path d="M12,28 Q42,28 42,55" stroke="#0a2e1c" stroke-width="3.5" fill="none"/><ellipse cx="42" cy="58" rx="9" ry="6" fill="rgba(74,222,128,0.5)"/><ellipse cx="42" cy="58" rx="5" ry="3" fill="#4ADE80"/></svg>

    <!-- SALON -->
    <svg style="position:absolute;bottom:142px;left:360px;" width="360" height="330" viewBox="0 0 360 330">
      <rect x="0" y="44" width="360" height="286" fill="#0c3828" rx="4"/>
      <rect x="8" y="52" width="344" height="270" fill="#0e4230" rx="3"/>
      <rect x="0" y="34" width="360" height="16" fill="#083020" rx="3"/>
      <rect x="14" y="22" width="28" height="18" fill="#083020" rx="2"/><rect x="58" y="18" width="28" height="22" fill="#093526" rx="2"/><rect x="106" y="24" width="28" height="16" fill="#083020" rx="2"/><rect x="158" y="18" width="28" height="22" fill="#093526" rx="2"/><rect x="210" y="24" width="28" height="16" fill="#083020" rx="2"/><rect x="260" y="18" width="28" height="22" fill="#093526" rx="2"/><rect x="314" y="22" width="28" height="18" fill="#083020" rx="2"/>
      <rect x="14" y="56" width="332" height="48" fill="#072e1e" rx="6"/>
      <rect x="16" y="58" width="328" height="44" fill="#083424" rx="5"/>
      <text x="30" y="87" fill="#4ADE80" font-size="22" font-family="sans-serif">✂</text>
      <text x="192" y="82" text-anchor="middle" fill="white" font-family="'Outfit',sans-serif" font-weight="900" font-size="17" letter-spacing="3">PURE SALON</text>
      <text x="192" y="95" text-anchor="middle" fill="rgba(74,222,128,0.55)" font-family="sans-serif" font-size="8.5" letter-spacing="2">RAMBUT &amp; PERAWATAN</text>
      <path d="M0,104 L360,104 L336,126 L24,126 Z" fill="#0a3820"/>
      <line x1="50" y1="104" x2="38" y2="126" stroke="rgba(74,222,128,0.45)" stroke-width="7"/>
      <line x1="94" y1="104" x2="82" y2="126" stroke="rgba(74,222,128,0.45)" stroke-width="7"/>
      <line x1="138" y1="104" x2="126" y2="126" stroke="rgba(74,222,128,0.45)" stroke-width="7"/>
      <line x1="182" y1="104" x2="170" y2="126" stroke="rgba(74,222,128,0.45)" stroke-width="7"/>
      <line x1="226" y1="104" x2="214" y2="126" stroke="rgba(74,222,128,0.45)" stroke-width="7"/>
      <line x1="270" y1="104" x2="258" y2="126" stroke="rgba(74,222,128,0.45)" stroke-width="7"/>
      <line x1="314" y1="104" x2="302" y2="126" stroke="rgba(74,222,128,0.45)" stroke-width="7"/>
      <rect x="14" y="130" width="210" height="158" fill="rgba(74,222,128,0.05)" stroke="rgba(255,255,255,0.14)" stroke-width="1.5" rx="5"/>
      <rect x="78" y="168" width="32" height="46" rx="5" fill="rgba(0,0,0,0.32)"/>
      <ellipse cx="94" cy="162" rx="18" ry="16" fill="rgba(0,0,0,0.28)"/>
      <rect x="68" y="212" width="52" height="8" rx="3" fill="rgba(0,0,0,0.3)"/>
      <text x="28" y="172" fill="rgba(74,222,128,0.3)" font-size="18">✂</text>
      <rect x="238" y="130" width="108" height="158" fill="rgba(255,255,255,0.03)" stroke="rgba(255,255,255,0.1)" stroke-width="1.5" rx="5"/>
      <text x="292" y="182" text-anchor="middle" fill="rgba(74,222,128,0.3)" font-size="11">HAIR</text>
      <text x="292" y="198" text-anchor="middle" fill="rgba(74,222,128,0.3)" font-size="11">STYLING</text>
      <rect x="140" y="228" width="64" height="102" fill="rgba(74,222,128,0.06)" stroke="rgba(255,255,255,0.18)" stroke-width="1.5" rx="4"/>
      <line x1="172" y1="230" x2="172" y2="328" stroke="rgba(255,255,255,0.1)" stroke-width="1"/>
      <rect x="152" y="258" width="16" height="4" fill="rgba(74,222,128,0.6)" rx="2"/>
      <rect x="176" y="258" width="16" height="4" fill="rgba(74,222,128,0.6)" rx="2"/>
      <rect x="126" y="328" width="108" height="7" fill="#071c10" rx="2"/>
      <rect x="118" y="298" width="14" height="32" fill="#063a1e" rx="3"/><ellipse cx="125" cy="296" rx="18" ry="13" fill="#1e8c46"/><ellipse cx="125" cy="292" rx="12" ry="9" fill="#22C55E"/>
      <rect x="228" y="298" width="14" height="32" fill="#063a1e" rx="3"/><ellipse cx="235" cy="296" rx="18" ry="13" fill="#1e8c46"/><ellipse cx="235" cy="292" rx="12" ry="9" fill="#22C55E"/>
    </svg>

    <!-- BARBERSHOP -->
    <svg style="position:absolute;bottom:142px;left:870px;" width="340" height="310" viewBox="0 0 340 310">
      <rect x="0" y="48" width="340" height="262" fill="#0a2e20" rx="4"/>
      <rect x="0" y="36" width="340" height="18" fill="#082818" rx="3"/>
      <rect x="12" y="22" width="30" height="20" fill="#082818" rx="2"/><rect x="60" y="18" width="30" height="24" fill="#093020" rx="2"/><rect x="116" y="24" width="30" height="18" fill="#082818" rx="2"/><rect x="172" y="18" width="30" height="24" fill="#093020" rx="2"/><rect x="228" y="24" width="30" height="18" fill="#082818" rx="2"/><rect x="280" y="18" width="30" height="24" fill="#093020" rx="2"/>
      <rect x="12" y="60" width="290" height="44" fill="#061e10" rx="5"/>
      <rect x="22" y="66" width="16" height="32" fill="#0a3820" rx="3"/>
      <rect x="22" y="73" width="16" height="5" fill="rgba(255,255,255,0.5)"/>
      <rect x="22" y="82" width="16" height="5" fill="rgba(255,255,255,0.5)"/>
      <text x="188" y="81" text-anchor="middle" fill="#4ADE80" font-family="'Outfit',sans-serif" font-weight="900" font-size="16" letter-spacing="2">THE BARBER</text>
      <text x="188" y="95" text-anchor="middle" fill="rgba(255,255,255,0.35)" font-family="sans-serif" font-size="8" letter-spacing="2">CLASSIC &amp; MODERN CUTS</text>
      <rect x="296" y="60" width="24" height="220" fill="#0a3020" rx="5"/>
      <clipPath id="bp2"><rect x="296" y="60" width="24" height="220" rx="5"/></clipPath>
      <g clip-path="url(#bp2)">
        <rect x="296" y="60" width="24" height="220" fill="#0d4228"/>
        <line x1="293" y1="68"  x2="322" y2="86"  stroke="rgba(255,255,255,0.6)" stroke-width="6"/>
        <line x1="293" y1="88"  x2="322" y2="106" stroke="rgba(255,255,255,0.6)" stroke-width="6"/>
        <line x1="293" y1="108" x2="322" y2="126" stroke="rgba(255,255,255,0.6)" stroke-width="6"/>
        <line x1="293" y1="128" x2="322" y2="146" stroke="rgba(255,255,255,0.6)" stroke-width="6"/>
        <line x1="293" y1="148" x2="322" y2="166" stroke="rgba(255,255,255,0.6)" stroke-width="6"/>
        <line x1="293" y1="168" x2="322" y2="186" stroke="rgba(255,255,255,0.6)" stroke-width="6"/>
        <line x1="293" y1="188" x2="322" y2="206" stroke="rgba(255,255,255,0.6)" stroke-width="6"/>
        <line x1="293" y1="208" x2="322" y2="226" stroke="rgba(255,255,255,0.6)" stroke-width="6"/>
        <line x1="293" y1="228" x2="322" y2="246" stroke="rgba(255,255,255,0.6)" stroke-width="6"/>
        <line x1="293" y1="248" x2="322" y2="266" stroke="rgba(255,255,255,0.6)" stroke-width="6"/>
      </g>
      <ellipse cx="308" cy="56" rx="12" ry="5" fill="#0a3020"/>
      <ellipse cx="308" cy="282" rx="12" ry="5" fill="#0a3020"/>
      <rect x="12" y="112" width="116" height="140" fill="rgba(74,222,128,0.05)" stroke="rgba(255,255,255,0.1)" stroke-width="1.5" rx="4"/>
      <ellipse cx="45" cy="140" rx="16" ry="15" fill="rgba(0,0,0,0.28)"/>
      <rect x="32" y="152" width="26" height="8" fill="rgba(0,0,0,0.25)" rx="3"/>
      <text x="24" y="200" fill="rgba(74,222,128,0.28)" font-size="13">✂</text>
      <rect x="148" y="112" width="136" height="140" fill="rgba(255,255,255,0.025)" stroke="rgba(255,255,255,0.08)" stroke-width="1.5" rx="4"/>
      <text x="186" y="158" fill="rgba(255,255,255,0.2)" font-size="11">WALK-IN</text>
      <text x="186" y="172" fill="rgba(255,255,255,0.15)" font-size="10">WELCOME</text>
      <rect x="138" y="230" width="52" height="80" fill="rgba(255,255,255,0.04)" stroke="rgba(255,255,255,0.18)" stroke-width="1.5" rx="4"/>
      <line x1="164" y1="232" x2="164" y2="308" stroke="rgba(255,255,255,0.1)" stroke-width="1"/>
      <circle cx="152" cy="272" r="3.5" fill="rgba(74,222,128,0.8)"/>
      <rect x="124" y="308" width="92" height="6" fill="#06150a" rx="2"/>
    </svg>

    <!-- HAIR CLINIC -->
    <svg style="position:absolute;bottom:142px;left:1380px;" width="360" height="310" viewBox="0 0 360 310">
      <rect x="0" y="28" width="360" height="282" fill="#0e4230" rx="4"/>
      <rect x="8" y="36" width="344" height="266" fill="#104835" rx="3"/>
      <rect x="0" y="28" width="360" height="6" fill="#093020" rx="2"/>
      <rect x="90" y="36" width="4" height="270" fill="rgba(0,0,0,0.15)"/>
      <rect x="265" y="36" width="4" height="270" fill="rgba(0,0,0,0.15)"/>
      <rect x="12" y="42" width="336" height="52" fill="#062814" rx="6"/>
      <rect x="22" y="50" width="13" height="36" fill="#22C55E" rx="2"/>
      <rect x="14" y="61" width="29" height="14" fill="#22C55E" rx="2"/>
      <text x="210" y="66" text-anchor="middle" fill="white" font-family="'Outfit',sans-serif" font-weight="900" font-size="15" letter-spacing="1.5">DR. HAIR CLINIC</text>
      <text x="210" y="83" text-anchor="middle" fill="rgba(74,222,128,0.6)" font-family="sans-serif" font-size="9" letter-spacing="1.5">Spesialis Kesehatan Rambut</text>
      <rect x="12" y="114" width="220" height="168" fill="rgba(255,255,255,0.06)" stroke="rgba(255,255,255,0.15)" stroke-width="1.5" rx="5"/>
      <ellipse cx="76" cy="144" rx="18" ry="17" fill="rgba(255,255,255,0.1)"/>
      <rect x="60" y="158" width="32" height="60" fill="rgba(255,255,255,0.08)" rx="5"/>
      <path d="M74,178 Q66,192 74,200" stroke="rgba(74,222,128,0.4)" stroke-width="2" fill="none" stroke-linecap="round"/>
      <circle cx="74" cy="202" r="4" fill="rgba(74,222,128,0.35)"/>
      <rect x="248" y="114" width="100" height="168" fill="rgba(255,255,255,0.025)" stroke="rgba(255,255,255,0.08)" stroke-width="1.5" rx="5"/>
      <text x="298" y="155" text-anchor="middle" fill="rgba(74,222,128,0.3)" font-size="28">⚕</text>
      <text x="298" y="185" text-anchor="middle" fill="rgba(255,255,255,0.2)" font-size="9">SENIN-SABTU</text>
      <text x="298" y="200" text-anchor="middle" fill="rgba(74,222,128,0.4)" font-size="10" font-weight="bold">08:00-20:00</text>
      <polyline points="260,232 270,232 274,220 278,245 282,218 286,245 290,232 310,232" fill="none" stroke="rgba(74,222,128,0.3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
      <rect x="132" y="242" width="56" height="68" fill="rgba(255,255,255,0.05)" stroke="rgba(255,255,255,0.2)" stroke-width="1.5" rx="4"/>
      <line x1="160" y1="244" x2="160" y2="308" stroke="rgba(255,255,255,0.1)" stroke-width="1"/>
      <circle cx="148" cy="278" r="3.5" fill="rgba(74,222,128,0.9)"/>
      <circle cx="172" cy="278" r="3.5" fill="rgba(74,222,128,0.9)"/>
      <rect x="118" y="308" width="124" height="6" fill="#06150a" rx="2"/>
    </svg>
  </div><!-- /world -->

  <!-- CHARACTER -->
  <div class="character">
    <svg width="130" height="14" style="position:absolute;bottom:-5px;left:0;"><ellipse cx="55" cy="7" rx="46" ry="7" fill="rgba(0,0,0,0.3)"/></svg>
    <svg class="char-svg" width="110" height="175" viewBox="0 0 110 175">
      <g class="leg-r"><rect x="56" y="114" width="17" height="54" rx="7" fill="#0a2d1e"/><ellipse cx="64" cy="170" rx="13" ry="6" fill="#06120d"/></g>
      <g class="leg-l"><rect x="37" y="114" width="17" height="54" rx="7" fill="#0c3828"/><ellipse cx="45" cy="170" rx="13" ry="6" fill="#06120d"/></g>
      <rect x="24" y="80" width="62" height="72" rx="12" fill="#0f4a30"/>
      <path d="M40,80 L55,103 L70,80" fill="#0a3322"/>
      <line x1="44" y1="82" x2="52" y2="100" stroke="rgba(255,255,255,0.1)" stroke-width="1.5"/>
      <line x1="66" y1="82" x2="58" y2="100" stroke="rgba(255,255,255,0.1)" stroke-width="1.5"/>
      <rect x="28" y="103" width="17" height="21" rx="3" fill="rgba(255,255,255,0.05)" stroke="rgba(255,255,255,0.09)" stroke-width="0.8"/>
      <rect x="34" y="102" width="3" height="17" fill="rgba(74,222,128,0.9)" rx="1"/>
      <g class="arm-r"><rect x="83" y="85" width="14" height="46" rx="7" fill="#0f4a30"/><ellipse cx="90" cy="133" rx="10" ry="9" fill="#c9a882"/></g>
      <g class="arm-l"><rect x="13" y="85" width="14" height="46" rx="7" fill="#116040"/><ellipse cx="20" cy="133" rx="10" ry="9" fill="#c9a882"/></g>
      <rect x="46" y="66" width="18" height="18" rx="5" fill="#c9a882"/>
      <ellipse cx="55" cy="48" rx="28" ry="29" fill="#c9a882"/>
      <path d="M29,42 Q32,14 55,15 Q78,14 81,42 Q74,24 55,26 Q36,24 29,42 Z" fill="#2d1505"/>
      <path d="M55,15 Q64,7 74,14" stroke="#1a0d02" stroke-width="1.5" fill="none" stroke-linecap="round"/>
      <path d="M29,42 Q26,50 28,58" stroke="#2d1505" stroke-width="4" fill="none" stroke-linecap="round"/>
      <path d="M81,42 Q84,50 82,58" stroke="#2d1505" stroke-width="4" fill="none" stroke-linecap="round"/>
      <ellipse cx="45" cy="45" rx="4.5" ry="5" fill="white"/><ellipse cx="65" cy="45" rx="4.5" ry="5" fill="white"/>
      <circle cx="46.5" cy="46" r="2.8" fill="#1a0805"/><circle cx="66.5" cy="46" r="2.8" fill="#1a0805"/>
      <circle cx="47.5" cy="45" r="0.9" fill="white"/><circle cx="67.5" cy="45" r="0.9" fill="white"/>
      <path d="M40,38 Q45,35 50,38" stroke="#2d1505" stroke-width="1.8" fill="none" stroke-linecap="round"/>
      <path d="M60,38 Q65,35 70,38" stroke="#2d1505" stroke-width="1.8" fill="none" stroke-linecap="round"/>
      <path d="M47,57 Q55,65 63,57" stroke="#b07050" stroke-width="2" fill="none" stroke-linecap="round"/>
    </svg>
  </div>

  <!-- Location chips -->
  <div class="loc-chip salon">✂ &nbsp;Pure Salon</div>
  <div class="loc-chip barber">💈 &nbsp;The Barber</div>
  <div class="loc-chip klinik">⚕ &nbsp;Hair Clinic</div>

  <!-- Speed lines -->
  <div class="speed-lines">
    <div class="speed-line" style="top:30%;animation-duration:0.38s;"></div>
    <div class="speed-line" style="top:34%;animation-duration:0.45s;animation-delay:0.05s;opacity:0.6;"></div>
    <div class="speed-line" style="top:38%;animation-duration:0.42s;animation-delay:0.1s;"></div>
    <div class="speed-line" style="top:43%;animation-duration:0.36s;animation-delay:0.03s;opacity:0.5;"></div>
    <div class="speed-line" style="top:47%;animation-duration:0.5s;animation-delay:0.08s;"></div>
    <div class="speed-line" style="top:52%;animation-duration:0.41s;animation-delay:0.12s;opacity:0.7;"></div>
    <div class="speed-line" style="top:57%;animation-duration:0.44s;animation-delay:0.02s;"></div>
    <div class="speed-line" style="top:62%;animation-duration:0.39s;animation-delay:0.07s;opacity:0.5;"></div>
    <div class="speed-line" style="top:26%;animation-duration:0.55s;animation-delay:0.15s;opacity:0.35;"></div>
    <div class="speed-line" style="top:67%;animation-duration:0.48s;animation-delay:0.09s;opacity:0.4;"></div>
  </div>

  <!-- Ghost character -->
  <div class="char-ghost">
    <svg width="110" height="175" viewBox="0 0 110 175" style="filter:blur(4px);">
      <g opacity="0.9">
        <rect x="24" y="80" width="62" height="72" rx="12" fill="#4ADE80"/>
        <ellipse cx="55" cy="48" rx="28" ry="29" fill="#4ADE80"/>
        <rect x="37" y="114" width="17" height="54" rx="7" fill="#4ADE80"/>
        <rect x="56" y="114" width="17" height="54" rx="7" fill="#4ADE80"/>
        <rect x="13" y="85" width="14" height="46" rx="7" fill="#4ADE80"/>
        <rect x="83" y="85" width="14" height="46" rx="7" fill="#4ADE80"/>
      </g>
    </svg>
  </div>

  <!-- Progress indicator -->
  <div class="loc-progress" id="loc-progress">
    <div class="lp-step">
      <div class="lp-dot active" id="dot-1"></div>
      <div class="lp-label">Salon</div>
    </div>
    <div class="lp-line"><div class="lp-line-fill" id="fill-1"></div></div>
    <div class="lp-step">
      <div class="lp-dot" id="dot-2"></div>
      <div class="lp-label">Barber</div>
    </div>
    <div class="lp-line"><div class="lp-line-fill" id="fill-2"></div></div>
    <div class="lp-step">
      <div class="lp-dot" id="dot-3"></div>
      <div class="lp-label">Klinik</div>
    </div>
  </div>

  <!-- Skip button -->
  <button class="skip-btn" id="skip-btn" onclick="goHome()">Lewati ›</button>

</div><!-- /scene1 -->

<!-- ══════════ SCENE 2 ══════════ -->
<div class="scene" id="scene2"></div>

<!-- ══════════ SCENE 3 — Logo ══════════ -->
<div class="scene" id="scene3">
  <div class="s3-blob" style="width:240px;height:240px;top:-80px;right:-60px;background:rgba(74,222,128,0.08);"></div>
  <div class="s3-blob" style="width:180px;height:180px;bottom:60px;left:-50px;background:rgba(34,197,94,0.07);"></div>
  <div class="s3-blob" style="width:90px;height:90px;top:42%;right:8%;background:rgba(74,222,128,0.06);"></div>

  <svg class="s3-helix" style="top:8%;left:3%;width:46px;" viewBox="0 0 46 130">
    <path d="M6,0 Q40,33 6,66 Q40,99 6,130" stroke="#4ADE80" stroke-width="1.5" fill="none"/>
    <path d="M40,0 Q6,33 40,66 Q6,99 40,130" stroke="#4ADE80" stroke-width="1.5" fill="none"/>
  </svg>
  <svg class="s3-helix" style="bottom:14%;right:4%;width:36px;" viewBox="0 0 46 100">
    <path d="M6,0 Q40,25 6,50 Q40,75 6,100" stroke="#4ADE80" stroke-width="1.5" fill="none"/>
    <path d="M40,0 Q6,25 40,50 Q6,75 40,100" stroke="#4ADE80" stroke-width="1.5" fill="none"/>
  </svg>

  <!-- Welcome message with user name -->
  <div class="welcome-msg">
    <span class="hi">Selamat datang</span>
    <span class="name">{{ session('splash_message') ?? 'di PureStrand AI!' }}</span>
  </div>

  <!-- Logo card -->
  <div class="logo-card">
    <img src="{{ asset('images/purestrand_logo.jpg') }}"
         alt="PureStrand AI"
         style="width:260px;display:block;object-fit:contain;">
  </div>

  <!-- Loading dots -->
  <div class="loading-dots">
    <div class="ld"></div>
    <div class="ld"></div>
    <div class="ld"></div>
  </div>

  <div class="tagline">Your Hair. Our Intelligence.</div>
</div>

</div><!-- /splash -->
</div><!-- /splash-wrap -->

<script>
// ── Destination after animation ──
var homeUrl = "{{ route('home') }}";

function goHome() {
    window.location.href = homeUrl;
}

// ── Auto-redirect after full animation (8.2s) ──
var redirectTimer = setTimeout(goHome, 8200);

// ── Progress dots ──
var steps = ['dot-1','dot-2','dot-3'];
var fills = ['fill-1','fill-2'];

function activateStep(i) {
    // mark previous done
    if (i > 0) {
        var prev = document.getElementById(steps[i-1]);
        if (prev) { prev.classList.remove('active'); prev.classList.add('done'); }
    }
    // fill connecting line
    if (i > 0 && fills[i-1]) {
        var f = document.getElementById(fills[i-1]);
        if (f) f.style.width = '100%';
    }
    var cur = document.getElementById(steps[i]);
    if (cur) cur.classList.add('active');
}

setTimeout(function(){ activateStep(1); }, 900);
setTimeout(function(){
    var f1 = document.getElementById('fill-1');
    if (f1) f1.style.width = '100%';
}, 900);
setTimeout(function(){ activateStep(2); }, 2400);
setTimeout(function(){
    var f2 = document.getElementById('fill-2');
    if (f2) f2.style.width = '100%';
}, 2400);

// ── Camera shake ──
setTimeout(function(){
    var s1 = document.getElementById('scene1');
    if (s1) s1.classList.add('shake');
}, 4550);

// ── Hide progress before transition ──
setTimeout(function(){
    var lp = document.getElementById('loc-progress');
    if (lp) { lp.style.transition = 'opacity 0.5s'; lp.style.opacity = '0'; }
}, 4200);

// ── Hide skip button after scene3 starts ──
setTimeout(function(){
    var sb = document.getElementById('skip-btn');
    if (sb) { sb.style.transition = 'opacity 0.5s'; sb.style.opacity = '0'; sb.style.pointerEvents = 'none'; }
}, 5200);
</script>
</body>
</html>
