@extends('app')

@push('styles')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Adaptive Mock Exams – {{ $appName }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;600;700;800&family=Instrument+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --rose:   #e11d48;
      --rose-d: #be123c;
      --rose-l: #fff1f2;
      --rose-m: #fecdd3;
      --text:   #0f172a;
      --muted:  #64748b;
      --border: #e2e8f0;
      --white:  #ffffff;
      --off:    #fff8f9;
    }
    html { scroll-behavior: smooth; }
    body { font-family: 'Instrument Sans', sans-serif; background: var(--white); color: var(--text); overflow-x: hidden; }


    /* HERO */
    .hero {
      padding: 130px 6% 90px;
      display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center;
      background:
        radial-gradient(ellipse 70% 60% at 0% 50%, rgba(225,29,72,0.07) 0%, transparent 55%),
        #fff;
    }
    .hero-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--rose-l); border: 1px solid var(--rose-m); border-radius: 999px; padding: 0.4rem 1rem; font-size: 0.8rem; font-weight: 600; color: var(--rose); margin-bottom: 1.5rem; }
    .hero h1 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(2.4rem, 4.5vw, 3.8rem); font-weight: 800; letter-spacing: -2px; line-height: 1.1; margin-bottom: 1.2rem; }
    .hero h1 span { background: linear-gradient(135deg, var(--rose), #f43f5e); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .hero-sub { font-size: 1.05rem; color: var(--muted); line-height: 1.75; margin-bottom: 2rem; }
    .btn-primary { background: linear-gradient(135deg, var(--rose), var(--rose-d)); color: #fff; border: none; border-radius: 12px; padding: 0.9rem 2rem; font-size: 1rem; font-family: 'Instrument Sans', sans-serif; font-weight: 600; cursor: pointer; box-shadow: 0 6px 24px rgba(225,29,72,0.35); transition: transform 0.2s, box-shadow 0.2s; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(225,29,72,0.45); }

    /* EXAM UI MOCK */
    .exam-mock {
      background: #fff; border: 1.5px solid var(--border);
      border-radius: 24px; overflow: hidden;
      box-shadow: 0 20px 60px rgba(225,29,72,0.1);
      animation: floatUp 0.8s 0.2s ease both;
    }
    .exam-header { background: linear-gradient(135deg, var(--rose), var(--rose-d)); padding: 1.2rem 1.5rem; display: flex; justify-content: space-between; align-items: center; }
    .exam-title { font-family: 'Bricolage Grotesque', sans-serif; font-size: 0.95rem; font-weight: 700; color: #fff; }
    .exam-timer { background: rgba(255,255,255,0.2); border-radius: 8px; padding: 0.3rem 0.8rem; font-size: 0.82rem; font-weight: 700; color: #fff; font-family: monospace; }
    .exam-progress { height: 4px; background: var(--rose-l); }
    .exam-progress-fill { height: 100%; width: 45%; background: var(--rose); }
    .exam-body { padding: 1.5rem; }
    .exam-q-meta { display: flex; justify-content: space-between; margin-bottom: 1rem; }
    .eq-num { font-size: 0.78rem; font-weight: 600; color: var(--muted); }
    .eq-diff { font-size: 0.72rem; font-weight: 700; background: #fef2f2; color: var(--rose); border-radius: 6px; padding: 0.2rem 0.6rem; }
    .exam-q { font-size: 0.92rem; font-weight: 600; margin-bottom: 1.2rem; line-height: 1.5; }
    .exam-opts { display: flex; flex-direction: column; gap: 0.5rem; }
    .exam-opt { border: 1.5px solid var(--border); border-radius: 10px; padding: 0.7rem 1rem; font-size: 0.82rem; cursor: pointer; transition: all 0.2s; font-family: 'Instrument Sans', sans-serif; }
    .exam-opt:hover { border-color: var(--rose); background: var(--rose-l); }
    .exam-opt.chosen { border-color: var(--rose); background: var(--rose-l); color: var(--rose); font-weight: 600; }


    /* RESULTS SECTION */
    .results-section { padding: 90px 6%; background: #fff; display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; }
    .results-text .sec-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--rose); margin-bottom: 0.8rem; }
    .results-text h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(1.8rem, 3.5vw, 2.6rem); font-weight: 800; letter-spacing: -1.5px; margin-bottom: 1rem; }
    .results-text h2 span { color: var(--rose); }
    .results-text p { color: var(--muted); line-height: 1.8; font-size: 0.95rem; }
    .result-card { background: var(--off); border: 1.5px solid var(--border); border-radius: 24px; padding: 2rem; box-shadow: 0 12px 40px rgba(225,29,72,0.06); }
    .rc-header { display: flex; justify-content: space-between; margin-bottom: 1.5rem; }
    .rc-score { font-family: 'Bricolage Grotesque', sans-serif; font-size: 2.8rem; font-weight: 800; background: linear-gradient(135deg, var(--rose), #f43f5e); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .rc-grade { background: #fee2e2; color: var(--rose); font-weight: 700; font-size: 0.9rem; padding: 0.3rem 0.8rem; border-radius: 8px; align-self: flex-start; }
    .rc-breakdown { display: flex; flex-direction: column; gap: 0.7rem; }
    .rcb-row { display: flex; justify-content: space-between; align-items: center; padding: 0.6rem 0; border-bottom: 1px solid var(--border); }
    .rcb-row:last-child { border-bottom: none; }
    .rcb-topic { font-size: 0.82rem; font-weight: 500; }
    .rcb-bar { width: 80px; height: 6px; background: var(--border); border-radius: 3px; overflow: hidden; }
    .rcb-fill { height: 100%; border-radius: 3px; background: linear-gradient(90deg, var(--rose), #f43f5e); }
    .rcb-pct { font-size: 0.78rem; font-weight: 700; color: var(--rose); width: 35px; text-align: right; }

    /* HOW */
    .how-section { padding: 90px 6%; background: linear-gradient(135deg, rgba(225,29,72,0.04) 0%, rgba(190,18,60,0.06) 100%), var(--off); }
    .how-section .sec-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--rose); margin-bottom: 0.8rem; }
    .how-section h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(1.8rem, 3.5vw, 2.5rem); font-weight: 800; letter-spacing: -1.5px; margin-bottom: 3rem; }
    .steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
    .step { background: #fff; border: 1.5px solid var(--border); border-radius: 20px; padding: 2.5rem 2rem; text-align: center; transition: border-color 0.3s, box-shadow 0.3s; }
    .step:hover { border-color: var(--rose); box-shadow: 0 16px 50px rgba(225,29,72,0.1); }
    .step-num { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, var(--rose), var(--rose-d)); color: #fff; font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.4rem; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 6px 20px rgba(225,29,72,0.3); }
    .step h3 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.05rem; font-weight: 700; margin-bottom: 0.6rem; }
    .step p { font-size: 0.88rem; color: var(--muted); line-height: 1.7; }

    .cta { padding: 100px 6%; text-align: center; background: linear-gradient(135deg, var(--rose) 0%, var(--rose-d) 100%); }
    .cta h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; letter-spacing: -1.5px; color: #fff; margin-bottom: 1rem; }
    .cta p { color: rgba(255,255,255,0.85); margin-bottom: 2.5rem; max-width: 460px; margin-inline: auto; margin-bottom: 2.5rem; }
    .btn-white { background: #fff; color: var(--rose); border: none; border-radius: 12px; padding: 0.95rem 2.5rem; font-size: 1rem; font-family: 'Instrument Sans', sans-serif; font-weight: 700; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 6px 24px rgba(0,0,0,0.15); }
    .btn-white:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(0,0,0,0.2); }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes floatUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
    .hero-left > * { animation: fadeUp 0.65s ease both; }
    .hero-badge { animation-delay: 0s; } .hero h1 { animation-delay: 0.1s; } .hero-sub { animation-delay: 0.2s; } .btn-primary { animation-delay: 0.3s; }
    .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .reveal.visible { opacity: 1; transform: none; }
    @media (max-width: 900px) { .hero, .results-section { grid-template-columns: 1fr; gap: 3rem; } .steps { grid-template-columns: 1fr; } .hero { padding: 110px 4% 60px; } .nav-links { display: none; } }
  </style>
</head>
<body>

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
  <div class="hero-left">
    <div class="hero-badge">📊 Adaptive Testing</div>
    <h1>Train Hard.<br><span>Exam Easy.</span></h1>
    <p class="hero-sub">Adaptive mock exams that increase in difficulty as you perform — simulating real exam pressure so you're always prepared for the toughest questions.</p>
    <button class="btn-primary">Start a Mock Exam →</button>
  </div>
  <div class="exam-mock reveal">
    <div class="exam-header">
      <div class="exam-title">📊 Biology — Final Exam Simulation</div>
      <div class="exam-timer">⏱ 23:41</div>
    </div>
    <div class="exam-progress"><div class="exam-progress-fill"></div></div>
    <div class="exam-body">
      <div class="exam-q-meta">
        <div class="eq-num">Question 9 of 20</div>
        <div class="eq-diff">🔥 Hard</div>
      </div>
      <div class="exam-q">During oxidative phosphorylation, the proton gradient drives ATP synthesis via which mechanism?</div>
      <div class="exam-opts">
        <div class="exam-opt">Substrate-level phosphorylation</div>
        <div class="exam-opt chosen">Chemiosmosis through ATP synthase</div>
        <div class="exam-opt">Direct phosphate transfer from NADH</div>
        <div class="exam-opt">Photophosphorylation</div>
      </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-section">
  <p class="sec-label">Process</p>
  <h2>Three steps to exam confidence</h2>
  <div class="steps">
    <div class="step reveal">
      <div class="step-num">1</div>
      <h3>Choose Your Exam</h3>
      <p>Pick a topic or let AI build a comprehensive exam from all your uploaded materials.</p>
    </div>
    <div class="step reveal">
      <div class="step-num">2</div>
      <h3>Sit the Mock Exam</h3>
      <p>Timed, adaptive, pressure-tested questions. Just like the real thing — or harder.</p>
    </div>
    <div class="step reveal">
      <div class="step-num">3</div>
      <h3>Review & Improve</h3>
      <p>Get a detailed breakdown of gaps and a targeted study plan to close them fast.</p>
    </div>
  </div>
</section>


<!-- RESULTS -->
<section class="results-section">
  <div class="results-text">
    <p class="sec-label">Post-Exam Insights</p>
    <h2>Know exactly <span>what to fix</span></h2>
    <p>After every mock exam, StudyGenie gives you a detailed breakdown — topic by topic — so you can go straight to what matters instead of re-reading everything.</p>
  </div>
  <div class="result-card reveal">
    <div class="rc-header">
      <div class="rc-score">78%</div>
      <div class="rc-grade">B+ Grade</div>
    </div>
    <div class="rc-breakdown">
      <div class="rcb-row">
        <div class="rcb-topic">Cell Biology</div>
        <div class="rcb-bar"><div class="rcb-fill" style="width:95%"></div></div>
        <div class="rcb-pct">95%</div>
      </div>
      <div class="rcb-row">
        <div class="rcb-topic">Metabolism</div>
        <div class="rcb-bar"><div class="rcb-fill" style="width:80%"></div></div>
        <div class="rcb-pct">80%</div>
      </div>
      <div class="rcb-row">
        <div class="rcb-topic">Genetics</div>
        <div class="rcb-bar"><div class="rcb-fill" style="width:62%"></div></div>
        <div class="rcb-pct">62%</div>
      </div>
      <div class="rcb-row">
        <div class="rcb-topic">Biochemistry</div>
        <div class="rcb-bar"><div class="rcb-fill" style="width:44%"></div></div>
        <div class="rcb-pct">44% ⚠️</div>
      </div>
    </div>
  </div>
</section>

<section class="cta">
  <h2>No more exam day<br>surprises.</h2>
  <p>Simulate the toughest exam conditions before they're real — and walk in knowing you're ready.</p>
  <button class="btn-white">Start Your First Mock Exam</button>
</section>

<script>
  const reveals = document.querySelectorAll('.reveal');
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => { if (e.isIntersecting) setTimeout(() => e.target.classList.add('visible'), i * 90); });
  }, { threshold: 0.08 });
  reveals.forEach(r => io.observe(r));
</script>
</body>
</html>