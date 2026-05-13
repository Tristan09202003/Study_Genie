@extends('app')

@section('title', 'StudyGenie AI – Your Cognitive Partner')

@push('styles')
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
  .nav-premium .diamond { font-style: normal; font-size: 1rem; line-height: 1; display: inline-flex; align-items: center; justify-content: center; }

  .nav-toggle {
    display: none; flex-direction: column; gap: 5px;
    cursor: pointer; background: none; border: none; padding: 4px;
  }
  .nav-toggle span { display: block; width: 22px; height: 2px; background: #64748b; border-radius: 2px; transition: all 0.3s; }

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
  .modal-logo { font-family: 'Bricolage Grotesque', sans-serif; font-size: 1rem; font-weight: 800; background: linear-gradient(135deg, #3b82f6, #7c3aed); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 1.5rem; display: block; }
  .modal h2 { font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.6rem; font-weight: 800; letter-spacing: -1px; margin-bottom: 0.4rem; }
  .modal-sub { font-size: 0.88rem; color: #64748b; margin-bottom: 1.8rem; }
  .modal-form { display: flex; flex-direction: column; gap: 1rem; }
  .form-group { display: flex; flex-direction: column; gap: 0.4rem; }
  .form-group label { font-size: 0.82rem; font-weight: 600; color: #0f172a; }
  .form-group input { padding: 0.75rem 1rem; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 0.9rem; font-family: 'Instrument Sans', sans-serif; transition: border-color 0.2s, box-shadow 0.2s; outline: none; }
  .form-group input:focus { border-color: #7c3aed; box-shadow: 0 0 0 3px rgba(124,58,237,0.1); }
  .modal-btn { background: linear-gradient(135deg, #3b82f6, #7c3aed); color: #fff; border: none; border-radius: 10px; padding: 0.85rem; font-size: 0.95rem; font-family: 'Instrument Sans', sans-serif; font-weight: 600; cursor: pointer; transition: opacity 0.2s, transform 0.2s; box-shadow: 0 4px 14px rgba(124,58,237,0.25); margin-top: 0.5rem; }
  .modal-btn:hover { opacity: 0.9; transform: translateY(-1px); }
  .modal-switch { font-size: 0.83rem; color: #64748b; text-align: center; margin-top: 1rem; }
  .modal-switch a { color: #7c3aed; font-weight: 600; text-decoration: none; cursor: pointer; }
  .modal-switch a:hover { text-decoration: underline; }
  .modal-divider { display: flex; align-items: center; gap: 1rem; margin: 0.5rem 0; }
  .modal-divider hr { flex: 1; border: none; border-top: 1px solid #e2e8f0; }
  .modal-divider span { font-size: 0.78rem; color: #94a3b8; }
  .premium-modal .modal { max-width: 480px; }
  .premium-badge { display: inline-flex; align-items: center; gap: 0.4rem; background: linear-gradient(135deg, #fef3c7, #fde68a); border: 1px solid #f59e0b; border-radius: 999px; padding: 0.3rem 0.9rem; font-size: 0.78rem; font-weight: 700; color: #92400e; margin-bottom: 1rem; }
  .premium-plans { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin: 1.2rem 0; }
  .plan-card { border: 2px solid #e2e8f0; border-radius: 16px; padding: 1.4rem; cursor: pointer; transition: border-color 0.2s, box-shadow 0.2s; position: relative; }
  .plan-card:hover, .plan-card.active { border-color: #7c3aed; box-shadow: 0 6px 24px rgba(124,58,237,0.12); }
  .plan-card.popular { border-color: #7c3aed; background: linear-gradient(135deg, #faf5ff, #f5f3ff); }
  .plan-popular-tag { position: absolute; top: -10px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #7c3aed, #3b82f6); color: #fff; font-size: 0.68rem; font-weight: 700; padding: 0.2rem 0.7rem; border-radius: 999px; white-space: nowrap; }
  .plan-name { font-family: 'Bricolage Grotesque', sans-serif; font-size: 0.95rem; font-weight: 700; margin-bottom: 0.3rem; }
  .plan-price { font-family: 'Bricolage Grotesque', sans-serif; font-size: 1.8rem; font-weight: 800; letter-spacing: -1px; color: #7c3aed; }
  .plan-price span { font-size: 0.8rem; font-weight: 500; color: #64748b; }
  .plan-features { list-style: none; margin-top: 0.8rem; display: flex; flex-direction: column; gap: 0.4rem; }
  .plan-features li { font-size: 0.78rem; color: #64748b; display: flex; align-items: center; gap: 0.4rem; }
  .plan-features li::before { content: '✓'; color: #7c3aed; font-weight: 700; flex-shrink: 0; }
  .premium-btn { width: 100%; background: linear-gradient(135deg, #fde68a, #fbbf24); color: #78350f; border: none; border-radius: 10px; padding: 0.85rem; font-size: 0.95rem; font-family: 'Instrument Sans', sans-serif; font-weight: 700; cursor: pointer; transition: opacity 0.2s, transform 0.2s; box-shadow: 0 4px 14px rgba(251,191,36,0.35); margin-top: 0.5rem; }
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

  /* ── CONTACT PAGE ───────────────────────────── */
  .contact-hero {
    padding: 140px 6% 60px;
    background: linear-gradient(160deg, #f8f5ff 0%, #eef2ff 50%, #fff 100%);
    text-align: center;
  }
  .contact-hero-badge {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: rgba(124,58,237,0.08); border: 1px solid rgba(124,58,237,0.2);
    border-radius: 999px; padding: 0.35rem 1rem;
    font-size: 0.78rem; font-weight: 600; color: #7c3aed;
    margin-bottom: 1.4rem; letter-spacing: 0.04em; text-transform: uppercase;
  }
  .contact-hero h1 {
    font-family: 'Bricolage Grotesque', sans-serif;
    font-size: clamp(2.2rem, 5vw, 3.4rem); font-weight: 800;
    letter-spacing: -2px; line-height: 1.1;
    color: #0f172a; margin-bottom: 1rem;
  }
  .contact-hero h1 span {
    background: linear-gradient(135deg, #3b82f6, #7c3aed);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  }
  .contact-hero p { font-size: 1.05rem; color: #64748b; max-width: 520px; margin: 0 auto; line-height: 1.7; }

  /* ── CONTACT LAYOUT ─────────────────────────── */
  .contact-body {
    display: grid;
    grid-template-columns: 1fr 1.4fr;
    gap: 2.5rem;
    max-width: 1160px;
    margin: 0 auto;
    padding: 60px 6% 80px;
    align-items: start;
  }

  /* ── CONTACT INFO CARD ──────────────────────── */
  .contact-info-card {
    background: #0f172a;
    border-radius: 24px;
    padding: 2.5rem;
    color: #e2e8f0;
    position: sticky;
    top: 90px;
  }
  .contact-info-card h3 {
    font-family: 'Bricolage Grotesque', sans-serif;
    font-size: 1.4rem; font-weight: 800; letter-spacing: -0.5px;
    margin-bottom: 0.4rem; color: #fff;
  }
  .contact-info-card > p { font-size: 0.88rem; color: #94a3b8; line-height: 1.7; margin-bottom: 2rem; }

  .contact-detail {
    display: flex; align-items: flex-start; gap: 1rem;
    margin-bottom: 1.5rem;
  }
  .contact-detail-icon {
    width: 40px; height: 40px; flex-shrink: 0;
    background: rgba(124,58,237,0.2); border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
  }
  .contact-detail-text label {
    display: block; font-size: 0.72rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: #7c3aed; margin-bottom: 0.2rem;
  }
  .contact-detail-text a,
  .contact-detail-text span {
    font-size: 0.9rem; color: #cbd5e1; text-decoration: none;
    line-height: 1.5;
  }
  .contact-detail-text a:hover { color: #fff; text-decoration: underline; }

  .contact-divider { border: none; border-top: 1px solid rgba(255,255,255,0.08); margin: 1.5rem 0; }

  .contact-socials { display: flex; gap: 0.75rem; margin-top: 0.5rem; }
  .social-btn {
    display: flex; align-items: center; gap: 0.5rem;
    background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1);
    border-radius: 8px; padding: 0.5rem 0.85rem;
    color: #cbd5e1; text-decoration: none; font-size: 0.8rem; font-weight: 500;
    transition: background 0.2s, border-color 0.2s, color 0.2s;
  }
  .social-btn:hover { background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.3); color: #fff; }
  .social-btn svg { width: 18px; height: 18px; flex-shrink: 0; }

  .contact-hours {
    background: rgba(59,130,246,0.1); border: 1px solid rgba(59,130,246,0.2);
    border-radius: 12px; padding: 1rem 1.2rem; margin-top: 1.5rem;
  }
  .contact-hours p { font-size: 0.8rem; color: #93c5fd; line-height: 1.6; }
  .contact-hours strong { color: #bfdbfe; }

  /* ── CHATBOT + EMAIL SECTION ────────────────── */
  .contact-right { display: flex; flex-direction: column; gap: 2rem; }

  /* Chatbot */
  .chatbot-card {
    background: #fff; border: 1.5px solid #e2e8f0;
    border-radius: 24px; overflow: hidden;
    box-shadow: 0 8px 40px rgba(0,0,0,0.06);
  }
  .chatbot-header {
    background: linear-gradient(135deg, #3b82f6, #7c3aed);
    padding: 1.2rem 1.5rem;
    display: flex; align-items: center; gap: 0.9rem;
  }
  .chatbot-avatar {
    width: 40px; height: 40px; border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; flex-shrink: 0;
  }
  .chatbot-header-text h4 {
    font-family: 'Bricolage Grotesque', sans-serif;
    font-size: 1rem; font-weight: 700; color: #fff; margin-bottom: 0.1rem;
  }
  .chatbot-header-text span { font-size: 0.75rem; color: rgba(255,255,255,0.75); }
  .chatbot-online {
    margin-left: auto;
    display: flex; align-items: center; gap: 0.35rem;
    font-size: 0.72rem; color: rgba(255,255,255,0.8);
  }
  .chatbot-online::before {
    content: ''; width: 8px; height: 8px; border-radius: 50%;
    background: #4ade80; box-shadow: 0 0 0 2px rgba(74,222,128,0.3);
    animation: pulse-green 2s infinite;
  }
  @keyframes pulse-green { 0%,100% { box-shadow: 0 0 0 2px rgba(74,222,128,0.3); } 50% { box-shadow: 0 0 0 5px rgba(74,222,128,0); } }

  .chatbot-messages {
    height: 340px; overflow-y: auto;
    padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem;
    background: #f8fafc;
    scroll-behavior: smooth;
  }
  .chatbot-messages::-webkit-scrollbar { width: 4px; }
  .chatbot-messages::-webkit-scrollbar-track { background: transparent; }
  .chatbot-messages::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 2px; }

  .msg { display: flex; gap: 0.7rem; align-items: flex-end; }
  .msg.user { flex-direction: row-reverse; }

  .msg-avatar {
    width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem;
    background: linear-gradient(135deg, #3b82f6, #7c3aed);
    color: #fff;
  }
  .msg.user .msg-avatar { background: linear-gradient(135deg, #e2e8f0, #cbd5e1); color: #64748b; }

  .msg-bubble {
    max-width: 75%; padding: 0.75rem 1rem;
    border-radius: 16px; font-size: 0.875rem; line-height: 1.6; color: #0f172a;
    background: #fff; border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    animation: bubbleIn 0.25s ease;
  }
  .msg.user .msg-bubble {
    background: linear-gradient(135deg, #3b82f6, #7c3aed);
    color: #fff; border: none;
  }
  @keyframes bubbleIn { from { opacity:0; transform: translateY(6px); } to { opacity:1; transform:none; } }

  .msg-time { font-size: 0.65rem; color: #94a3b8; margin-top: 0.2rem; text-align: right; }
  .msg.bot .msg-time { text-align: left; }

  /* Quick reply chips */
  .quick-chips { display: flex; flex-wrap: wrap; gap: 0.5rem; padding: 0 1.5rem 0.5rem; }
  .chip {
    background: #f1f5f9; border: 1.5px solid #e2e8f0;
    border-radius: 999px; padding: 0.35rem 0.85rem;
    font-size: 0.75rem; font-weight: 500; color: #334155;
    cursor: pointer; transition: all 0.2s;
  }
  .chip:hover { background: #ede9fe; border-color: #7c3aed; color: #7c3aed; }

  /* Chatbot input */
  .chatbot-input {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 1rem 1.2rem; border-top: 1px solid #e2e8f0;
    background: #fff;
  }
  .chatbot-input input {
    flex: 1; border: 1.5px solid #e2e8f0; border-radius: 999px;
    padding: 0.65rem 1.1rem; font-size: 0.875rem;
    font-family: 'Instrument Sans', sans-serif;
    outline: none; transition: border-color 0.2s, box-shadow 0.2s;
  }
  .chatbot-input input:focus { border-color: #7c3aed; box-shadow: 0 0 0 3px rgba(124,58,237,0.08); }
  .chatbot-send {
    width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #3b82f6, #7c3aed);
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: opacity 0.2s, transform 0.2s;
  }
  .chatbot-send:hover { opacity: 0.85; transform: scale(1.05); }
  .chatbot-send svg { width: 16px; height: 16px; fill: none; stroke: #fff; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

  /* Typing indicator */
  .typing { display: flex; gap: 0.7rem; align-items: flex-end; }
  .typing .msg-bubble { padding: 0.75rem 1rem; }
  .typing-dots { display: flex; gap: 4px; align-items: center; }
  .typing-dots span {
    width: 7px; height: 7px; border-radius: 50%; background: #94a3b8;
    animation: dot-bounce 1.2s infinite;
  }
  .typing-dots span:nth-child(2) { animation-delay: 0.2s; }
  .typing-dots span:nth-child(3) { animation-delay: 0.4s; }
  @keyframes dot-bounce { 0%,60%,100% { transform: translateY(0); } 30% { transform: translateY(-6px); } }

  /* ── EMAIL FORM ──────────────────────────────── */
  .email-card {
    background: #fff; border: 1.5px solid #e2e8f0;
    border-radius: 24px; padding: 2rem;
    box-shadow: 0 8px 40px rgba(0,0,0,0.05);
  }
  .email-card-header { display: flex; align-items: center; gap: 0.85rem; margin-bottom: 0.5rem; }
  .email-card-icon {
    width: 44px; height: 44px; border-radius: 12px;
    background: linear-gradient(135deg, #ede9fe, #dbeafe);
    display: flex; align-items: center; justify-content: center; font-size: 1.3rem;
  }
  .email-card-header h3 {
    font-family: 'Bricolage Grotesque', sans-serif;
    font-size: 1.2rem; font-weight: 800; letter-spacing: -0.4px;
  }
  .email-card > p { font-size: 0.85rem; color: #64748b; margin-bottom: 1.5rem; line-height: 1.6; }

  .email-form { display: flex; flex-direction: column; gap: 1rem; }
  .email-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
  .ef-group { display: flex; flex-direction: column; gap: 0.35rem; }
  .ef-group label { font-size: 0.78rem; font-weight: 600; color: #0f172a; }
  .ef-group input,
  .ef-group select,
  .ef-group textarea {
    padding: 0.7rem 1rem; border: 1.5px solid #e2e8f0;
    border-radius: 10px; font-size: 0.875rem;
    font-family: 'Instrument Sans', sans-serif;
    transition: border-color 0.2s, box-shadow 0.2s; outline: none;
    color: #0f172a; background: #fff;
  }
  .ef-group input:focus,
  .ef-group select:focus,
  .ef-group textarea:focus { border-color: #7c3aed; box-shadow: 0 0 0 3px rgba(124,58,237,0.08); }
  .ef-group textarea { resize: vertical; min-height: 110px; line-height: 1.6; }

  .ef-submit {
    background: linear-gradient(135deg, #3b82f6, #7c3aed);
    color: #fff; border: none; border-radius: 12px;
    padding: 0.9rem 2rem; font-size: 0.95rem;
    font-family: 'Instrument Sans', sans-serif; font-weight: 600;
    cursor: pointer; transition: opacity 0.2s, transform 0.2s;
    box-shadow: 0 4px 14px rgba(124,58,237,0.25);
    display: flex; align-items: center; gap: 0.5rem;
  }
  .ef-submit:hover { opacity: 0.9; transform: translateY(-1px); }

  .ef-success {
    display: none; align-items: center; gap: 0.75rem;
    background: #f0fdf4; border: 1.5px solid #bbf7d0;
    border-radius: 12px; padding: 1rem 1.2rem;
    font-size: 0.875rem; color: #166534;
  }
  .ef-success.show { display: flex; }

  /* ── RESPONSIVE ─────────────────────────────── */
  @media (max-width: 900px) {
    .contact-body { grid-template-columns: 1fr; }
    .contact-info-card { position: static; }
  }
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
    .email-form-row { grid-template-columns: 1fr; }
  }
</style>
</head>
<body>

  <!-- ── CONTACT PAGE CONTENT ── -->

  <!-- Hero -->
  <section class="contact-hero" id="contact">
    <div class="contact-hero-badge">📬 Get in Touch</div>
    <h1>We're here to <span>help you</span> succeed</h1>
    <p>Have a question? Our Genie chatbot answers instantly — or send us a message and we'll get back to you within 24 hours.</p>
  </section>

  <!-- Body -->
  <div class="contact-body">

    <!-- LEFT: Contact Info -->
    <div class="contact-info-card">
      <h3>Contact Details</h3>
      <p>Reach us through any of these channels. We're a small team that genuinely cares.</p>

      <div class="contact-detail">
        <div class="contact-detail-icon">📧</div>
        <div class="contact-detail-text">
          <label>Email</label>
          <a href="mailto:hello@studygenie.ai">hello@studygenie.ai</a>
        </div>
      </div>

      <div class="contact-detail">
        <div class="contact-detail-icon">💬</div>
        <div class="contact-detail-text">
          <label>Support</label>
          <a href="mailto:support@studygenie.ai">support@studygenie.ai</a>
        </div>
      </div>

      <div class="contact-detail">
        <div class="contact-detail-icon">📍</div>
        <div class="contact-detail-text">
          <label>Location</label>
          <span>Tomas Oppus,Southern Leyte, Philippines</span>
        </div>
      </div>

      <div class="contact-detail">
        <div class="contact-detail-icon">📱</div>
        <div class="contact-detail-text">
          <label>Phone / Viber</label>
          <a href="tel:+639123456789">+63 912 345 6789</a>
        </div>
      </div>

      <hr class="contact-divider"/>

      <p style="font-size:0.78rem;color:#64748b;margin-bottom:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;">Follow Us</p>
      <div class="contact-socials">
        <!-- Twitter / X -->
        <a href="#" class="social-btn" title="Twitter / X">
          <svg viewBox="0 0 24 24" fill="#000000" xmlns="http://www.w3.org/2000/svg" style="background:#fff;border-radius:4px;padding:1px;width:18px;height:18px;flex-shrink:0;">
            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.746l7.73-8.835L1.254 2.25H8.08l4.253 5.622L18.244 2.25zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77z"/>
          </svg>
         Twitter
        </a>
        <!-- Facebook -->
        <a href="#" class="social-btn" title="Facebook">
          <svg viewBox="0 0 24 24" fill="#1877F2" xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;flex-shrink:0;">
            <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.874v2.25h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/>
          </svg>
          Facebook
        </a>
        <!-- Instagram -->
        <a href="#" class="social-btn" title="Instagram">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px;flex-shrink:0;">
            <defs>
              <linearGradient id="ig-grad" x1="0%" y1="100%" x2="100%" y2="0%">
                <stop offset="0%" style="stop-color:#FFDC80"/>
                <stop offset="25%" style="stop-color:#FCAF45"/>
                <stop offset="50%" style="stop-color:#F77737"/>
                <stop offset="75%" style="stop-color:#C13584"/>
                <stop offset="100%" style="stop-color:#833AB4"/>
              </linearGradient>
            </defs>
            <path fill="url(#ig-grad)" d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.336 3.608 1.311.975.975 1.249 2.242 1.311 3.608.058 1.266.069 1.646.069 4.85s-.012 3.584-.07 4.85c-.062 1.366-.336 2.633-1.311 3.608-.975.975-2.242 1.249-3.608 1.311-1.266.058-1.646.069-4.85.069s-3.584-.012-4.85-.07c-1.366-.062-2.633-.336-3.608-1.311C2.499 19.416 2.225 18.149 2.163 16.783 2.105 15.517 2.093 15.137 2.093 11.933s.012-3.584.07-4.85c.062-1.366.336-2.633 1.311-3.608C4.449 2.5 5.716 2.226 7.082 2.163 8.348 2.105 8.728 2.093 12 2.093zm0-2.163C8.741 0 8.332.014 7.052.072 5.197.157 3.354.745 2.014 2.085.674 3.425.086 5.268.001 7.123-.057 8.403-.07 8.812-.07 12s.013 3.597.071 4.877c.085 1.855.673 3.698 2.013 5.038 1.34 1.34 3.183 1.928 5.038 2.013C8.332 23.986 8.741 24 12 24s3.668-.014 4.948-.072c1.855-.085 3.698-.673 5.038-2.013 1.34-1.34 1.928-3.183 2.013-5.038C23.987 15.597 24 15.188 24 12s-.013-3.597-.071-4.877c-.085-1.855-.673-3.698-2.013-5.038C20.576.745 18.733.157 16.878.072 15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
          </svg>
          Instagram
        </a>
      </div>

      <div class="contact-hours">
        <p><strong>Response Hours</strong><br/>
        Mon – Fri: 8 AM – 6 PM (PHT)<br/>
        Weekends: Limited support</p>
      </div>
    </div>

    <!-- RIGHT: Chatbot + Email -->
    <div class="contact-right">

      <!-- Chatbot -->
      <div class="chatbot-card">
        <div class="chatbot-header">
          <div class="chatbot-avatar">🤖</div>
          <div class="chatbot-header-text">
            <h4>Genie Support Bot</h4>
            <span>Ask me anything about StudyGenie!</span>
          </div>
          <div class="chatbot-online">Online</div>
        </div>

        <div class="chatbot-messages" id="chatMessages">
          <!-- Initial bot message -->
          <div class="msg bot">
            <div class="msg-avatar">🤖</div>
            <div>
              <div class="msg-bubble">Hey there! 👋 I'm Genie, StudyGenie's support bot. I can answer questions about our features, pricing, and how to get started. What would you like to know?</div>
              <div class="msg-time">Just now</div>
            </div>
          </div>
        </div>

        <!-- Quick chips -->
        <div class="quick-chips" id="quickChips">
          <button class="chip" onclick="sendChip('What features does StudyGenie have?')">✨ Features</button>
          <button class="chip" onclick="sendChip('How much does Premium cost?')">💎 Pricing</button>
          <button class="chip" onclick="sendChip('How do I get started?')">🚀 Get Started</button>
          <button class="chip" onclick="sendChip('Is there a free plan?')">🆓 Free Plan</button>
        </div>

        <div class="chatbot-input">
          <input type="text" id="chatInput" placeholder="Type your question…" autocomplete="off"/>
          <button class="chatbot-send" id="chatSend" onclick="sendMessage()">
            <svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
          </button>
        </div>
      </div>

      <!-- Email Form -->
      <div class="email-card" id="emailSection">
        <div class="email-card-header">
          <div class="email-card-icon">✉️</div>
          <h3>Send us a message</h3>
        </div>
        <p>Can't find what you're looking for? Fill out the form below and our team will get back to you within 24 hours.</p>

        <div class="email-form">
          <div class="email-form-row">
            <div class="ef-group">
              <label>Your Name</label>
              <input type="text" placeholder="Juan dela Cruz" id="efName"/>
            </div>
            <div class="ef-group">
              <label>Email Address</label>
              <input type="email" placeholder="you@example.com" id="efEmail"/>
            </div>
          </div>
          <div class="ef-group">
            <label>Topic</label>
            <select id="efTopic">
              <option value="">Select a topic…</option>
              <option>Account / Login Issues</option>
              <option>Premium / Billing</option>
              <option>Feature Request</option>
              <option>Bug Report</option>
              <option>General Question</option>
              <option>Other</option>
            </select>
          </div>
          <div class="ef-group">
            <label>Your Message</label>
            <textarea id="efMessage" placeholder="Tell us what's on your mind — we read every message carefully."></textarea>
          </div>

          <div class="ef-success" id="efSuccess">
            ✅ <span>Message sent! We'll reply to your email within 24 hours. Thanks for reaching out 🙌</span>
          </div>

          <button class="ef-submit" onclick="submitEmail()">
            <span>Send Message</span>
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
          </button>
        </div>
      </div>

    </div>
  </div>

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
 
    // Footer links (only exist on some pages)
    const footerSignup = document.getElementById('footerSignup');
    const footerLogin  = document.getElementById('footerLogin');
    if (footerSignup) footerSignup.addEventListener('click', e => { e.preventDefault(); openModal('signupModal'); });
    if (footerLogin)  footerLogin.addEventListener('click',  e => { e.preventDefault(); openModal('loginModal'); });
 
    // Plan selection
    function selectPlan(el) {
      document.querySelectorAll('.plan-card').forEach(c => c.classList.remove('active'));
      el.classList.add('active');
    }

    // ── CHATBOT ──────────────────────────────────────────────────────────────

    const botResponses = {
      'what features does studygenie have': '✨ StudyGenie offers AI-powered flashcards, smart summarization, quiz generation, spaced repetition, and a focus timer — all designed to help you study smarter, not harder!',
      'how much does premium cost': '💎 Premium is available at two tiers: Monthly at ₱199/mo and Annual at ₱99/mo (billed yearly). Both unlock unlimited AI sessions, priority support, and advanced analytics!',
      'how do i get started': '🚀 Getting started is easy! Just click "Sign Up" at the top, create your free account, and you can start generating flashcards and summaries right away — no credit card needed.',
      'is there a free plan': '🆓 Yes! Our free plan gives you 10 AI sessions per day, basic flashcards, and access to our study timer. Upgrade to Premium anytime for unlimited access!',
    };

    function getTime() {
      return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }

    function appendMessage(text, type) {
      const messages = document.getElementById('chatMessages');
      const avatar = type === 'user' ? '👤' : '🤖';
      const div = document.createElement('div');
      div.className = `msg ${type}`;
      div.innerHTML = `
        <div class="msg-avatar">${avatar}</div>
        <div>
          <div class="msg-bubble">${text}</div>
          <div class="msg-time">${getTime()}</div>
        </div>`;
      messages.appendChild(div);
      messages.scrollTop = messages.scrollHeight;
    }

    function showTyping() {
      const messages = document.getElementById('chatMessages');
      const div = document.createElement('div');
      div.className = 'msg bot typing-indicator';
      div.innerHTML = `
        <div class="msg-avatar">🤖</div>
        <div>
          <div class="msg-bubble">
            <div class="typing-dots"><span></span><span></span><span></span></div>
          </div>
        </div>`;
      messages.appendChild(div);
      messages.scrollTop = messages.scrollHeight;
    }

    function removeTyping() {
      const t = document.querySelector('.typing-indicator');
      if (t) t.remove();
    }

    function getBotReply(userText) {
      const key = userText.toLowerCase().trim();
      for (const [pattern, response] of Object.entries(botResponses)) {
        if (key.includes(pattern) || pattern.includes(key)) return response;
      }
      return "Thanks for your question! 🙏 Our support team will get back to you shortly. In the meantime, feel free to email us at <a href='mailto:support@studygenie.ai' style='color:#7c3aed;'>support@studygenie.ai</a>.";
    }

    function sendMessage() {
      const input = document.getElementById('chatInput');
      const text = input.value.trim();
      if (!text) return;

      appendMessage(text, 'user');
      input.value = '';

      showTyping();
      setTimeout(() => {
        removeTyping();
        appendMessage(getBotReply(text), 'bot');
      }, 900);
    }

    function sendChip(text) {
      document.getElementById('chatInput').value = text;
      sendMessage();
    }

    // Send on Enter key
    document.getElementById('chatInput').addEventListener('keydown', e => {
      if (e.key === 'Enter') sendMessage();
    });

    // ── EMAIL FORM ────────────────────────────────────────────────────────────

    function submitEmail() {
      const name    = document.getElementById('efName').value.trim();
      const email   = document.getElementById('efEmail').value.trim();
      const topic   = document.getElementById('efTopic').value;
      const message = document.getElementById('efMessage').value.trim();

      if (!name || !email || !topic || !message) {
        alert('Please fill in all fields before sending.');
        return;
      }

      document.getElementById('efSuccess').classList.add('show');
      document.getElementById('efName').value = '';
      document.getElementById('efEmail').value = '';
      document.getElementById('efTopic').value = '';
      document.getElementById('efMessage').value = '';

      setTimeout(() => document.getElementById('efSuccess').classList.remove('show'), 5000);
    }

  </script>
 
 
</body>
</html>