@extends('app')

@section('title', 'StudyGenie AI – Your Cognitive Partner')

@push('styles')
<style>

/* ─────────────────────────────────────────────
   ROOT VARIABLES
───────────────────────────────────────────── */
:root {
  --white:    #ffffff;
  --off:      #f8f7ff;
  --blue:     #3b82f6;
  --blue-l:   #eff6ff;
  --violet:   #7c3aed;
  --violet-l: #f5f3ff;
  --teal:     #0d9488;
  --teal-l:   #f0fdfa;
  --text:     #1a1a2e;
  --muted:    #64748b;
  --border:   #e2e8f0;
  --shadow:   0 4px 24px rgba(0,0,0,0.07);
}

/* ─────────────────────────────────────────────
   GLOBAL
───────────────────────────────────────────── */
section { padding: 100px 6%; }
.section-tag {
  display: inline-block;
  font-size: 0.75rem; font-weight: 600; letter-spacing: 0.1em;
  text-transform: uppercase; margin-bottom: 1rem;
  padding: 0.35rem 1rem; border-radius: 999px;
}
.tag-blue   { background: var(--blue-l);   color: var(--blue); }
.tag-violet { background: var(--violet-l); color: var(--violet); }
.tag-teal   { background: var(--teal-l);   color: var(--teal); }
.section-title {
  font-family: 'Bricolage Grotesque', sans-serif;
  font-size: clamp(1.9rem, 4vw, 3rem);
  font-weight: 800; letter-spacing: -1.5px;
  margin-bottom: 1rem; line-height: 1.15;
}
.section-sub { color: var(--muted); font-size: 1rem; max-width: 520px; line-height: 1.75; }

/* ─────────────────────────────────────────────
   HERO
───────────────────────────────────────────── */
.hero {
  min-height: 100vh;
  display: flex; flex-direction: column;
  align-items: flex-start; justify-content: center;
  padding: 130px 6% 80px;
  position: relative; overflow: hidden;
}
.hero-bg {
  position: absolute; inset: 0; z-index: 0;
  background-image: url('/image/genie1.jpg');
  background-size: cover; background-position: center center;
  background-repeat: no-repeat;
}
.hero-gradient {
  position: absolute; top: 50%; left: -220px;
  transform: translateY(-50%);
  width: 905px; height: 905px; border-radius: 50%;
  background: radial-gradient(circle at 40% 50%,
    rgba(167,80,255,0.95) 0%, rgba(124,58,237,0.80) 20%,
    rgba(79,70,229,0.65) 40%, rgba(59,130,246,0.45) 60%,
    rgba(37,99,235,0.15) 80%, transparent 100%);
  mix-blend-mode: color-dodge; filter: blur(128px);
  z-index: 1; pointer-events: none;
}
.hero-gradient-2 {
  position: absolute; top: 65%; left: -100px;
  transform: translateY(-50%);
  width: 600px; height: 600px; border-radius: 50%;
  background: radial-gradient(circle at center,
    rgba(59,130,246,0.70) 0%, rgba(99,102,241,0.45) 40%, transparent 75%);
  mix-blend-mode: color-dodge; filter: blur(100px);
  z-index: 1; pointer-events: none;
}
.hero-left {
  position: relative; z-index: 2;
  display: flex; flex-direction: column; align-items: flex-start;
  max-width: 650px; margin-left: 70px;
}
.hero-right, .hero-img, .hero-blob1, .hero-blob2 { display: none; }
.hero-badge {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: linear-gradient(135deg, var(--blue-l), var(--violet-l));
  border: 1px solid rgba(124,58,237,0.2);
  border-radius: 999px; padding: 0.45rem 1.1rem;
  font-size: 0.82rem; font-weight: 500; color: var(--violet);
  margin-bottom: 2rem; animation: fadeUp 0.6s ease both;
}
.hero h1 {
  font-family: 'Bricolage Grotesque', sans-serif;
  font-size: clamp(2.8rem, 6vw, 5.2rem);
  font-weight: 800; line-height: 1.05; letter-spacing: -2.5px;
  color: var(--text); animation: fadeUp 0.7s 0.1s ease both;
}
.hero h1 .grad {
  background: linear-gradient(135deg, var(--blue) 0%, var(--violet) 50%, var(--teal) 100%);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  display: block;
}
.hero h1 .with-word { display: block; text-align: center; }
.hero-sub {
  font-size: 1.1rem; color: var(--muted); max-width: 500px;
  margin: 1.5rem 0 2.5rem; margin-left: 55px;
  line-height: 1.75; animation: fadeUp 0.7s 0.2s ease both;
}
.hero-btns {
  display: flex; gap: 1rem; flex-wrap: wrap;
  animation: fadeUp 0.7s 0.3s ease both;
  margin-left: 195px;
}

/* ─────────────────────────────────────────────
   BUTTONS
───────────────────────────────────────────── */
.btn-primary {
  background: linear-gradient(135deg, var(--blue), var(--violet));
  color: #fff; border: none; border-radius: 12px;
  padding: 0.9rem 2.2rem; font-size: 1rem;
  font-family: 'Instrument Sans', sans-serif; font-weight: 500;
  cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;
  box-shadow: 0 6px 24px rgba(124,58,237,0.3);
  text-decoration: none; display: inline-block;
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(124,58,237,0.4); }
.btn-white {
  background: #fff; color: var(--violet);
  border: none; border-radius: 12px;
  padding: 0.95rem 2.5rem; font-size: 1rem;
  font-family: 'Instrument Sans', sans-serif; font-weight: 600;
  cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;
  box-shadow: 0 6px 24px rgba(0,0,0,0.15);
  text-decoration: none; display: inline-block;
}
.btn-white:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(0,0,0,0.2); }

/* ─────────────────────────────────────────────
   STATS BAR
───────────────────────────────────────────── */
.stats-bar {
  display: flex; justify-content: center; flex-wrap: wrap;
  background: linear-gradient(111deg, #406fb1 0%, #1e60cb 60%, #1e60cb 100%);
    margin-top: -60px;
    margin-bottom: -23px;
}
.stat {
  flex: 1; min-width: 160px; text-align: center;
  padding: 2rem 1rem;
  border-right: 1px solid rgba(255,255,255,0.15);
}
.stat:last-child { border-right: none; }
.stat-num {
  font-family: 'Bricolage Grotesque', sans-serif;
  font-size: 2.2rem; font-weight: 800; color: #fff;
}
.stat-label { font-size: 0.8rem; color: rgba(255,255,255,0.75); margin-top: 0.3rem; }

/* ─────────────────────────────────────────────
   VISION / MISSION / GOAL
───────────────────────────────────────────── */
.vms {
  background:
    radial-gradient(ellipse 70% 60% at 90% 10%, rgba(59,130,246,0.07) 0%, transparent 60%),
    #f8f7ff;
}
.vms-grid {
  display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 1.5rem; margin-top: 3rem;
}
.vms-card {
  background: #fff; border: 1.5px solid var(--border);
  border-radius: 20px; padding: 2rem;
  transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
}
.vms-card:nth-child(1):hover { border-color: var(--blue);   box-shadow: 0 12px 40px rgba(59,130,246,0.1); }
.vms-card:nth-child(2):hover { border-color: var(--violet); box-shadow: 0 12px 40px rgba(124,58,237,0.1); }
.vms-card:nth-child(3):hover { border-color: var(--teal);   box-shadow: 0 12px 40px rgba(13,148,136,0.1); }
.vms-card:hover { transform: translateY(-5px); }
.vms-icon {
  width: 52px; height: 52px; border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.5rem; margin-bottom: 1.2rem;
}
.icon-blue   { background: var(--blue-l); }
.icon-violet { background: var(--violet-l); }
.icon-teal   { background: var(--teal-l); }
.vms-card h3 {
  font-family: 'Bricolage Grotesque', sans-serif;
  font-size: 1.1rem; font-weight: 700; margin-bottom: 0.6rem;
}
.vms-card p { color: var(--muted); font-size: 0.9rem; line-height: 1.7; }

/* ─────────────────────────────────────────────
   DEVICE + TRUST SECTION
───────────────────────────────────────────── */
.device-section {
  background: linear-gradient(160deg, #1a0533 0%, #2d0a6e 25%, #4c1d95 55%, #3730a3 85%, #1e1b4b 100%);
  padding: 60px 6% 4px;
  position: relative; overflow: hidden;
}
.device-section::before {
  content: '';
  position: absolute; inset: 0;
  background:
    radial-gradient(ellipse 60% 50% at 50% 50%, rgba(139,92,246,0.22) 0%, transparent 65%),
    radial-gradient(ellipse 30% 30% at 10% 15%, rgba(99,102,241,0.15) 0%, transparent 55%),
    radial-gradient(ellipse 30% 30% at 90% 80%, rgba(167,139,250,0.12) 0%, transparent 55%);
  pointer-events: none;
}

/* ── centered header above the grid ── */
.device-trust-header {
  text-align: center;
  margin-bottom: -2rem;
  position: relative; z-index: 2;
}
.device-trust-header .trust-eyebrow {
  font-size: 0.72rem; font-weight: 700; letter-spacing: 0.2em;
  text-transform: uppercase; color: rgba(196,181,253,0.65);
  display: block; margin-bottom: 0.5rem;
}
.device-trust-header .trust-heading {
  font-family: 'Bricolage Grotesque', sans-serif;
  font-size: clamp(1.9rem, 3.5vw, 2.8rem);
  font-weight: 800; letter-spacing: -1.5px; line-height: 1.12;
  color: #fff; margin-top: 60px;
}
.device-trust-header .trust-heading span {
  background: linear-gradient(135deg, #c4b5fd, #93c5fd);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
}

/* ── two-column wrapper ── */
.device-trust-grid {
  display: grid;
  grid-template-columns: 1.8fr 1fr;  /* ← gives laptop more space, pushes cards right */
  gap: 6rem;
  align-items: center;
  max-width: 1400px;                  /* ← wider max so cards have room to shift right */
  margin: 0 auto;
  position: relative; z-index: 2;
}

/* ── right: trust cards ── */
.device-trust-col {
  display: flex;
  flex-direction: column;
  justify-content: center;
  gap: 1.5rem;
  padding-left: 4rem;                 /* ← extra push from the laptop toward the right edge */
}

/* ── left: laptop ── */
.device-laptop-col {
  display: flex;
  align-items: center;     /* ← vertically center the image inside the column */
  justify-content: center;
  margin-right: 5rem;         /* ← removed the 10% push that was sinking the laptop */
}
.device-lappy {
  width: 185%;
  height: 400%;            /* ← was 100%, auto lets it scale naturally without sinking */
  position: relative; z-index: 1;
  filter: drop-shadow(0 20px 60px rgba(0,0,0,0.6));
}


/* ── trust cards ── */
.trust-card {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 18px;
  padding: 1.6rem 1.8rem;
  display: flex;
  gap: 1.5rem;
  align-items: flex-start;
  transition: background 0.3s, border-color 0.3s, transform 0.3s;
  cursor: default;
}
.trust-card:hover {
  background: rgba(255,255,255,0.09);
  border-color: rgba(196,181,253,0.35);
  transform: translateX(6px);
}
.trust-card-icon {
  flex-shrink: 0;
  width: 46px; height: 46px;
  border-radius: 13px;
  display: flex; align-items: center; justify-content: center;
}
.trust-card-icon.ic-violet { background: rgba(124,58,237,0.3); }
.trust-card-icon.ic-blue   { background: rgba(59,130,246,0.3); }
.trust-card-icon.ic-teal   { background: rgba(13,148,136,0.3); }
.trust-card-icon svg { width: 22px; height: 22px; }
.trust-card-body { display: flex; flex-direction: column; gap: 0.3rem; }
.trust-card-body h4 {
  font-family: 'Bricolage Grotesque', sans-serif;
  font-size: 1rem; font-weight: 800;
  color: #fff; margin: 0; line-height: 1.3;
}
.trust-card-body p {
  font-size: 0.85rem; color: rgba(255,255,255,0.55);
  line-height: 1.65; margin: 0;
}
.trust-card-body .trust-proof {
  display: inline-flex; align-items: center; gap: 0.4rem;
  font-size: 0.75rem; font-weight: 600;
  color: rgba(196,181,253,0.85);
  margin-top: 0.4rem;
}
.trust-proof::before {
  content: '';
  display: inline-block;
  width: 6px; height: 6px; border-radius: 50%;
  background: #c4b5fd;
  flex-shrink: 0;
}

/* ── responsive ── */
@media (max-width: 900px) {
  .device-trust-grid {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  .device-lappy { width: 100%; }
}

/* ─────────────────────────────────────────────
   GOAL SECTION
───────────────────────────────────────────── */
.goal-section {
  background:
    radial-gradient(ellipse 60% 70% at 10% 50%, rgba(13,148,136,0.07) 0%, transparent 60%),
    radial-gradient(ellipse 50% 60% at 90% 50%, rgba(124,58,237,0.07) 0%, transparent 60%),
    #f8f7ff;
}
.goal-inner {
  background: #fff; border: 1.5px solid var(--border);
  border-radius: 24px; padding: 3.5rem;
  display: flex; gap: 4rem; align-items: flex-start; flex-wrap: wrap;
  margin-top: 3rem; box-shadow: var(--shadow);
}
.goal-left { flex: 1; min-width: 220px; }
.goal-left h2 {
  font-family: 'Bricolage Grotesque', sans-serif;
  font-size: 2.2rem; font-weight: 800; letter-spacing: -1.5px; line-height: 1.2;
}
.goal-left h2 .g-blue   { color: var(--blue); }
.goal-left h2 .g-violet { color: var(--violet); }
.goal-right { flex: 2; min-width: 260px; }
.goal-right p { color: var(--muted); line-height: 1.8; margin-bottom: 1rem; font-size: 0.95rem; }
.goal-right strong { color: var(--text); }
.goal-pct {
  font-family: 'Bricolage Grotesque', sans-serif;
  font-size: 4rem; font-weight: 800; letter-spacing: -2px;
  background: linear-gradient(135deg, var(--teal), #0891b2);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  line-height: 1; margin: 1rem 0 0.5rem;
}

/* ── Goal Details Container ── */
.goal-details {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.5rem;
  margin-top: 2rem;
}
.goal-detail-card {
  background: #fff;
  border: 1.5px solid var(--border);
  border-radius: 20px;
  padding: 2rem 1.8rem;
  display: flex; flex-direction: column; gap: 0.8rem;
  transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
}
.goal-detail-card:hover { transform: translateY(-5px); box-shadow: 0 12px 40px rgba(0,0,0,0.08); }
.goal-detail-card:nth-child(1):hover { border-color: var(--blue); }
.goal-detail-card:nth-child(2):hover { border-color: var(--violet); }
.goal-detail-card:nth-child(3):hover { border-color: var(--teal); }
.goal-detail-card:nth-child(4):hover { border-color: #f59e0b; }
.goal-detail-num {
  font-family: 'Bricolage Grotesque', sans-serif;
  font-size: 0.72rem; font-weight: 700; letter-spacing: 0.15em;
  text-transform: uppercase; color: var(--muted);
}
.goal-detail-card:nth-child(1) .goal-detail-num { color: var(--blue); }
.goal-detail-card:nth-child(2) .goal-detail-num { color: var(--violet); }
.goal-detail-card:nth-child(3) .goal-detail-num { color: var(--teal); }
.goal-detail-card:nth-child(4) .goal-detail-num { color: #f59e0b; }
.goal-detail-title {
  font-family: 'Bricolage Grotesque', sans-serif;
  font-size: 1.05rem; font-weight: 800;
  color: var(--text); letter-spacing: -0.4px; line-height: 1.3;
}
.goal-detail-divider {
  width: 32px; height: 2px; border-radius: 2px;
  background: var(--border);
}
.goal-detail-card:nth-child(1) .goal-detail-divider { background: var(--blue); }
.goal-detail-card:nth-child(2) .goal-detail-divider { background: var(--violet); }
.goal-detail-card:nth-child(3) .goal-detail-divider { background: var(--teal); }
.goal-detail-card:nth-child(4) .goal-detail-divider { background: #f59e0b; }
.goal-detail-body {
  color: var(--muted); font-size: 0.88rem; line-height: 1.75;
}
.goal-detail-tag {
  display: inline-block; align-self: flex-start;
  font-size: 0.7rem; font-weight: 700; letter-spacing: 0.06em;
  text-transform: uppercase; padding: 0.25rem 0.7rem;
  border-radius: 999px; margin-top: 0.4rem;
}
.goal-detail-card:nth-child(1) .goal-detail-tag { background: var(--blue-l);   color: var(--blue); }
.goal-detail-card:nth-child(2) .goal-detail-tag { background: var(--violet-l); color: var(--violet); }
.goal-detail-card:nth-child(3) .goal-detail-tag { background: var(--teal-l);   color: var(--teal); }
.goal-detail-card:nth-child(4) .goal-detail-tag { background: #fffbeb; color: #d97706; }

@media (max-width: 768px) {
  .goal-details { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 480px) {
  .goal-details { grid-template-columns: 1fr; }
}

/* ─────────────────────────────────────────────
   CTA SECTION
───────────────────────────────────────────── */
.cta-section {
  text-align: center;
  background: linear-gradient(135deg, var(--blue) 0%, var(--violet) 60%, var(--teal) 100%);
  padding: 100px 6%;
}
.cta-section .section-tag { background: rgba(255,255,255,0.2); color: #fff; }
.cta-section h2 {
  font-family: 'Bricolage Grotesque', sans-serif;
  font-size: clamp(2rem, 4.5vw, 3.2rem);
  font-weight: 800; letter-spacing: -1.5px; color: #fff; margin-bottom: 1rem;
}
.cta-section p { color: rgba(255,255,255,0.8); max-width: 500px; margin: 0 auto 2.5rem; }

/* ─────────────────────────────────────────────
   ANIMATIONS
───────────────────────────────────────────── */
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(28px); }
  to   { opacity: 1; transform: translateY(0); }
}
.reveal {
  opacity: 0; transform: translateY(32px);
  transition: opacity 0.65s ease, transform 0.65s ease;
}
.reveal.visible { opacity: 1; transform: none; margin-top: 50px }

/* ─────────────────────────────────────────────
   RESPONSIVE
───────────────────────────────────────────── */
@media (max-width: 768px) {
  .hero      { padding: 110px 4% 60px; }
  .hero-left { margin-left: 0; max-width: 100%; }
  .hero-sub  { margin-left: 0; }
  .hero-btns { margin-left: 0; }
  section    { padding: 70px 4%; }
  .goal-inner { padding: 2rem; gap: 2rem; }
  .stat      { min-width: 130px; }
}

</style>
@endpush

@section('content')

{{-- ── HERO ─────────────────────────────────────── --}}
<section class="hero">
  <div class="hero-bg"></div>
  <div class="hero-gradient"></div>
  <div class="hero-gradient-2"></div>
  <div class="hero-left">
    <div class="hero-badge">✨ AI-Powered Cognitive Partner</div>
    <h1>
      Study Smarter
      <span class="grad">
        <span class="with-word">with</span>
        StudyGenie AI
      </span>
    </h1>
    <p class="hero-sub">
      Learn. Retain. Excel.
    </p>
    <div class="hero-btns">
      <a href="/features" class="btn-primary">Start for Free</a>
    </div>
  </div>
</section>

{{-- ── STATS BAR ────────────────────────────────── --}}
<div class="stats-bar">
  @foreach($stats as $stat)
    <div class="stat reveal">
      <div class="stat-num">{{ $stat['value'] }}</div>
      <div class="stat-label">{{ $stat['label'] }}</div>
    </div>
  @endforeach
</div>

{{-- ── VISION / MISSION / GOAL ─────────────────── --}}
<section class="vms" id="vision">
  <div class="section-tag tag-blue">Who We Are</div>
  <h2 class="section-title">Built with a purpose.</h2>
  <p class="section-sub">Every feature is designed around one thing: making sure no student is left behind.</p>
  <div class="vms-grid">
    @foreach($pillars as $i => $pillar)
      @php $colors = ['blue','violet','teal']; $c = $colors[$i % 3]; @endphp
      <div class="vms-card reveal">
        <div class="vms-icon icon-{{ $c }}">{{ $pillar['icon'] }}</div>
        <h3>{{ $pillar['title'] }}</h3>
        <p>{{ $pillar['body'] }}</p>
      </div>
    @endforeach
  </div>
</section>

{{-- ── DEVICE + TRUST ───────────────────────────── --}}
<section class="device-section">

  {{-- centered heading above everything --}}
  <div class="device-trust-header reveal">
    <span class="trust-eyebrow">Why Students Trust Us</span>
    <h2 class="trust-heading">
      Built for real <span>student success.</span>
    </h2>
  </div>

  {{-- laptop left · cards right --}}
  <div class="device-trust-grid reveal">

    {{-- LEFT: laptop --}}
    <div class="device-laptop-col">
      <img
        src="{{ asset('image/lappy.png') }}"
        alt="StudyGenie AI on laptop"
        class="device-lappy"
      />
    </div>

    {{-- RIGHT: 3 trust cards --}}
    <div class="device-trust-col">

      {{-- Card 1: Privacy & Security --}}
      <div class="trust-card">
        <div class="trust-card-icon ic-violet">
          <svg viewBox="0 0 24 24" fill="none" stroke="#c4b5fd" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
        </div>
        <div class="trust-card-body">
          <h4>Your Data, Your Privacy</h4>
          <p>We never sell or share your notes, files, or study data. Everything you upload stays encrypted and belongs only to you.</p>
        </div>
      </div>

      {{-- Card 2: Proven Results --}}
      <div class="trust-card">
        <div class="trust-card-icon ic-blue">
          <svg viewBox="0 0 24 24" fill="none" stroke="#93c5fd" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
          </svg>
        </div>
        <div class="trust-card-body">
          <h4>Proven to Improve Grades</h4>
          <p>Students using StudyGenie report an average grade improvement within the first month — backed by real retention science.</p>
        </div>
      </div>

      {{-- Card 3: Always Available --}}
      <div class="trust-card">
        <div class="trust-card-icon ic-teal">
          <svg viewBox="0 0 24 24" fill="none" stroke="#5eead4" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
        </div>
        <div class="trust-card-body">
          <h4>Available 24/7, No Limits</h4>
          <p>Study at midnight before an exam or at dawn before class. StudyGenie never sleeps, never crashes, and never lets you down.</p>
        </div>
      </div>

    </div>
  </div>
</section>

{{-- ── GOAL ─────────────────────────────────────── --}}
<section class="goal-section" id="goal">
  <div class="section-tag tag-teal">Our Core Focus</div>
  <h2 class="section-title">Eliminating Study Friction.</h2>
  <div class="goal-inner reveal">
    <div class="goal-left">
      <h2>
        The goal isn't to make <span class="g-blue">notes.</span><br>
        It's to make you <span class="g-violet">understand.</span>
      </h2>
    </div>
    <div class="goal-right">
      <p>
        The primary objective of {{ $appName }} is <strong>Cognitive Optimization</strong>.
        We eliminate "Study Friction" — the mental exhaustion and time wasted on manual organization of information.
      </p>
      <p>By automating the preparation phase, {{ $appName }} ensures that:</p>
      <div class="goal-pct">100%</div>
      <p>
        of a student's study time is spent on <strong>actual comprehension and retention</strong>,
        leading to higher grades with less burnout.
      </p>
    </div>
  </div>

  {{-- New: Goal Details Cards --}}
  <div class="goal-details reveal">

    <div class="goal-detail-card">
      <span class="goal-detail-num">Goal 01</span>
      <div class="goal-detail-title">Instant Content Transformation</div>
      <div class="goal-detail-divider"></div>
      <p class="goal-detail-body">
        Upload any PDF, lecture slide, or handwritten note and {{ $appName }} automatically breaks it down into flashcards, summaries, and quizzes — ready to study in seconds, no manual effort required.
      </p>
      <span class="goal-detail-tag">Automated</span>
    </div>

    <div class="goal-detail-card">
      <span class="goal-detail-num">Goal 02</span>
      <div class="goal-detail-title">Long-Term Knowledge Retention</div>
      <div class="goal-detail-divider"></div>
      <p class="goal-detail-body">
        Our AI uses spaced repetition science to schedule your reviews at precisely the right moment — right before your brain forgets — so what you learn stays with you well beyond exam day.
      </p>
      <span class="goal-detail-tag">Science-Backed</span>
    </div>

    <div class="goal-detail-card">
      <span class="goal-detail-num">Goal 03</span>
      <div class="goal-detail-title">Transparent Progress Tracking</div>
      <div class="goal-detail-divider"></div>
      <p class="goal-detail-body">
        Real-time dashboards surface your mastery level per topic, highlight weak areas, and track study streaks — so you always know exactly where to spend your next session instead of guessing.
      </p>
      <span class="goal-detail-tag">Data-Driven</span>
    </div>

    <div class="goal-detail-card">
      <span class="goal-detail-num">Goal 04</span>
      <div class="goal-detail-title">Sustainable Study Habits</div>
      <div class="goal-detail-divider"></div>
      <p class="goal-detail-body">
        Built-in focus timers, smart break reminders, and daily session limits help you work in high-efficiency bursts — protecting you from burnout while consistently moving you toward your goals.
      </p>
      <span class="goal-detail-tag">Balanced</span>
    </div>

  </div>
</section>


{{-- ── CTA ──────────────────────────────────────── --}}
<section class="cta-section">
  <div class="section-tag">Get Started</div>
  <h2>Anyone can master anything.<br>That means you.</h2>
  <p>Join students who study smarter — not harder — with {{ $appName }}.</p>
  <a href="/features" class="btn-white">Start for Free — No Credit Card Needed</a>
</section>

@endsection

@push('scripts')
<script>
  // Scroll reveal
  const reveals = document.querySelectorAll('.reveal');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
      if (entry.isIntersecting) setTimeout(() => entry.target.classList.add('visible'), i * 80);
    });
  }, { threshold: 0.08 });
  reveals.forEach(r => observer.observe(r));

  // Navbar scroll shadow
  window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 20);
  });
</script>
@endpush