@extends('app')

@push('styles')

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Voice-Over Tutor Mode – {{ $appName }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;600;700;800&family=Instrument+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --indigo:   #4338ca;
      --indigo-d: #3730a3;
      --indigo-l: #eef2ff;
      --indigo-m: #c7d2fe;
      --text:     #0f172a;
      --muted:    #64748b;
      --border:   #e2e8f0;
      --white:    #ffffff;
      --off:      #f8f7ff;
    }
    html { scroll-behavior: smooth; }
    body { font-family: 'Instrument Sans', sans-serif; background: var(--white); color: var(--text); overflow-x: hidden; }

    /* HERO */
    .hero {
      padding: 130px 6% 90px; text-align: center;
      background:
        radial-gradient(ellipse 70% 50% at 50% 0%, rgba(67,56,202,0.1) 0%, transparent 60%),
        radial-gradient(ellipse 40% 30% at 10% 80%, rgba(99,102,241,0.07) 0%, transparent 50%),
        #fff;
      position: relative;
    }
    .hero-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--indigo-l); border: 1px solid var(--indigo-m); border-radius: 999px; padding: 0.4rem 1rem; font-size: 0.8rem; font-weight: 600; color: var(--indigo); margin-bottom: 1.5rem; }
    .hero h1 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(2.8rem, 5.5vw, 4.5rem); font-weight: 800; letter-spacing: -2.5px; line-height: 1.05; margin-bottom: 1.2rem; max-width: 800px; margin-inline: auto; }
    .hero h1 span { background: linear-gradient(135deg, var(--indigo), #6366f1); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    .hero-sub { font-size: 1.1rem; color: var(--muted); line-height: 1.75; margin-bottom: 2.5rem; max-width: 560px; margin-inline: auto; }
    .btn-primary { background: linear-gradient(135deg, var(--indigo), var(--indigo-d)); color: #fff; border: none; border-radius: 12px; padding: 0.9rem 2rem; font-size: 1rem; font-family: 'Instrument Sans', sans-serif; font-weight: 600; cursor: pointer; box-shadow: 0 6px 24px rgba(67,56,202,0.35); transition: transform 0.2s, box-shadow 0.2s; }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(67,56,202,0.45); }

    /* AUDIO PLAYER */
    .player-section { padding: 60px 6%; background: var(--off); display: flex; justify-content: center; }
    .audio-player {
      background: #fff; border: 1.5px solid var(--border);
      border-radius: 28px; padding: 2.5rem; max-width: 680px; width: 100%;
      box-shadow: 0 20px 60px rgba(67,56,202,0.1);
      animation: floatUp 0.8s 0.2s ease both;
    }
    .ap-topic { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--indigo); margin-bottom: 0.5rem; }
    .ap-title { font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.2rem; font-weight: 700; margin-bottom: 1.5rem; }
    .ap-transcript {
      background: var(--indigo-l); border-radius: 16px; padding: 1.2rem 1.5rem;
      font-size: 0.88rem; color: var(--text); line-height: 1.8; margin-bottom: 1.5rem;
      border-left: 3px solid var(--indigo);
    }
    .ap-transcript .highlight { background: var(--indigo-m); border-radius: 4px; padding: 0.1rem 0.3rem; font-weight: 600; color: var(--indigo); }
    .ap-waveform { display: flex; align-items: center; gap: 3px; height: 40px; margin-bottom: 1.2rem; }
    .wave-bar { border-radius: 3px; background: var(--indigo-m); flex: 1; transition: background 0.2s; }
    .wave-bar.active { background: var(--indigo); }
    .ap-controls { display: flex; align-items: center; gap: 1rem; }
    .ap-play {
      width: 52px; height: 52px; border-radius: 50%;
      background: linear-gradient(135deg, var(--indigo), #6366f1);
      display: flex; align-items: center; justify-content: center;
      font-size: 1.2rem; cursor: pointer; border: none;
      box-shadow: 0 4px 16px rgba(67,56,202,0.3);
      transition: transform 0.2s;
    }
    .ap-play:hover { transform: scale(1.08); }
    .ap-progress { flex: 1; height: 6px; background: var(--border); border-radius: 3px; overflow: hidden; }
    .ap-progress-fill { height: 100%; width: 35%; background: linear-gradient(90deg, var(--indigo), #6366f1); border-radius: 3px; }
    .ap-time { font-size: 0.78rem; font-weight: 600; color: var(--muted); }
    .ap-speed { font-size: 0.75rem; font-weight: 700; color: var(--indigo); background: var(--indigo-l); border-radius: 6px; padding: 0.25rem 0.6rem; }

    /* FOR WHO */
    .who-section { padding: 90px 6%; background: #fff; }
    .who-section .sec-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--indigo); margin-bottom: 0.8rem; }
    .who-section h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(1.8rem, 3.5vw, 2.6rem); font-weight: 800; letter-spacing: -1.5px; margin-bottom: 3rem; }
    .who-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; }
    .who-card { border-radius: 20px; padding: 2rem; transition: transform 0.3s, box-shadow 0.3s; }
    .who-card:hover { transform: translateY(-5px); box-shadow: 0 16px 50px rgba(0,0,0,0.07); }
    .wc1 { background: var(--indigo-l); border: 1.5px solid var(--indigo-m); }
    .wc2 { background: #fff7ed; border: 1.5px solid #fed7aa; }
    .wc3 { background: #f0fdf4; border: 1.5px solid #bbf7d0; }
    .wc4 { background: #fef9c3; border: 1.5px solid #fef08a; }
    .who-icon { font-size: 2.2rem; margin-bottom: 1rem; }
    .who-card h3 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.05rem; font-weight: 700; margin-bottom: 0.5rem; }
    .who-card p { font-size: 0.86rem; color: var(--muted); line-height: 1.7; }

    /* HOW */
    .how-section { padding: 90px 6%; background: linear-gradient(135deg, rgba(67,56,202,0.04) 0%, rgba(55,48,163,0.06) 100%), var(--off); }
    .how-section .sec-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--indigo); margin-bottom: 0.8rem; }
    .how-section h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(1.8rem, 3.5vw, 2.5rem); font-weight: 800; letter-spacing: -1.5px; margin-bottom: 3rem; }
    .steps { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
    .step { background: #fff; border: 1.5px solid var(--border); border-radius: 20px; padding: 2.5rem 2rem; text-align: center; transition: border-color 0.3s, box-shadow 0.3s; }
    .step:hover { border-color: var(--indigo); box-shadow: 0 16px 50px rgba(67,56,202,0.1); }
    .step-num { width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, var(--indigo), var(--indigo-d)); color: #fff; font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.4rem; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 6px 20px rgba(67,56,202,0.3); }
    .step h3 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.05rem; font-weight: 700; margin-bottom: 0.6rem; }
    .step p { font-size: 0.88rem; color: var(--muted); line-height: 1.7; }

    /* FEATURES STRIP */
    .features-strip { padding: 80px 6%; background: #fff; }
    .features-strip .sec-label { font-size: 0.75rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--indigo); margin-bottom: 0.8rem; }
    .features-strip h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(1.8rem, 3.5vw, 2.5rem); font-weight: 800; letter-spacing: -1.5px; margin-bottom: 3rem; }
    .fs-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.2rem; }
    .fs-card { display: flex; align-items: flex-start; gap: 1rem; background: var(--off); border: 1.5px solid var(--border); border-radius: 16px; padding: 1.4rem; transition: border-color 0.3s, transform 0.3s; }
    .fs-card:hover { border-color: var(--indigo); transform: translateY(-3px); }
    .fs-icon { font-size: 1.5rem; flex-shrink: 0; }
    .fs-card h4 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 0.92rem; font-weight: 700; margin-bottom: 0.3rem; }
    .fs-card p { font-size: 0.82rem; color: var(--muted); line-height: 1.6; }

    .cta { padding: 100px 6%; text-align: center; background: linear-gradient(135deg, var(--indigo) 0%, #6366f1 100%); }
    .cta h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; letter-spacing: -1.5px; color: #fff; margin-bottom: 1rem; }
    .cta p { color: rgba(255,255,255,0.85); margin-bottom: 2.5rem; max-width: 460px; margin-inline: auto; margin-bottom: 2.5rem; }
    .btn-white { background: #fff; color: var(--indigo); border: none; border-radius: 12px; padding: 0.95rem 2.5rem; font-size: 1rem; font-family: 'Instrument Sans', sans-serif; font-weight: 700; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 6px 24px rgba(0,0,0,0.15); }
    .btn-white:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(0,0,0,0.2); }

    @keyframes fadeUp { from { opacity: 0; transform: translateY(28px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes floatUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
    .hero > * { animation: fadeUp 0.65s ease both; }
    .hero-badge { animation-delay: 0s; } .hero h1 { animation-delay: 0.1s; } .hero-sub { animation-delay: 0.2s; } .btn-primary { animation-delay: 0.3s; }
    .reveal { opacity: 0; transform: translateY(28px); transition: opacity 0.6s ease, transform 0.6s ease; }
    .reveal.visible { opacity: 1; transform: none; }
    @media (max-width: 900px) { .steps { grid-template-columns: 1fr; } .hero { padding: 110px 4% 60px; } .nav-links { display: none; } }
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
  <div class="hero-badge">🎙️ AI Voice Tutor</div>
  <h1>Your Personal Tutor.<br><span>Always On.</span></h1>
  <p class="hero-sub">An AI voice that explains complex topics in clear, conversational language — so you can learn while commuting, exercising, or anytime a screen isn't possible.</p>
  <button class="btn-primary">Listen to a Sample →</button>
</section>

<!-- AUDIO PLAYER -->
<div class="player-section">
  <div class="audio-player">
    <div class="ap-topic">Cell Biology — Mitochondria</div>
    <div class="ap-title">How ATP is produced in the mitochondria</div>
    <div class="ap-transcript">
      "Think of the <span class="highlight">mitochondria</span> as a tiny power station inside your cell. Its job is to take in fuel — like glucose — and convert it into a form of energy your body can actually use, called <span class="highlight">ATP</span>. This happens in three main stages: glycolysis, the Krebs cycle, and finally oxidative phosphorylation..."
    </div>
    <div class="ap-waveform">
      @for($i = 0; $i < 40; $i++)
        <div class="wave-bar {{ $i < 14 ? 'active' : '' }}" style="height: {{ rand(20, 90) }}%"></div>
      @endfor
    </div>
    <div class="ap-controls">
      <button class="ap-play">▶</button>
      <div class="ap-progress"><div class="ap-progress-fill"></div></div>
      <div class="ap-time">1:24 / 4:02</div>
      <div class="ap-speed">1.25x</div>
    </div>
  </div>
</div>

<!-- WHO IT'S FOR -->
<section class="who-section">
  <p class="sec-label">Who Benefits Most</p>
  <h2>Made for how you actually learn</h2>
  <div class="who-grid">
    <div class="who-card wc1 reveal">
      <div class="who-icon">👂</div>
      <h3>Auditory Learners</h3>
      <p>You retain information better when you hear it — Tutor Mode is your perfect match.</p>
    </div>
    <div class="who-card wc2 reveal">
      <div class="who-icon">🚌</div>
      <h3>On-The-Go Students</h3>
      <p>Study during your commute, gym session, or any time your hands and eyes are busy.</p>
    </div>
    <div class="who-card wc3 reveal">
      <div class="who-icon">😩</div>
      <h3>Screen-Fatigued Students</h3>
      <p>Give your eyes a break while still making study progress through audio explanations.</p>
    </div>
    <div class="who-card wc4 reveal">
      <div class="who-icon">📚</div>
      <h3>Complex Topic Learners</h3>
      <p>When reading doesn't click, hearing it explained conversationally often makes it land.</p>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-section">
  <p class="sec-label">Process</p>
  <h2>Hear it. Get it. Move on.</h2>
  <div class="steps">
    <div class="step reveal">
      <div class="step-num">1</div>
      <h3>Pick a Topic</h3>
      <p>Choose any concept from your study materials or search by topic name.</p>
    </div>
    <div class="step reveal">
      <div class="step-num">2</div>
      <h3>AI Explains It</h3>
      <p>Hear a clear, conversational breakdown in natural-sounding AI voice — no robotic text-to-speech.</p>
    </div>
    <div class="step reveal">
      <div class="step-num">3</div>
      <h3>Learn Anywhere</h3>
      <p>Listen on the go at your preferred speed. No screen required, no excuses.</p>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="features-strip">
  <p class="sec-label">All Features</p>
  <h2>Everything you'd expect from a real tutor</h2>
  <div class="fs-grid">
    <div class="fs-card reveal"><div class="fs-icon">🔊</div><div><h4>Natural AI Voice</h4><p>No robotic TTS — warm, conversational explanations</p></div></div>
    <div class="fs-card reveal"><div class="fs-icon">⏩</div><div><h4>Variable Speed</h4><p>0.75x to 2x playback — learn at your pace</p></div></div>
    <div class="fs-card reveal"><div class="fs-icon">📖</div><div><h4>Transcript Sync</h4><p>Follow along with highlighted text as it plays</p></div></div>
    <div class="fs-card reveal"><div class="fs-icon">🔖</div><div><h4>Bookmarks</h4><p>Mark key moments and revisit them instantly</p></div></div>
    <div class="fs-card reveal"><div class="fs-icon">📴</div><div><h4>Offline Mode</h4><p>Download explanations and listen without internet</p></div></div>
    <div class="fs-card reveal"><div class="fs-icon">🎧</div><div><h4>Earphone Optimized</h4><p>Balanced, clear audio designed for headphone use</p></div></div>
  </div>
</section>

<section class="cta">
  <h2>Learning doesn't stop<br>when you look up.</h2>
  <p>Use every spare moment to study — without burning out from screen time. Your AI tutor is always ready.</p>
  <button class="btn-white">Try Tutor Mode Free →</button>
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