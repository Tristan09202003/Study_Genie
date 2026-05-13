@extends('app')

@section('title', 'Smart Flashcard Deck – StudyGenie AI')

@push('styles')
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --amber:   #d97706;
      --amber-d: #b45309;
      --amber-l: #fffbeb;
      --amber-m: #fde68a;
      --text:    #0f172a;
      --muted:   #64748b;
      --border:  #e2e8f0;
      --white:   #ffffff;
      --off:     #fffdf5;
    }
    html { scroll-behavior: smooth; }
    body { font-family: 'Instrument Sans', sans-serif; background: var(--white); color: var(--text); overflow-x: hidden; }


    /* HERO */
    .hero {
      padding: 130px 6% 90px; text-align: center;
      background:
        radial-gradient(ellipse 80% 50% at 50% 0%, rgba(217,119,6,0.1) 0%, transparent 60%),
        #fff;
    }
    .hero-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--amber-l); border: 1px solid var(--amber-m); border-radius: 999px; padding: 0.4rem 1rem; font-size: 0.8rem; font-weight: 600; color: var(--amber); margin-bottom: 1.5rem; }
    .hero h1 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(2.8rem, 5.5vw, 4.5rem); font-weight: 800; letter-spacing: -2.5px; line-height: 1.05; margin-bottom: 1.2rem; max-width: 800px; margin-inline: auto; }
    .hero h1 span { background: linear-gradient(135deg, var(--amber), #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .hero-sub { font-size: 1.1rem; color: var(--muted); line-height: 1.75; margin-bottom: 2.5rem; max-width: 560px; margin-inline: auto; }
    .btn-primary { background: linear-gradient(135deg, var(--amber), var(--amber-d)); color: #fff; border: none; border-radius: 12px; padding: 0.9rem 2rem; font-size: 1rem; font-family: 'Instrument Sans', sans-serif; font-weight: 600; cursor: pointer; box-shadow: 0 6px 24px rgba(217,119,6,0.35); transition: transform 0.2s, box-shadow 0.2s; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(217,119,6,0.45); }

    /* FLASHCARD DEMO */
    .card-demo { padding: 60px 6%; background: var(--off); display: flex; gap: 2rem; justify-content: center; flex-wrap: wrap; align-items: flex-start; }
    .flashcard {
      width: 280px; min-height: 180px;
      border-radius: 20px; padding: 2rem;
      display: flex; flex-direction: column; justify-content: space-between;
      transition: transform 0.3s, box-shadow 0.3s;
      cursor: pointer;
    }
    .flashcard:hover { transform: translateY(-6px) rotate(-1deg); }
    .fc-q { background: #fff; border: 2px solid var(--amber-m); box-shadow: 0 8px 30px rgba(217,119,6,0.1); }
    .fc-a { background: var(--amber-l); border: 2px solid var(--amber); box-shadow: 0 8px 30px rgba(217,119,6,0.15); }
    .fc-learned { background: #f0fdf4; border: 2px solid #86efac; box-shadow: 0 8px 30px rgba(22,163,74,0.1); transform: rotate(1.5deg); }
    .fc-type { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.8rem; }
    .fc-q .fc-type { color: var(--muted); }
    .fc-a .fc-type { color: var(--amber); }
    .fc-learned .fc-type { color: #16a34a; }
    .flashcard p { font-size: 0.9rem; line-height: 1.6; font-weight: 500; }
    .fc-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 1rem; }
    .fc-difficulty { font-size: 0.72rem; color: var(--muted); }
    .fc-tag { font-size: 0.7rem; padding: 0.2rem 0.6rem; border-radius: 6px; font-weight: 600; }
    .tag-review { background: var(--amber-l); color: var(--amber); }
    .tag-known  { background: #dcfce7; color: #15803d; }

    /* SRS EXPLAINED */
    .srs-section { padding: 90px 6%; background: #fff; display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; }
    .srs-text .sec-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--amber); margin-bottom: 0.8rem; }
    .srs-text h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(1.8rem, 3.5vw, 2.6rem); font-weight: 800; letter-spacing: -1.5px; margin-bottom: 1rem; }
    .srs-text h2 span { color: var(--amber); }
    .srs-text p { color: var(--muted); line-height: 1.8; font-size: 0.95rem; margin-bottom: 1.5rem; }
    .srs-points { display: flex; flex-direction: column; gap: 0.9rem; }
    .sp-item { display: flex; align-items: flex-start; gap: 0.8rem; }
    .sp-dot { width: 8px; height: 8px; background: var(--amber); border-radius: 50%; flex-shrink: 0; margin-top: 0.5rem; }
    .sp-item p { font-size: 0.9rem; color: var(--text); line-height: 1.6; font-weight: 500; }

    /* SRS CHART VISUAL */
    .srs-visual { background: var(--off); border: 1.5px solid var(--border); border-radius: 24px; padding: 2rem; box-shadow: 0 20px 60px rgba(217,119,6,0.08); }
    .sv-title { font-family: 'Bricolage Grotesque', sans-serif; font-size: 0.9rem; font-weight: 700; margin-bottom: 1.5rem; }
    .sv-timeline { display: flex; flex-direction: column; gap: 1rem; }
    .sv-row { display: flex; align-items: center; gap: 1rem; }
    .sv-day { font-size: 0.75rem; font-weight: 600; color: var(--muted); width: 50px; flex-shrink: 0; }
    .sv-bar-wrap { flex: 1; }
    .sv-bar { height: 28px; border-radius: 8px; background: linear-gradient(90deg, var(--amber), #f59e0b); display: flex; align-items: center; padding: 0 0.8rem; font-size: 0.72rem; font-weight: 600; color: #fff; }
    .sv-status { font-size: 0.72rem; font-weight: 600; width: 60px; text-align: right; }
    .status-new    { color: #3b82f6; }
    .status-review { color: var(--amber); }
    .status-known  { color: #16a34a; }

    /* HOW */
    .how-section { padding: 90px 6%; background: linear-gradient(135deg, rgba(217,119,6,0.04) 0%, rgba(180,83,9,0.06) 100%), var(--off); }
    .how-section .sec-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--amber); margin-bottom: 0.8rem; }
    .how-section h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(1.8rem, 3.5vw, 2.5rem); font-weight: 800; letter-spacing: -1.5px; margin-bottom: 3rem; }
    .steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
    .step { background: #fff; border: 1.5px solid var(--border); border-radius: 20px; padding: 2.5rem 2rem; text-align: center; transition: border-color 0.3s, box-shadow 0.3s; }
    .step:hover { border-color: var(--amber); box-shadow: 0 16px 50px rgba(217,119,6,0.1); }
    .step-num { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, var(--amber), var(--amber-d)); color: #fff; font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.4rem; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 6px 20px rgba(217,119,6,0.3); }
    .step h3 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.05rem; font-weight: 700; margin-bottom: 0.6rem; }
    .step p { font-size: 0.88rem; color: var(--muted); line-height: 1.7; }

    .cta { padding: 100px 6%; text-align: center; background: linear-gradient(135deg, var(--amber) 0%, var(--amber-d) 100%); }
    .cta h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; letter-spacing: -1.5px; color: #fff; margin-bottom: 1rem; }
    .cta p { color: rgba(255,255,255,0.85); margin-bottom: 2.5rem; max-width: 460px; margin-inline: auto; margin-bottom: 2.5rem; }
    .btn-white { background: #fff; color: var(--amber); border: none; border-radius: 12px; padding: 0.95rem 2.5rem; font-size: 1rem; font-family: 'Instrument Sans', sans-serif; font-weight: 700; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 6px 24px rgba(0,0,0,0.15); }
    .btn-white:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(0,0,0,0.2); }
    footer { padding: 2.5rem 6%; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; }
    footer p { color: var(--muted); font-size: 0.82rem; }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
    .hero > * { animation: fadeUp 0.65s ease both; }
    .hero-badge { animation-delay: 0s; } .hero h1 { animation-delay: 0.1s; } .hero-sub { animation-delay: 0.2s; } .btn-primary { animation-delay: 0.3s; }
    .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .reveal.visible { opacity: 1; transform: none; }
    @media (max-width: 900px) { .srs-section { grid-template-columns: 1fr; gap: 3rem; } .steps { grid-template-columns: 1fr; } .hero { padding: 110px 4% 60px; } .nav-links { display: none; } }
</style>
@endpush

@section('content')
<nav>
  <a href="/" class="logo">🚀 {{ $appName }}</a>
  <ul class="nav-links">
    <li><a href="/#features">Features</a></li>
    <li><a href="/#vision">About</a></li>
    <li><a href="/#goal">Our Goal</a></li>
  </ul>
  <a href="/" class="nav-back">← Back to Home</a>
  <button class="nav-cta">Get Started Free</button>
</nav>

<section class="hero">
  <div class="hero-badge">🃏 Spaced Repetition</div>
  <h1>Remember <span>Everything.</span><br>Forever.</h1>
  <p class="hero-sub">StudyGenie's SRS flashcard system schedules reviews at the perfect moment — right before you forget — turning short-term notes into permanent knowledge.</p>
  <button class="btn-primary">Create Your Deck →</button>
</section>

<!-- FLASHCARD DEMO -->
<div class="card-demo">
  <div class="flashcard fc-q reveal">
    <div>
      <div class="fc-type">Question</div>
      <p>What is the primary function of the sodium-potassium pump?</p>
    </div>
    <div class="fc-footer">
      <span class="fc-difficulty">Difficulty: Medium</span>
      <span class="fc-tag tag-review">Due Today</span>
    </div>
  </div>
  <div class="flashcard fc-a reveal">
    <div>
      <div class="fc-type">Answer</div>
      <p>Maintains the resting membrane potential by pumping 3 Na⁺ out and 2 K⁺ in per cycle, using ATP.</p>
    </div>
    <div class="fc-footer">
      <span class="fc-difficulty">Next review: 3 days</span>
      <span class="fc-tag tag-review">In Progress</span>
    </div>
  </div>
  <div class="flashcard fc-learned reveal">
    <div>
      <div class="fc-type">Mastered ✓</div>
      <p>Define action potential threshold.</p>
    </div>
    <div class="fc-footer">
      <span class="fc-difficulty">Next review: 21 days</span>
      <span class="fc-tag tag-known">Learned</span>
    </div>
  </div>
</div>

<!-- SRS EXPLAINED -->
<section class="srs-section">
  <div class="srs-text">
    <p class="sec-label">The Science</p>
    <h2>Why <span>SRS</span> actually works</h2>
    <p>Spaced Repetition is the most scientifically proven method for long-term memory retention. Instead of cramming, it spaces reviews at increasing intervals — right before you forget.</p>
    <div class="srs-points">
      <div class="sp-item reveal"><div class="sp-dot"></div><p>Reviews timed at peak forgetting curve moments</p></div>
      <div class="sp-item reveal"><div class="sp-dot"></div><p>Cards you know well get pushed further out automatically</p></div>
      <div class="sp-item reveal"><div class="sp-dot"></div><p>Difficult cards resurface more frequently until mastered</p></div>
      <div class="sp-item reveal"><div class="sp-dot"></div><p>Daily review sessions keep total workload manageable</p></div>
    </div>
  </div>
  <div class="srs-visual reveal">
    <p class="sv-title">📅 Review Schedule — Cell Biology Deck</p>
    <div class="sv-timeline">
      <div class="sv-row">
        <div class="sv-day">Day 1</div>
        <div class="sv-bar-wrap"><div class="sv-bar" style="width:95%">First study — 40 cards</div></div>
        <div class="sv-status status-new">New</div>
      </div>
      <div class="sv-row">
        <div class="sv-day">Day 2</div>
        <div class="sv-bar-wrap"><div class="sv-bar" style="width:60%">Review — 24 cards</div></div>
        <div class="sv-status status-review">Review</div>
      </div>
      <div class="sv-row">
        <div class="sv-day">Day 5</div>
        <div class="sv-bar-wrap"><div class="sv-bar" style="width:40%">Review — 16 cards</div></div>
        <div class="sv-status status-review">Review</div>
      </div>
      <div class="sv-row">
        <div class="sv-day">Day 12</div>
        <div class="sv-bar-wrap"><div class="sv-bar" style="width:22%">Review — 9 cards</div></div>
        <div class="sv-status status-known">Mastered</div>
      </div>
      <div class="sv-row">
        <div class="sv-day">Day 30</div>
        <div class="sv-bar-wrap"><div class="sv-bar" style="width:10%">3 cards</div></div>
        <div class="sv-status status-known">Known</div>
      </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-section">
  <p class="sec-label">Process</p>
  <h2>Your memory, optimized</h2>
  <div class="steps">
    <div class="step reveal">
      <div class="step-num">1</div>
      <h3>Cards Are Generated</h3>
      <p>AI creates Q&A flashcards from your uploaded study material — automatically, no manual effort.</p>
    </div>
    <div class="step reveal">
      <div class="step-num">2</div>
      <h3>Review Daily</h3>
      <p>The SRS engine shows you cards at the scientifically optimal interval each day.</p>
    </div>
    <div class="step reveal">
      <div class="step-num">3</div>
      <h3>Lock It In</h3>
      <p>Concepts move to long-term memory naturally — higher grades with far less cramming.</p>
    </div>
  </div>
</section>

<section class="cta">
  <h2>Cram less.<br>Remember more.</h2>
  <p>Let StudyGenie's SRS engine build lasting knowledge from your study materials — automatically.</p>
  <button class="btn-white">Build Your Flashcard Deck →</button>
</section>
@endsection

@push('scripts')
<script>
const reveals = document.querySelectorAll('.reveal');
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => { if (e.isIntersecting) setTimeout(() => e.target.classList.add('visible'), i * 90); });
  }, { threshold: 0.08 });
  reveals.forEach(r => io.observe(r));
</script>
@endpush
