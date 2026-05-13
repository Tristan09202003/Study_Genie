<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'StudyGenie AI – Your Cognitive Partner')</title>
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@400;600;700;800&family=Instrument+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  html { scroll-behavior: smooth; }
  body {
    font-family: 'Instrument Sans', sans-serif;
    background: #ffffff;
    color: #0f172a;
    overflow-x: hidden;
  }

  /* ── NAVBAR ─────────────────────────────────── */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 6%;
    background: rgba(255,255,255,0.93);
    backdrop-filter: blur(16px);
    border-bottom: 1px solid #e2e8f0;
    transition: box-shadow 0.3s;
  }
  nav.scrolled { box-shadow: 0 2px 20px rgba(0,0,0,0.08); }

  .logo {
    font-family: 'Bricolage Grotesque', sans-serif;
    font-size: 1.3rem; font-weight: 800;
    background: linear-gradient(135deg, #3b82f6, #7c3aed);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    text-decoration: none; letter-spacing: -0.5px;
  }

  .nav-links { display: flex; gap: 10rem; list-style: none; }
  .nav-links a {
    color: #000; text-decoration: none;
    font-size: 1.1rem; font-weight: 500; transition: color 0.2s;
  }
  .nav-links a:hover { color: #7c3aed; }

  .nav-right { display: flex; align-items: center; gap: 0.4rem; }

  /* Login button */
  .nav-login {
    display: flex; align-items: center; gap: 0.4rem;
    color: #0f172a; text-decoration: none;
    font-size: 0.88rem; font-weight: 500;
    padding: 0.5rem 1rem;
    border: 1.5px solid #e2e8f0; border-radius: 8px;
    transition: border-color 0.2s, color 0.2s;
  }
  .nav-login:hover { border-color: #7c3aed; color: #7c3aed; }
  .nav-login svg {
    width: 16px; height: 16px;
    stroke: currentColor; fill: none;
    stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round;
  }

  /* Premium button */
  .nav-premium {
    display: flex; align-items: center; gap: 0.5rem;
    background: linear-gradient(135deg, #fff7d5, #fed772);
    color: #78350f;
    border-radius: 9px;
    padding: 0.5rem 1rem;
    font-size: 0.88rem;
    font-family: 'Instrument Sans', sans-serif;
    font-weight: 700;
    cursor: pointer;
    transition: opacity 0.2s, transform 0.2s;
    text-decoration: none;
    border: 1px solid rgba(120,53,15,0.15);
    box-shadow: 0 2px 8px rgba(251,191,36,0.35);
    height: 34px;
    width: 160px;
  }
  .nav-premium:hover { border: 1px solid rgb(141, 117, 0); }

  /* Diamond emoji — centered */
  .nav-premium .diamond {
    font-style: normal;
    font-size: 1rem;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }

  .nav-toggle {
    display: none; flex-direction: column; gap: 5px;
    cursor: pointer; background: none; border: none; padding: 4px;
  }
  .nav-toggle span {
    display: block; width: 22px; height: 2px;
    background: #64748b; border-radius: 2px; transition: all 0.3s;
  }

  /* ── MODALS ─────────────────────────────────── */
  .modal-overlay {
    display: none; position: fixed; inset: 0; z-index: 999;
    background: rgba(15,23,42,0.5); backdrop-filter: blur(6px);
    align-items: center; justify-content: center;
  }
  .modal-overlay.open { display: flex; }

  .modal {
    background: #fff; border-radius: 24px;
    padding: 2.5rem; width: 100%; max-width: 440px;
    box-shadow: 0 24px 80px rgba(0,0,0,0.18);
    position: relative; animation: modalIn 0.3s ease;
  }
  @keyframes modalIn {
    from { opacity:0; transform:translateY(20px) scale(0.97); }
    to   { opacity:1; transform:none; }
  }

  .modal-close {
    position: absolute; top: 1.2rem; right: 1.2rem;
    background: #f1f5f9; border: none; border-radius: 8px;
    width: 32px; height: 32px; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; color: #64748b; transition: background 0.2s;
  }
  .modal-close:hover { background: #e2e8f0; }

  .modal-logo {
    font-family: 'Bricolage Grotesque', sans-serif;
    font-size: 1rem; font-weight: 800;
    background: linear-gradient(135deg, #3b82f6, #7c3aed);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    margin-bottom: 1.5rem; display: block;
  }

  .modal h2 {
    font-family: 'Bricolage Grotesque', sans-serif;
    font-size: 1.6rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 0.4rem;
  }
  .modal-sub { font-size: 0.88rem; color: #64748b; margin-bottom: 1.8rem; }

  .modal-form { display: flex; flex-direction: column; gap: 1rem; }
  .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
  .form-group label { font-size: 0.82rem; font-weight: 600; color: #0f172a; }
  .form-group input {
    padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0;
    border-radius: 10px; font-size: 0.9rem;
    font-family: 'Instrument Sans', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s; outline: none;
  }
  .form-group input:focus { border-color: #7c3aed; box-shadow: 0 0 0 3px rgba(124,58,237,0.1); }

  .modal-btn {
    background: linear-gradient(135deg, #3b82f6, #7c3aed);
    color: #fff; border: none; border-radius: 10px;
    padding: 0.85rem; font-size: 0.95rem;
    font-family: 'Instrument Sans', sans-serif; font-weight: 600;
    cursor: pointer; transition: opacity 0.2s, transform 0.2s;
    box-shadow: 0 4px 14px rgba(124,58,237,0.25); margin-top: 0.5rem;
  }
  .modal-btn:hover { opacity: 0.9; transform: translateY(-1px); }

  .modal-switch { font-size: 0.83rem; color: #64748b; text-align: center; margin-top: 1rem; }
  .modal-switch a { color: #7c3aed; font-weight: 600; text-decoration: none; cursor: pointer; }
  .modal-switch a:hover { text-decoration: underline; }

  .modal-divider { display: flex; align-items: center; gap: 1rem; margin: 0.5rem 0; }
  .modal-divider hr { flex: 1; border: none; border-top: 1px solid #e2e8f0; }
  .modal-divider span { font-size: 0.78rem; color: #94a3b8; }

  /* Premium Modal */
  .premium-modal .modal { max-width: 480px; }

  .premium-badge {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: linear-gradient(135deg, #fef3c7, #fde68a);
    border: 1px solid #f59e0b; border-radius: 999px;
    padding: 0.3rem 0.9rem; font-size: 0.78rem; font-weight: 700; color: #92400e;
    margin-bottom: 1rem;
  }

  .premium-plans {
    display: grid; grid-template-columns: 1fr 1fr;
    gap: 1rem; margin: 1.2rem 0;
  }
  .plan-card {
    border: 2px solid #e2e8f0; border-radius: 16px; padding: 1.4rem;
    cursor: pointer; transition: border-color 0.2s, box-shadow 0.2s; position: relative;
  }
  .plan-card:hover, .plan-card.active { border-color: #7c3aed; box-shadow: 0 6px 24px rgba(124,58,237,0.12); }
  .plan-card.popular { border-color: #7c3aed; background: linear-gradient(135deg, #faf5ff, #f5f3ff); }
  .plan-popular-tag {
    position: absolute; top: -10px; left: 50%; transform: translateX(-50%);
    background: linear-gradient(135deg, #7c3aed, #3b82f6);
    color: #fff; font-size: 0.68rem; font-weight: 700;
    padding: 0.2rem 0.7rem; border-radius: 999px; white-space: nowrap;
  }
  .plan-name { font-family: 'Bricolage Grotesque', sans-serif; font-size: 0.95rem; font-weight: 700; margin-bottom: 0.3rem; }
  .plan-price { font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.8rem; font-weight: 800; letter-spacing: -1px; color: #7c3aed; }
  .plan-price span { font-size: 0.8rem; font-weight: 500; color: #64748b; }
  .plan-features { list-style: none; margin-top: 0.8rem; display: flex; flex-direction: column; gap: 0.4rem; }
  .plan-features li { font-size: 0.78rem; color: #64748b; display: flex; align-items: center; gap: 0.4rem; }
  .plan-features li::before { content: '✓'; color: #7c3aed; font-weight: 700; flex-shrink: 0; }

  .premium-btn {
    width: 100%;
    background: linear-gradient(135deg, #fde68a, #fbbf24);
    color: #78350f; border: none; border-radius: 10px;
    padding: 0.85rem; font-size: 0.95rem;
    font-family: 'Instrument Sans', sans-serif; font-weight: 700;
    cursor: pointer; transition: opacity 0.2s, transform 0.2s;
    box-shadow: 0 4px 14px rgba(251,191,36,0.35); margin-top: 0.5rem;
  }
  .premium-btn:hover { opacity: 0.9; transform: translateY(-1px); }

  /* ── FOOTER ─────────────────────────────────── */
  footer { background: #0f172a; color: #e2e8f0; padding: 60px 6% 0; }
  .footer-top { display: flex; gap: 4rem; flex-wrap: wrap; padding-bottom: 3rem; border-bottom: 1px solid rgba(255,255,255,0.08); }
  .footer-brand { flex: 1; min-width: 220px; }
  .footer-brand .logo { font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.25rem; font-weight: 800; background: linear-gradient(135deg, #60a5fa, #a78bfa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-decoration: none; display: inline-block; margin-bottom: 0.8rem; }
  .footer-tagline { font-size: 0.88rem; color: #94a3b8; line-height: 1.7; max-width: 260px; }
  .footer-links { display: flex; gap: 3rem; flex-wrap: wrap; }
  .footer-col h4 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 0.85rem; font-weight: 700; color: #f1f5f9; margin-bottom: 1rem; letter-spacing: 0.03em; }
  .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 0.6rem; }
  .footer-col ul li a { color: #94a3b8; text-decoration: none; font-size: 0.85rem; transition: color 0.2s; }
  .footer-col ul li a:hover { color: #e2e8f0; }
  .footer-bottom { padding: 1.5rem 0; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem; }
  .footer-bottom p { color: #64748b; font-size: 0.8rem; }

  /* ── RESPONSIVE ─────────────────────────────── */
  @media (max-width: 768px) {
    .nav-links { display: none; }
    .nav-login span { display: none; }
    .nav-toggle { display: flex; }
    .nav-links.open {
      display: flex; flex-direction: column; gap: 0;
      position: fixed; top: 61px; left: 0; right: 0;
      background: #fff; border-bottom: 1px solid #e2e8f0;
      padding: 1rem 6%; box-shadow: 0 8px 24px rgba(0,0,0,0.08); z-index: 99;
    }
    .nav-links.open li { padding: 0.75rem 0; border-bottom: 1px solid #f1f5f9; }
    .nav-links.open li:last-child { border-bottom: none; }
    .footer-top { flex-direction: column; gap: 2.5rem; }
    .footer-links { gap: 2rem; }
    .footer-bottom { flex-direction: column; gap: 0.3rem; }
    .premium-plans { grid-template-columns: 1fr; }
  }
</style>

  @stack('styles')
</head>
<body>

  {{-- NAVBAR --}}
  <nav id="navbar">
    <a href="/" class="logo">🚀 StudyGenie AI</a>
    <ul class="nav-links">
      <li><a href="/">Home</a></li>
      <li><a href="/#goal">Goals</a></li>
      <li><a href="/contact">Contacts</a></li>
    </ul>
    <div class="nav-right">

      {{-- Login --}}
      <a href="#" class="nav-login" id="openLogin">
        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        <span>Log In</span>
      </a>

      {{-- Premium --}}
      <a href="#" class="nav-premium" id="openPremium">
        <span class="diamond">💎</span>Go Premium
      </a>

      <button class="nav-toggle" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </nav>

  {{-- LOGIN MODAL --}}
  <div class="modal-overlay" id="loginModal">
    <div class="modal">
      <button class="modal-close" id="closeLogin">✕</button>
      <span class="modal-logo">🚀 StudyGenie AI</span>
      <h2>Welcome back</h2>
      <p class="modal-sub">Log in to continue your learning journey.</p>
      <div class="modal-form">
        <div class="form-group">
          <label>Email address</label>
          <input type="email" placeholder="you@example.com"/>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" placeholder="••••••••"/>
        </div>
        <button class="modal-btn">Log In →</button>
      </div>
      <p class="modal-switch">Don't have an account? <a id="switchToSignup">Sign up free</a></p>
    </div>
  </div>

  {{-- SIGNUP MODAL --}}
  <div class="modal-overlay" id="signupModal">
    <div class="modal">
      <button class="modal-close" id="closeSignup">✕</button>
      <span class="modal-logo">🚀 StudyGenie AI</span>
      <h2>Create your account</h2>
      <p class="modal-sub">Start studying smarter — it's free.</p>
      <div class="modal-form">
        <div class="form-group">
          <label>Full name</label>
          <input type="text" placeholder="Juan dela Cruz"/>
        </div>
        <div class="form-group">
          <label>Email address</label>
          <input type="email" placeholder="you@example.com"/>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" placeholder="Min. 8 characters"/>
        </div>
        <button class="modal-btn">Create Account →</button>
      </div>
      <p class="modal-switch">Already have an account? <a id="switchToLogin">Log in</a></p>
    </div>
  </div>

  {{-- PREMIUM MODAL --}}
  <div class="modal-overlay premium-modal" id="premiumModal">
    <div class="modal">
      <button class="modal-close" id="closePremium">✕</button>
      <span class="modal-logo">🚀 StudyGenie AI</span>
      <div class="premium-badge">💎 Go Premium</div>
      <h2>Unlock everything</h2>
      <p class="modal-sub">Choose a plan and supercharge your studying today.</p>
      <div class="premium-plans">
        <div class="plan-card" onclick="selectPlan(this)">
          <div class="plan-name">Monthly</div>
          <div class="plan-price">₱99 <span>/ mo</span></div>
          <ul class="plan-features">
            <li>All 6 AI features</li>
            <li>Unlimited uploads</li>
            <li>Priority support</li>
          </ul>
        </div>
        <div class="plan-card popular active" onclick="selectPlan(this)">
          <div class="plan-popular-tag">Most Popular</div>
          <div class="plan-name">Annual</div>
          <div class="plan-price">₱1,100<span>/ year</span></div>
          <ul class="plan-features">
            <li>All 6 AI features</li>
            <li>Unlimited uploads</li>
            <li>Priority support</li>
            <li>Save 50%</li>
          </ul>
        </div>
      </div>
      <button class="premium-btn">💎 Upgrade to Premium</button>
    </div>
  </div>

  {{-- PAGE CONTENT --}}
  @yield('content')

  {{-- FOOTER --}}
  <footer>
    <div class="footer-top">
      <div class="footer-brand">
        <a href="/" class="logo">🚀 StudyGenie AI</a>
        <p class="footer-tagline">Your cognitive partner. Study smarter, never overwhelmed.</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© {{ date('Y') }} StudyGenie AI. All rights reserved.</p>
      <p>Built for students, everywhere. 🌍</p>
    </div>
  </footer>

  <script>
    // Navbar scroll shadow
    window.addEventListener('scroll', () => {
      document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 20);
    });

    // Mobile hamburger
    const toggle = document.querySelector('.nav-toggle');
    const links  = document.querySelector('.nav-links');
    if (toggle) toggle.addEventListener('click', () => links.classList.toggle('open'));

    // Modal helpers
    const openModal  = id => document.getElementById(id).classList.add('open');
    const closeModal = id => document.getElementById(id).classList.remove('open');

    // Close on overlay click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
      overlay.addEventListener('click', e => { if (e.target === overlay) overlay.classList.remove('open'); });
    });

    // Close on Escape
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape') document.querySelectorAll('.modal-overlay.open').forEach(m => m.classList.remove('open'));
    });

    // Login modal
    document.getElementById('openLogin').addEventListener('click', e => { e.preventDefault(); openModal('loginModal'); });
    document.getElementById('closeLogin').addEventListener('click', () => closeModal('loginModal'));

    // Signup modal
    document.getElementById('closeSignup').addEventListener('click', () => closeModal('signupModal'));

    // Premium modal
    document.getElementById('openPremium').addEventListener('click', e => { e.preventDefault(); openModal('premiumModal'); });
    document.getElementById('closePremium').addEventListener('click', () => closeModal('premiumModal'));

    // Switch between login & signup
    document.getElementById('switchToSignup').addEventListener('click', () => { closeModal('loginModal'); openModal('signupModal'); });
    document.getElementById('switchToLogin').addEventListener('click', () => { closeModal('signupModal'); openModal('loginModal'); });

    // Footer links
    document.getElementById('footerSignup').addEventListener('click', e => { e.preventDefault(); openModal('signupModal'); });
    document.getElementById('footerLogin').addEventListener('click', e => { e.preventDefault(); openModal('loginModal'); });

    // Plan selection
    function selectPlan(el) {
      document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('active'));
      el.classList.add('active');
    }
  </script>

  @stack('scripts')

</body>
</html>