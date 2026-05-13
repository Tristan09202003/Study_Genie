@extends('app')

@section('title', 'Features – StudyGenie AI')

@push('styles')
<style>
:root {
  --text:   #0f172a;
  --muted:  #64748b;
  --border: #e8e8e8;
  --off:    #f9f9f9;
  --blue:   #3b82f6;
  --violet: #7c3aed;
}

/* ── PAGE HERO ─────────────────────────────── */
.features-hero {
  padding: 140px 6% 80px;
  text-align: center;
  background:
    radial-gradient(ellipse 60% 50% at 50% 0%, rgba(124,58,237,0.07) 0%, transparent 60%),
    #fff;
}
.fh-badge {
  display: inline-flex; align-items: center; gap: 0.5rem;
  background: #f5f3ff; border: 1px solid #ddd6fe;
  border-radius: 999px; padding: 0.4rem 1rem;
  font-size: 0.8rem; font-weight: 600; color: #7c3aed;
  margin-bottom: 1.5rem;
}
.features-hero h1 {
  font-family: 'Bricolage Grotesque', sans-serif;
  font-size: clamp(2.4rem, 5vw, 4rem);
  font-weight: 800; letter-spacing: -2px; line-height: 1.1;
  color: var(--text); margin-bottom: 1rem;
}
.features-hero p {
  font-size: 1.05rem; color: var(--muted);
  max-width: 520px; margin: 0 auto; line-height: 1.75;
}

/* ── FEATURES GRID ─────────────────────────── */
.features-list {
  padding: 60px 6% 100px;
  background: #fff;
}

.feature-row {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
  margin-bottom: 1.5rem;
}

.feat-item {
  padding: 2.2rem;
  border: 1.5px solid var(--border);
  border-radius: 16px;
  background: #fff;
  transition: border-color 0.25s, box-shadow 0.25s, transform 0.25s;
  text-decoration: none; color: inherit;
  display: block;
}
.feat-item:hover {
  border-color: #a78bfa;
  box-shadow: 0 12px 40px rgba(124,58,237,0.10);
  transform: translateY(-4px);
  background: #fdfcff;
}

/* Black SVG icon */
.feat-icon {
  width: 40px; height: 40px;
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.1rem;
}
.feat-icon svg {
  width: 28px; height: 28px;
  stroke: #0f172a; fill: none;
  stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round;
}

.feat-item h3 {
  font-family: 'Bricolage Grotesque', sans-serif;
  font-size: 1rem; font-weight: 700;
  color: var(--text); margin-bottom: 0.55rem;
}
.feat-item p {
  font-size: 0.84rem; color: var(--muted); line-height: 1.7;
}

/* ── CTA BOTTOM ────────────────────────────── */
.features-cta {
  text-align: center; padding: 80px 6%;
  background: linear-gradient(135deg, #3b82f6 0%, #7c3aed 60%, #0d9488 100%);
}
.features-cta h2 {
  font-family: 'Bricolage Grotesque', sans-serif;
  font-size: clamp(2rem, 4vw, 3rem);
  font-weight: 800; letter-spacing: -1.5px; color: #fff; margin-bottom: 1rem;
}
.features-cta p { color: rgba(255,255,255,0.8); max-width: 460px; margin: 0 auto 2.5rem; }
.btn-white {
  background: #fff; color: #7c3aed; border: none; border-radius: 12px;
  padding: 0.95rem 2.5rem; font-size: 1rem;
  font-family: 'Instrument Sans', sans-serif; font-weight: 700;
  cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;
  box-shadow: 0 6px 24px rgba(0,0,0,0.15); text-decoration: none; display: inline-block;
}
.btn-white:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(0,0,0,0.2); }

.reveal { opacity:0; transform:translateY(24px); transition:opacity 0.55s ease,transform 0.55s ease; }
.reveal.visible { opacity:1; transform:none; }

@media (max-width: 900px) {
  .feature-row { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 560px) {
  .feature-row { grid-template-columns: 1fr; }
  .features-hero { padding: 120px 4% 60px; }
  .features-list { padding: 40px 4% 80px; }
}
</style>
@endpush

@section('content')

{{-- PAGE HERO --}}
<section class="features-hero">
  <div class="fh-badge">🚀 Everything you need</div>
  <h1>Powerful features for<br>every type of learner</h1>
  <p>From raw notes to exam-ready — StudyGenie handles every step of the study process automatically.</p>
</section>

{{-- FEATURES GRID --}}
<div class="features-list">

  {{-- Row 1 --}}
  <div class="feature-row">

    <a href="/features/ai-study-materials" class="feat-item reveal">
      <div class="feat-icon">
        <svg viewBox="0 0 24 24"><path d="M9 12h6M9 16h6M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
      </div>
      <h3>AI Study Material Generator</h3>
      <p>Uses StudyGenie AI to generate comprehensive study materials automatically from any source.</p>
    </a>

    <a href="/features/personalized-quizzes" class="feat-item reveal">
      <div class="feat-icon">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17" stroke-width="2.5"/></svg>
      </div>
      <h3>Personalized Quizzes</h3>
      <p>Personalized quizzes based on difficulty level that adapt as your knowledge grows.</p>
    </a>

    <a href="/features/smart-notes" class="feat-item reveal">
      <div class="feat-icon">
        <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      </div>
      <h3>Smart Notes Converter</h3>
      <p>Turns raw notes into smart learning tools instantly — upload PDFs, photos, or voice memos.</p>
    </a>

  </div>

  {{-- Row 2 --}}
  <div class="feature-row">

    <a href="/features/flashcard-deck" class="feat-item reveal">
      <div class="feat-icon">
        <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
      </div>
      <h3>Smart Flashcard Deck (SRS)</h3>
      <p>Automatically generates cards with Spaced Repetition System logic for long-term retention.</p>
    </a>

    <a href="/features/mock-exams" class="feat-item reveal">
      <div class="feat-icon">
        <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
      </div>
      <h3>Adaptive Mock Exams</h3>
      <p>Quizzes that get harder as you get answers right, simulating real exam pressure.</p>
    </a>

    <a href="/features/tutor-mode" class="feat-item reveal">
      <div class="feat-icon">
        <svg viewBox="0 0 24 24"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg>
      </div>
      <h3>Voice-Over Tutor Mode</h3>
      <p>An AI voice that explains complex topics in simple, conversational language.</p>
    </a>

  </div>

  {{-- Row 3 --}}
  <div class="feature-row">

    <a href="/features/study-time-reminders" class="feat-item reveal">
      <div class="feat-icon">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><polyline points="12 6 12 12 16 14"/><path d="M12 3a9 9 0 0 0 9 9"/></svg>
      </div>
      <h3>Study Time Reminders</h3>
      <p>Smart notifications that help keep you on track with personalized study schedules and session reminders.</p>
    </a>

  </div>

</div>

{{-- CTA --}}
<section class="features-cta">
  <h2>Ready to study smarter?</h2>
  <p>Unlock unlimited features. Start learning in seconds.</p>
  <a href="#" class="btn-white">Get Started for Free</a>
</section>

@endsection

@push('scripts')
<script>
  const reveals = document.querySelectorAll('.reveal');
  const io = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => { if (e.isIntersecting) setTimeout(() => e.target.classList.add('visible'), i * 80); });
  }, { threshold: 0.08 });
  reveals.forEach(r => io.observe(r));
</script>
@endpush