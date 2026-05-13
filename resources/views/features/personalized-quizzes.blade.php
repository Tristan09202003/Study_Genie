@extends('app')

@section('title', 'Personalized Quizzes – StudyGenie AI')

@push('styles')
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --violet:  #7c3aed;
      --violet-d:#5b21b6;
      --violet-l:#f5f3ff;
      --violet-m:#ddd6fe;
      --text:    #0f172a;
      --muted:   #64748b;
      --border:  #e2e8f0;
      --white:   #ffffff;
      --off:     #faf8ff;
    }
    html { scroll-behavior: smooth; }
    body { font-family: 'Instrument Sans', sans-serif; background: var(--white); color: var(--text); overflow-x: hidden; }

    /* HERO */
    .hero {
      padding: 130px 6% 90px;
      background:
        radial-gradient(ellipse 70% 60% at 0% 0%, rgba(124,58,237,0.1) 0%, transparent 55%),
        radial-gradient(ellipse 50% 40% at 100% 100%, rgba(124,58,237,0.07) 0%, transparent 55%),
        #fff;
      text-align: center; position: relative;
    }
    .hero-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--violet-l); border: 1px solid var(--violet-m); border-radius: 999px; padding: 0.4rem 1rem; font-size: 0.8rem; font-weight: 600; color: var(--violet); margin-bottom: 1.5rem; }
    .hero h1 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(2.8rem, 5.5vw, 4.5rem); font-weight: 800; letter-spacing: -2.5px; line-height: 1.05; margin-bottom: 1.2rem; max-width: 800px; margin-inline: auto; }
    .hero h1 span { background: linear-gradient(135deg, var(--violet), #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .hero-sub { font-size: 1.1rem; color: var(--muted); line-height: 1.75; margin-bottom: 2.5rem; max-width: 560px; margin-inline: auto; }
    .hero-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
    .btn-primary { background: linear-gradient(135deg, var(--violet), var(--violet-d)); color: #fff; border: none; border-radius: 12px; padding: 0.9rem 2rem; font-size: 1rem; font-family: 'Instrument Sans', sans-serif; font-weight: 600; cursor: pointer; box-shadow: 0 6px 24px rgba(124,58,237,0.35); transition: transform 0.2s, box-shadow 0.2s; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(124,58,237,0.45); }
    .btn-ghost { background: transparent; color: var(--text); border: 1.5px solid var(--border); border-radius: 12px; padding: 0.9rem 2rem; font-size: 1rem; font-family: 'Instrument Sans', sans-serif; font-weight: 500; cursor: pointer; transition: border-color 0.2s, transform 0.2s; }
    .btn-ghost:hover { border-color: var(--violet); transform: translateY(-2px); }

    /* QUIZ PREVIEW STRIP */
    .quiz-preview {
      padding: 60px 6%;
      background: var(--off);
      display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;
    }
    .qp-card {
      background: #fff; border: 1.5px solid var(--border);
      border-radius: 20px; padding: 1.8rem; position: relative;
      transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
    }
    .qp-card:hover { transform: translateY(-5px); box-shadow: 0 16px 50px rgba(124,58,237,0.1); border-color: var(--violet); }
    .qp-badge {
      display: inline-block; border-radius: 999px; padding: 0.25rem 0.75rem;
      font-size: 0.72rem; font-weight: 700; margin-bottom: 1rem;
    }
    .badge-easy   { background: #dcfce7; color: #15803d; }
    .badge-medium { background: #fef9c3; color: #a16207; }
    .badge-hard   { background: #fee2e2; color: #dc2626; }
    .qp-card h4 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 1rem; font-weight: 700; margin-bottom: 1rem; }
    .qp-options { display: flex; flex-direction: column; gap: 0.5rem; }
    .qp-opt {
      border-radius: 8px; padding: 0.6rem 0.9rem; font-size: 0.82rem;
      border: 1.5px solid var(--border); cursor: pointer; transition: all 0.2s;
      font-family: 'Instrument Sans', sans-serif; font-weight: 500;
    }
    .qp-opt.correct { background: #f0fdf4; border-color: #16a34a; color: #15803d; }
    .qp-opt.selected { background: var(--violet-l); border-color: var(--violet); color: var(--violet); }

    /* DIFFICULTY LEVELS */
    .levels-section { padding: 90px 6%; background: #fff; }
    .levels-section .sec-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--violet); margin-bottom: 0.8rem; }
    .levels-section h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(1.8rem, 3.5vw, 2.6rem); font-weight: 800; letter-spacing: -1.5px; margin-bottom: 0.8rem; }
    .levels-section > p { color: var(--muted); margin-bottom: 3rem; max-width: 520px; line-height: 1.7; }
    .levels-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
    .level-card {
      border-radius: 20px; padding: 2.5rem 2rem; text-align: center;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .level-card:hover { transform: translateY(-5px); box-shadow: 0 16px 50px rgba(0,0,0,0.08); }
    .lc-easy   { background: #f0fdf4; border: 1.5px solid #bbf7d0; }
    .lc-medium { background: #fefce8; border: 1.5px solid #fef08a; }
    .lc-hard   { background: #fef2f2; border: 1.5px solid #fecaca; }
    .level-icon { font-size: 2.5rem; margin-bottom: 1rem; }
    .level-card h3 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.2rem; font-weight: 800; margin-bottom: 0.6rem; }
    .lc-easy h3   { color: #15803d; }
    .lc-medium h3 { color: #a16207; }
    .lc-hard h3   { color: #dc2626; }
    .level-card p { font-size: 0.88rem; color: var(--muted); line-height: 1.7; }

    /* ADAPTIVE ENGINE */
    .adaptive-section {
      padding: 90px 6%;
      background: linear-gradient(135deg, rgba(124,58,237,0.04) 0%, rgba(91,33,182,0.07) 100%), var(--off);
      display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center;
    }
    .adaptive-text .sec-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--violet); margin-bottom: 0.8rem; }
    .adaptive-text h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(1.8rem, 3.5vw, 2.6rem); font-weight: 800; letter-spacing: -1.5px; margin-bottom: 1rem; }
    .adaptive-text h2 span { color: var(--violet); }
    .adaptive-text p { color: var(--muted); line-height: 1.8; font-size: 0.95rem; margin-bottom: 1.5rem; }
    .adaptive-points { display: flex; flex-direction: column; gap: 0.9rem; }
    .ap-item { display: flex; align-items: flex-start; gap: 0.8rem; }
    .ap-check { width: 22px; height: 22px; border-radius: 6px; background: var(--violet-l); display: flex; align-items: center; justify-content: center; font-size: 0.75rem; flex-shrink: 0; margin-top: 0.1rem; }
    .ap-item p { font-size: 0.9rem; color: var(--text); line-height: 1.6; font-weight: 500; }

    /* SCORE VISUAL */
    .score-visual {
      background: #fff; border: 1.5px solid var(--border);
      border-radius: 24px; padding: 2rem;
      box-shadow: 0 20px 60px rgba(124,58,237,0.1);
    }
    .sv-title { font-family: 'Bricolage Grotesque', sans-serif; font-size: 0.95rem; font-weight: 700; margin-bottom: 1.5rem; color: var(--text); }
    .sv-bar-wrap { margin-bottom: 1rem; }
    .sv-bar-label { display: flex; justify-content: space-between; font-size: 0.8rem; color: var(--muted); margin-bottom: 0.4rem; }
    .sv-bar { height: 10px; background: var(--border); border-radius: 5px; overflow: hidden; }
    .sv-fill { height: 100%; border-radius: 5px; background: linear-gradient(90deg, var(--violet), #a78bfa); }
    .sv-footer { margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border); display: flex; justify-content: space-between; }
    .svf-item { text-align: center; }
    .svf-num { font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.5rem; font-weight: 800; color: var(--violet); }
    .svf-label { font-size: 0.72rem; color: var(--muted); margin-top: 0.2rem; }

    /* HOW IT WORKS */
    .how-section { padding: 90px 6%; background: #fff; }
    .how-section .sec-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--violet); margin-bottom: 0.8rem; }
    .how-section h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(1.8rem, 3.5vw, 2.5rem); font-weight: 800; letter-spacing: -1.5px; margin-bottom: 3rem; }
    .steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
    .step { background: var(--off); border: 1.5px solid var(--border); border-radius: 20px; padding: 2.5rem 2rem; text-align: center; transition: border-color 0.3s, box-shadow 0.3s; }
    .step:hover { border-color: var(--violet); box-shadow: 0 16px 50px rgba(124,58,237,0.1); }
    .step-num { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, var(--violet), var(--violet-d)); color: #fff; font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.4rem; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 6px 20px rgba(124,58,237,0.3); }
    .step h3 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.05rem; font-weight: 700; margin-bottom: 0.6rem; }
    .step p { font-size: 0.88rem; color: var(--muted); line-height: 1.7; }

    /* CTA */
    .cta { padding: 100px 6%; text-align: center; background: linear-gradient(135deg, var(--violet) 0%, var(--violet-d) 100%); }
    .cta h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; letter-spacing: -1.5px; color: #fff; margin-bottom: 1rem; }
    .cta p { color: rgba(255,255,255,0.8); margin-bottom: 2.5rem; max-width: 460px; margin-inline: auto; margin-bottom: 2.5rem; }
    .btn-white { background: #fff; color: var(--violet); border: none; border-radius: 12px; padding: 0.95rem 2.5rem; font-size: 1rem; font-family: 'Instrument Sans', sans-serif; font-weight: 700; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 6px 24px rgba(0,0,0,0.15); }
    .btn-white:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(0,0,0,0.2); }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
    .hero > * { animation: fadeUp 0.65s ease both; }
    .hero-badge { animation-delay: 0s; }
    .hero h1    { animation-delay: 0.1s; }
    .hero-sub   { animation-delay: 0.2s; }
    .hero-btns  { animation-delay: 0.3s; }
    .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .reveal.visible { opacity: 1; transform: none; }

    @media (max-width: 900px) {
      .adaptive-section { grid-template-columns: 1fr; gap: 3rem; }
      .levels-grid, .steps { grid-template-columns: 1fr; }
      .hero { padding: 110px 4% 60px; }
      .nav-links { display: none; }
    }
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
  <div class="hero-badge">🎯 Adaptive Intelligence</div>
  <h1>Quizzes That <span>Know You</span><br>Better Than You Do</h1>
  <p class="hero-sub">StudyGenie builds personalized quizzes based on your difficulty level and knowledge gaps — adapting in real time so you're always challenged at exactly the right level.</p>
  <div class="hero-btns">
    <button class="btn-primary">Start a Quiz →</button>
    <button class="btn-ghost">See How It Works</button>
  </div>
</section>

<!-- QUIZ PREVIEW -->
<div class="quiz-preview">
  <div class="qp-card reveal">
    <div class="qp-badge badge-easy">Easy</div>
    <h4>What is the powerhouse of the cell?</h4>
    <div class="qp-options">
      <div class="qp-opt">Nucleus</div>
      <div class="qp-opt correct">✓ Mitochondria</div>
      <div class="qp-opt">Ribosome</div>
    </div>
  </div>
  <div class="qp-card reveal">
    <div class="qp-badge badge-medium">Medium</div>
    <h4>Which process converts glucose to pyruvate?</h4>
    <div class="qp-options">
      <div class="qp-opt selected">Glycolysis</div>
      <div class="qp-opt">Krebs Cycle</div>
      <div class="qp-opt">Oxidative Phosphorylation</div>
    </div>
  </div>
  <div class="qp-card reveal">
    <div class="qp-badge badge-hard">Hard</div>
    <h4>In what cellular location does beta-oxidation primarily occur?</h4>
    <div class="qp-options">
      <div class="qp-opt">Cytoplasm</div>
      <div class="qp-opt">Endoplasmic Reticulum</div>
      <div class="qp-opt correct">✓ Mitochondrial Matrix</div>
    </div>
  </div>
</div>

<!-- DIFFICULTY LEVELS -->
<section class="levels-section">
  <p class="sec-label">Difficulty System</p>
  <h2>Three levels, infinite depth</h2>
  <p>Whether you're just starting out or preparing for finals, StudyGenie meets you exactly where you are.</p>
  <div class="levels-grid">
    <div class="level-card lc-easy reveal">
      <div class="level-icon">🌱</div>
      <h3>Easy</h3>
      <p>Foundational concepts and definitions — perfect for first-time exposure to a topic or a quick recall check.</p>
    </div>
    <div class="level-card lc-medium reveal">
      <div class="level-icon">⚡</div>
      <h3>Medium</h3>
      <p>Applied knowledge and concept connections — tests whether you truly understand, not just memorize.</p>
    </div>
    <div class="level-card lc-hard reveal">
      <div class="level-icon">🔥</div>
      <h3>Hard</h3>
      <p>Complex analysis and edge cases — simulates real exam pressure to prepare you for the toughest questions.</p>
    </div>
  </div>
</section>

<!-- ADAPTIVE ENGINE -->
<section class="adaptive-section">
  <div class="adaptive-text">
    <p class="sec-label">Adaptive Engine</p>
    <h2>It gets <span>smarter</span><br>as you do</h2>
    <p>StudyGenie continuously tracks your responses and adjusts difficulty on the fly. Get questions right? It pushes harder. Struggle with a topic? It reinforces it until you master it.</p>
    <div class="adaptive-points">
      <div class="ap-item reveal">
        <div class="ap-check">✓</div>
        <p>Difficulty auto-adjusts after every answer</p>
      </div>
      <div class="ap-item reveal">
        <div class="ap-check">✓</div>
        <p>Weak areas are surfaced and reinforced automatically</p>
      </div>
      <div class="ap-item reveal">
        <div class="ap-check">✓</div>
        <p>Detailed explanations for every answer</p>
      </div>
      <div class="ap-item reveal">
        <div class="ap-check">✓</div>
        <p>Progress tracked across all sessions</p>
      </div>
    </div>
  </div>
  <div class="score-visual reveal">
    <p class="sv-title">📊 Your Progress Report</p>
    <div class="sv-bar-wrap">
      <div class="sv-bar-label"><span>Cell Biology</span><span>92%</span></div>
      <div class="sv-bar"><div class="sv-fill" style="width:92%"></div></div>
    </div>
    <div class="sv-bar-wrap">
      <div class="sv-bar-label"><span>Metabolism</span><span>74%</span></div>
      <div class="sv-bar"><div class="sv-fill" style="width:74%"></div></div>
    </div>
    <div class="sv-bar-wrap">
      <div class="sv-bar-label"><span>Genetics</span><span>55%</span></div>
      <div class="sv-bar"><div class="sv-fill" style="width:55%"></div></div>
    </div>
    <div class="sv-bar-wrap">
      <div class="sv-bar-label"><span>Biochemistry</span><span>38%</span></div>
      <div class="sv-bar"><div class="sv-fill" style="width:38%"></div></div>
    </div>
    <div class="sv-footer">
      <div class="svf-item"><div class="svf-num">47</div><div class="svf-label">Questions Today</div></div>
      <div class="svf-item"><div class="svf-num">82%</div><div class="svf-label">Accuracy</div></div>
      <div class="svf-item"><div class="svf-num">+12</div><div class="svf-label">Level Up</div></div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-section">
  <p class="sec-label">Process</p>
  <h2>How personalized quizzes work</h2>
  <div class="steps">
    <div class="step reveal">
      <div class="step-num">1</div>
      <h3>Set Your Level</h3>
      <p>Tell StudyGenie your comfort level with the topic, or let AI assess you with a short starter quiz.</p>
    </div>
    <div class="step reveal">
      <div class="step-num">2</div>
      <h3>Take the Quiz</h3>
      <p>Answer questions generated from your own study materials — multiple formats, real context.</p>
    </div>
    <div class="step reveal">
      <div class="step-num">3</div>
      <h3>AI Adapts & Repeats</h3>
      <p>Difficulty shifts in real time. Weak areas get more attention until you master them completely.</p>
    </div>
  </div>
</section>

<section class="cta">
  <h2>Knowledge gaps?<br>Not anymore.</h2>
  <p>Let StudyGenie's adaptive quizzes pinpoint exactly what you need to study — and get you there faster.</p>
  <button class="btn-white">Take Your First Quiz Free →</button>
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
