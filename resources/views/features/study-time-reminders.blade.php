@extends('app')

@section('title', 'Study Time Reminders – StudyGenie AI')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@300;400;500;600;700&family=Bricolage+Grotesque:wght@400;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --ink: #0a0f1e;
            --ink-2: #1c2340;
            --muted: #6b7280;
            --muted-l: #9ca3af;
            --teal: #0d9488;
            --teal-d: #0f766e;
            --teal-l: #f0fdfa;
            --teal-pale: #ccfbf1;
            --border: #e5e7eb;
            --border-l: #f3f4f6;
            --white: #ffffff;
            --surface: #fafafa;
            --surface-2: #f4f4f5;

            --serif: 'Bricolage Grotesque', sans-serif;
            --sans: 'Instrument Sans', sans-serif;

            --r-sm: 8px;
            --r-md: 12px;
            --r-lg: 16px;
            --r-xl: 20px;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--sans);
            background: var(--white);
            color: var(--ink);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ───── UTILITY ───── */
        .label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--teal);
        }

        .label::before {
            content: '';
            width: 18px;
            height: 1.5px;
            background: var(--teal);
        }

        /* ───── HERO ───── */
        .hero {
            min-height: 100vh;
            padding: 140px 7% 100px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6rem;
            align-items: center;
            background:
                radial-gradient(ellipse 70% 50% at 85% 20%, rgba(13, 148, 136, 0.07) 0%, transparent 60%),
                radial-gradient(ellipse 40% 30% at 10% 90%, rgba(13, 148, 136, 0.04) 0%, transparent 60%),
                var(--white);
            position: relative;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 7%;
            right: 7%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent);
        }

        .hero-eyebrow {
            margin-bottom: 1.8rem;
        }

        .hero h1 {
            font-family: var(--serif);
            font-size: clamp(2.8rem, 5vw, 4.2rem);
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -1.5px;
            color: var(--ink);
            margin-bottom: 1.5rem;
        }

        .hero h1 em {
            font-style: italic;
            color: var(--teal);
        }

        .hero-sub {
            font-size: 1rem;
            font-weight: 300;
            color: var(--muted);
            line-height: 1.8;
            margin-bottom: 2.5rem;
            max-width: 440px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: var(--ink);
            color: #fff;
            border: none;
            border-radius: var(--r-md);
            padding: 0.85rem 1.8rem;
            font-size: 0.875rem;
            font-family: var(--sans);
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, transform 0.2s;
            letter-spacing: 0.01em;
        }

        .btn-primary:hover {
            background: var(--ink-2);
            transform: translateY(-1px);
        }

        .btn-primary svg {
            transition: transform 0.2s;
        }

        .btn-primary:hover svg {
            transform: translateX(3px);
        }


        /* ───── NOTIFICATION PANEL (hero right) ───── */
        .notif-panel {
            position: relative;
        }

        .notif-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            padding: 1.8rem 2rem;
            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.04),
                0 12px 40px rgba(0, 0, 0, 0.06);
        }

        .notif-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            padding-bottom: 1.2rem;
            border-bottom: 1px solid var(--border-l);
        }

        .notif-title {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .notif-date {
            font-size: 0.78rem;
            color: var(--muted-l);
        }

        .notif-row {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-l);
        }

        .notif-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .notif-time {
            font-family: var(--serif);
            font-size: 0.95rem;
            color: var(--ink);
            min-width: 52px;
            flex-shrink: 0;
        }

        .notif-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--teal);
            flex-shrink: 0;
        }

        .notif-dot.rest {
            background: var(--border);
        }

        .notif-body {
            flex: 1;
        }

        .notif-body strong {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--ink);
            margin-bottom: 0.15rem;
        }

        .notif-body span {
            font-size: 0.78rem;
            color: var(--muted);
        }

        .notif-tag {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 0.25rem 0.6rem;
            border-radius: 999px;
            background: var(--teal-pale);
            color: var(--teal-d);
            flex-shrink: 0;
        }

        .notif-tag.orange {
            background: #fff7ed;
            color: #c2410c;
        }

        .notif-tag.gray {
            background: var(--border-l);
            color: var(--muted);
        }

        /* Floating accent card */
        .notif-accent {
            position: absolute;
            bottom: -24px;
            right: -24px;
            background: var(--ink);
            border-radius: var(--r-lg);
            padding: 1.2rem 1.5rem;
            color: #fff;
            min-width: 190px;
            box-shadow: 0 20px 40px rgba(10, 15, 30, 0.25);
        }

        .accent-num {
            font-family: var(--serif);
            font-size: 2rem;
            line-height: 1;
            margin-bottom: 0.3rem;
        }

        .accent-label {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .accent-bar {
            margin-top: 0.8rem;
            height: 3px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
            overflow: hidden;
        }

        .accent-fill {
            height: 100%;
            width: 73%;
            background: var(--teal);
            border-radius: 2px;
        }

        /* ───── SECTION SHARED ───── */
        .section-wrap {
            padding: 96px 7%;
        }

        .section-wrap.alt {
            background: var(--surface);
        }

        .section-wrap.dark {
            background: var(--ink);
            color: var(--white);
        }

        .section-header {
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-family: var(--serif);
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            font-weight: 800;
            letter-spacing: -1.5px;
            line-height: 1.15;
            margin-top: 0.8rem;
            color: var(--ink);
        }

        .section-header h2 em {
            font-style: italic;
            color: var(--teal);
        }

        .section-header p {
            margin-top: 1rem;
            font-size: 0.95rem;
            color: var(--muted);
            line-height: 1.8;
            max-width: 520px;
            font-weight: 300;
        }

        /* ───── HOW IT WORKS ───── */
        .how-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 6rem;
            align-items: start;
        }

        .how-left {}

        .how-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .how-item {
            display: grid;
            grid-template-columns: 48px 1fr;
            gap: 1.2rem;
            padding: 2rem 0;
            border-bottom: 1px solid var(--border);
        }

        .how-item:last-child {
            border-bottom: none;
        }

        .how-num {
            font-family: var(--serif);
            font-size: 0.85rem;
            color: var(--muted-l);
            padding-top: 0.1rem;
            font-style: italic;
        }

        .how-body h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.4rem;
            letter-spacing: -0.01em;
        }

        .how-body p {
            font-size: 0.85rem;
            color: var(--muted);
            line-height: 1.75;
            font-weight: 300;
        }

        /* ───── FEATURES ───── */
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: var(--border);
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            overflow: hidden;
        }

        .feature-cell {
            background: var(--white);
            padding: 2.5rem 2rem;
            transition: background 0.25s;
        }

        .feature-cell:hover {
            background: var(--teal-l);
        }

        .feature-cell:hover .fc-num {
            color: var(--teal);
        }

        .fc-num {
            font-family: var(--serif);
            font-size: 2rem;
            color: var(--border);
            line-height: 1;
            margin-bottom: 1.5rem;
            transition: color 0.25s;
        }

        .feature-cell h4 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 0.5rem;
            letter-spacing: -0.01em;
        }

        .feature-cell p {
            font-size: 0.82rem;
            color: var(--muted);
            line-height: 1.7;
            font-weight: 300;
        }

        /* ───── CALENDAR ───── */
        .calendar-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 3rem;
            align-items: start;
        }

        .calendar-main {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            overflow: hidden;
        }

        .cal-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-l);
        }

        .cal-month-label {
            font-family: var(--serif);
            font-size: 1.1rem;
            color: var(--ink);
        }

        .cal-nav {
            display: flex;
            gap: 0.5rem;
        }

        .cal-nav-btn {
            width: 32px;
            height: 32px;
            border: 1px solid var(--border);
            border-radius: var(--r-sm);
            background: transparent;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            transition: border-color 0.2s, color 0.2s, background 0.2s;
            font-size: 0.9rem;
        }

        .cal-nav-btn:hover {
            border-color: var(--teal);
            color: var(--teal);
            background: var(--teal-l);
        }

        .cal-weekdays {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            padding: 0 1rem;
        }

        .cal-wd {
            text-align: center;
            padding: 0.8rem 0;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted-l);
        }

        .cal-body {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            padding: 0 1rem 1.5rem;
            gap: 2px;
        }

        .cal-d {
            aspect-ratio: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: var(--r-sm);
            cursor: pointer;
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--ink);
            position: relative;
            transition: background 0.15s, color 0.15s;
            gap: 3px;
        }

        .cal-d:hover {
            background: var(--border-l);
        }

        .cal-d.outside {
            color: var(--muted-l);
            pointer-events: none;
        }

        .cal-d.today {
            background: var(--teal-l);
            color: var(--teal-d);
            font-weight: 600;
        }

        .cal-d.today .cal-d-num::after {
            content: '';
            position: absolute;
            bottom: 6px;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background: var(--teal);
        }

        .cal-d.session {
            background: var(--ink);
            color: var(--white);
            font-weight: 600;
        }

        .cal-d.session:hover {
            background: var(--ink-2);
        }

        .cal-d.session .session-bar {
            width: 16px;
            height: 2px;
            border-radius: 1px;
            background: var(--teal);
        }

        .cal-d-num {
            position: relative;
        }

        /* Sidebar */
        .cal-sidebar {}

        .sidebar-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .sidebar-card:last-child {
            margin-bottom: 0;
        }

        .sc-title {
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted-l);
            margin-bottom: 1.2rem;
        }

        .sc-stat-row {
            display: flex;
            align-items: baseline;
            gap: 0.5rem;
            margin-bottom: 0.4rem;
        }

        .sc-big {
            font-family: var(--serif);
            font-size: 2.8rem;
            color: var(--ink);
            line-height: 1;
        }

        .sc-unit {
            font-size: 0.85rem;
            color: var(--muted);
            font-weight: 300;
        }

        .sc-track {
            height: 4px;
            background: var(--border);
            border-radius: 2px;
            overflow: hidden;
            margin: 1rem 0;
        }

        .sc-fill {
            height: 100%;
            border-radius: 2px;
            background: linear-gradient(90deg, var(--teal), var(--teal-d));
        }

        .sc-note {
            font-size: 0.78rem;
            color: var(--muted);
            font-weight: 300;
        }

        .schedule-list {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .sched-row {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .sched-time {
            font-family: var(--serif);
            font-size: 0.85rem;
            color: var(--ink);
            min-width: 46px;
        }

        .sched-bar {
            flex: 1;
            height: 4px;
            border-radius: 2px;
        }

        .sched-bar.intense {
            background: var(--teal);
        }

        .sched-bar.mid {
            background: var(--teal-pale);
        }

        .sched-bar.light {
            background: var(--border);
        }

        .sched-label {
            font-size: 0.72rem;
            color: var(--muted-l);
            min-width: 36px;
            text-align: right;
        }

        .legend-row {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            padding: 1.2rem 2rem;
            border-top: 1px solid var(--border-l);
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .leg-swatch {
            width: 14px;
            height: 14px;
            border-radius: 3px;
        }

        .leg-session {
            background: var(--ink);
        }

        .leg-today {
            background: var(--teal-l);
            border: 1px solid var(--teal);
        }

        .leg-rest {
            background: var(--white);
            border: 1px solid var(--border);
        }

        .legend-item span {
            font-size: 0.75rem;
            color: var(--muted);
        }

        /* ───── CTA ───── */
        .cta-section {
            padding: 100px 7%;
            background: var(--ink);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6rem;
            align-items: center;
        }

        .cta-left .label {
            color: rgba(255, 255, 255, 0.35);
        }

        .cta-left .label::before {
            background: rgba(255, 255, 255, 0.2);
        }

        .cta-left h2 {
            font-family: var(--serif);
            font-size: clamp(2rem, 3.5vw, 3rem);
            font-weight: 800;
            letter-spacing: -1.5px;
            line-height: 1.12;
            color: var(--white);
            margin-top: 0.8rem;
            margin-bottom: 2rem;
        }

        .cta-left h2 em {
            font-style: italic;
            color: var(--teal);
        }

        .btn-light {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            background: var(--white);
            color: var(--ink);
            border: none;
            border-radius: var(--r-md);
            padding: 0.85rem 1.8rem;
            font-size: 0.875rem;
            font-family: var(--sans);
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: opacity 0.2s, transform 0.2s;
        }

        .btn-light:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .cta-right {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .cta-feature {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.2rem 1.5rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: var(--r-lg);
        }

        .cta-check {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--teal);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.7rem;
            color: #fff;
        }

        .cta-feature p {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 300;
            line-height: 1.5;
        }

        .cta-feature p strong {
            display: block;
            color: var(--white);
            font-weight: 500;
            margin-bottom: 0.15rem;
        }

        /* ───── ANIMATIONS ───── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-left>* {
            animation: fadeUp 0.7s ease both;
        }

        .hero-badge {
            animation-delay: 0s;
        }

        .hero h1 {
            animation-delay: 0.08s;
        }

        .hero-sub {
            animation-delay: 0.16s;
        }

        .btn-primary {
            animation-delay: 0.22s;
        }

        .hero-stats {
            animation-delay: 0.28s;
        }

        .notif-panel {
            animation: fadeUp 0.7s 0.35s ease both;
        }

        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .reveal.in {
            opacity: 1;
            transform: none;
        }

        /* ───── RESPONSIVE ───── */
        @media (max-width: 1024px) {

            .hero,
            .cta-section {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .how-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .calendar-grid {
                grid-template-columns: 1fr;
            }

            .cal-sidebar {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }

            .notif-accent {
                display: none;
            }

            .feature-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .hero {
                padding: 110px 5% 70px;
            }

            .section-wrap {
                padding: 72px 5%;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .hero-stats {
                gap: 1.5rem;
            }

            .cal-sidebar {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    <!-- ══════ HERO ══════ -->
    <section class="hero">
        <div class="hero-left">
            <div class="hero-eyebrow">
                <span class="label">Smart Scheduling</span>
            </div>
            <h1>Study when it<br><em>matters most.</em></h1>
            <p class="hero-sub">Intelligent reminders that adapt to your rhythm — not the other way around. StudyGenie
                learns when you focus best and keeps you on track, effortlessly.</p>
            <a class="btn-primary">
                Get Started
            </a>
        </div>
        </div>

        <div class="notif-panel">
            <div class="notif-card">
                <div class="notif-header">
                    <span class="notif-title">Today's schedule</span>
                    <span class="notif-date">Tue, Apr 28</span>
                </div>
                <div class="notif-row">
                    <div class="notif-time">7:30</div>
                    <div class="notif-dot"></div>
                    <div class="notif-body">
                        <strong>Morning review</strong>
                        <span>Flashcard session — 15 min</span>
                    </div>
                    <span class="notif-tag">Done</span>
                </div>
                <div class="notif-row">
                    <div class="notif-time">10:00</div>
                    <div class="notif-dot"></div>
                    <div class="notif-body">
                        <strong>Deep study block</strong>
                        <span>Organic Chemistry — Ch. 7</span>
                    </div>
                    <span class="notif-tag orange">Now</span>
                </div>
                <div class="notif-row">
                    <div class="notif-time">14:30</div>
                    <div class="notif-dot rest"></div>
                    <div class="notif-body">
                        <strong>Practice test</strong>
                        <span>Adaptive mock exam — 60 min</span>
                    </div>
                    <span class="notif-tag gray">Later</span>
                </div>
                <div class="notif-row">
                    <div class="notif-time">19:00</div>
                    <div class="notif-dot rest"></div>
                    <div class="notif-body">
                        <strong>Evening recap</strong>
                        <span>Spaced repetition review</span>
                    </div>
                    <span class="notif-tag gray">Later</span>
                </div>
            </div>
            <div class="notif-accent">
                <div class="accent-label">Day streak</div>
                <div class="accent-bar">
                    <div class="accent-fill"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════ HOW IT WORKS ══════ -->
    <section class="section-wrap alt">
        <div class="how-grid">
            <div class="how-left section-header reveal">
                <span class="label">How it works</span>
                <h2>Reminders that<br><em>actually work</em></h2>
                <p>Three steps to consistent, science-backed study habits — no willpower required.</p>
            </div>
            <div class="how-list">
                <div class="how-item reveal">
                    <div class="how-num">01</div>
                    <div class="how-body">
                        <h4>Set your schedule</h4>
                        <p>Tell StudyGenie your available windows, subjects, and learning goals. It takes under two minutes.
                        </p>
                    </div>
                </div>
                <div class="how-item reveal">
                    <div class="how-num">02</div>
                    <div class="how-body">
                        <h4>AI adapts to your rhythm</h4>
                        <p>The model monitors your response patterns — when you open notifications, when you study longest —
                            and shifts reminder timing to match your natural peaks.</p>
                    </div>
                </div>
                <div class="how-item reveal">
                    <div class="how-num">03</div>
                    <div class="how-body">
                        <h4>Spaced repetition sync</h4>
                        <p>Review prompts are timed to the forgetting curve, so each notification arrives at exactly the
                            right moment for maximum retention.</p>
                    </div>
                </div>
                <div class="how-item reveal">
                    <div class="how-num">04</div>
                    <div class="how-body">
                        <h4>Watch the habit form</h4>
                        <p>Streaks, progress charts, and consistency scores give you tangible proof that the system is
                            working.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════ CALENDAR ══════ -->
    <section class="section-wrap">
        <div class="section-header reveal">
            <span class="label">Study Calendar</span>
            <h2>Your month,<br><em>at a glance</em></h2>
            <p>Every session logged, every streak visible. The calendar updates in real time as you complete study blocks.
            </p>
        </div>

        <div class="calendar-grid reveal">
            <div class="calendar-main">
                <div class="cal-topbar">
                    <span class="cal-month-label">May 2026</span>
                    <div class="cal-nav">
                        <button class="cal-nav-btn" aria-label="Previous month">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <path d="M7.5 2L3.5 6l4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                        <button class="cal-nav-btn" aria-label="Next month">
                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                <path d="M4.5 2L8.5 6l-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="cal-weekdays">
                    <div class="cal-wd">Sun</div>
                    <div class="cal-wd">Mon</div>
                    <div class="cal-wd">Tue</div>
                    <div class="cal-wd">Wed</div>
                    <div class="cal-wd">Thu</div>
                    <div class="cal-wd">Fri</div>
                    <div class="cal-wd">Sat</div>
                </div>

                <div class="cal-body">
                    <!-- Previous month -->
                    <div class="cal-d outside"><span class="cal-d-num">26</span></div>
                    <div class="cal-d outside"><span class="cal-d-num">27</span></div>
                    <div class="cal-d outside"><span class="cal-d-num">28</span></div>
                    <div class="cal-d outside"><span class="cal-d-num">29</span></div>
                    <div class="cal-d outside"><span class="cal-d-num">30</span></div>
                    <!-- May -->
                    <div class="cal-d"><span class="cal-d-num">1</span></div>
                    <div class="cal-d session"><span class="cal-d-num">2</span>
                        <div class="session-bar"></div>
                    </div>
                    <div class="cal-d session"><span class="cal-d-num">3</span>
                        <div class="session-bar"></div>
                    </div>
                    <div class="cal-d"><span class="cal-d-num">4</span></div>
                    <div class="cal-d session"><span class="cal-d-num">5</span>
                        <div class="session-bar"></div>
                    </div>
                    <div class="cal-d session"><span class="cal-d-num">6</span>
                        <div class="session-bar"></div>
                    </div>
                    <div class="cal-d"><span class="cal-d-num">7</span></div>
                    <div class="cal-d session"><span class="cal-d-num">8</span>
                        <div class="session-bar"></div>
                    </div>
                    <div class="cal-d today"><span class="cal-d-num">9</span></div>
                    <div class="cal-d"><span class="cal-d-num">10</span></div>
                    <div class="cal-d"><span class="cal-d-num">11</span></div>
                    <div class="cal-d"><span class="cal-d-num">12</span></div>
                    <div class="cal-d"><span class="cal-d-num">13</span></div>
                    <div class="cal-d"><span class="cal-d-num">14</span></div>
                    <div class="cal-d"><span class="cal-d-num">15</span></div>
                    <div class="cal-d"><span class="cal-d-num">16</span></div>
                    <div class="cal-d"><span class="cal-d-num">17</span></div>
                    <div class="cal-d"><span class="cal-d-num">18</span></div>
                    <div class="cal-d"><span class="cal-d-num">19</span></div>
                    <div class="cal-d"><span class="cal-d-num">20</span></div>
                    <div class="cal-d"><span class="cal-d-num">21</span></div>
                    <div class="cal-d"><span class="cal-d-num">22</span></div>
                    <div class="cal-d"><span class="cal-d-num">23</span></div>
                    <div class="cal-d"><span class="cal-d-num">24</span></div>
                    <div class="cal-d"><span class="cal-d-num">25</span></div>
                    <div class="cal-d"><span class="cal-d-num">26</span></div>
                    <div class="cal-d"><span class="cal-d-num">27</span></div>
                    <div class="cal-d"><span class="cal-d-num">28</span></div>
                    <div class="cal-d"><span class="cal-d-num">29</span></div>
                    <div class="cal-d"><span class="cal-d-num">30</span></div>
                    <div class="cal-d"><span class="cal-d-num">31</span></div>
                </div>

                <div class="legend-row">
                    <div class="legend-item">
                        <div class="leg-swatch leg-session"></div>
                        <span>Session completed</span>
                    </div>
                    <div class="legend-item">
                        <div class="leg-swatch leg-today"></div>
                        <span>Today</span>
                    </div>
                    <div class="legend-item">
                        <div class="leg-swatch leg-rest"></div>
                        <span>Rest day</span>
                    </div>
                </div>
            </div>

            <div class="cal-sidebar">
                <div class="sidebar-card">
                    <div class="sc-title">Monthly progress</div>
                    <div class="sc-stat-row">
                        <div class="sc-big">8</div>
                        <div class="sc-unit">/ 22 sessions</div>
                    </div>
                    <div class="sc-track">
                        <div class="sc-fill" style="width:36%"></div>
                    </div>
                    <div class="sc-note">36% of goal completed · On track for your best month</div>
                </div>

                <div class="sidebar-card">
                    <div class="sc-title">Today's schedule</div>
                    <div class="schedule-list">
                        <div class="sched-row">
                            <div class="sched-time">7:30</div>
                            <div class="sched-bar intense" style="width:100%"></div>
                            <div class="sched-label">Done</div>
                        </div>
                        <div class="sched-row">
                            <div class="sched-time">10:00</div>
                            <div class="sched-bar mid" style="width:100%"></div>
                            <div class="sched-label">Now</div>
                        </div>
                        <div class="sched-row">
                            <div class="sched-time">14:30</div>
                            <div class="sched-bar light" style="width:100%"></div>
                            <div class="sched-label">Later</div>
                        </div>
                        <div class="sched-row">
                            <div class="sched-time">19:00</div>
                            <div class="sched-bar light" style="width:100%"></div>
                            <div class="sched-label">Later</div>
                        </div>
                    </div>
                </div>

                <div class="sidebar-card">
                    <div class="sc-title">Current streak</div>
                    <div class="sc-stat-row">
                        <div class="sc-big">18</div>
                        <div class="sc-unit">days</div>
                    </div>
                    <div class="sc-track">
                        <div class="sc-fill" style="width:72%"></div>
                    </div>
                    <div class="sc-note">Personal best: 25 days · Keep going</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════ FEATURES ══════ -->
    <section class="section-wrap alt">
        <div class="section-header reveal">
            <span class="label">Capabilities</span>
            <h2>Everything you need<br>to <em>stay consistent</em></h2>
        </div>
        <div class="feature-grid reveal">
            <div class="feature-cell">
                <div class="fc-num">01</div>
                <h4>Adaptive Scheduling</h4>
                <p>AI identifies your peak focus windows and shifts reminder times automatically over time.</p>
            </div>
            <div class="feature-cell">
                <div class="fc-num">02</div>
                <h4>Spaced Repetition</h4>
                <p>Review prompts are timed to the forgetting curve for maximum long-term retention.</p>
            </div>
            <div class="feature-cell">
                <div class="fc-num">03</div>
                <h4>Multi-Channel Delivery</h4>
                <p>Push, email, SMS, or in-app — choose the channel that interrupts you least.</p>
            </div>
            <div class="feature-cell">
                <div class="fc-num">04</div>
                <h4>Progress Analytics</h4>
                <p>Streak tracking, heatmaps, and session-by-session breakdowns of your consistency.</p>
            </div>
            <div class="feature-cell">
                <div class="fc-num">05</div>
                <h4>Fully Customizable</h4>
                <p>Set frequency, subjects, intensity, and pause reminders whenever life gets busy.</p>
            </div>
            <div class="feature-cell">
                <div class="fc-num">06</div>
                <h4>Quiet Hours</h4>
                <p>Define do-not-disturb windows so reminders never interrupt sleep or downtime.</p>
            </div>
        </div>
    </section>

    <!-- ══════ CTA ══════ -->
    <section class="cta-section">
        <div class="cta-left reveal">
            <span class="label">Get started</span>
            <h2>Build a study habit<br>that <em>actually sticks.</em></h2>
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M2 7h10M8 3l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
            </a>
        </div>
        <div class="cta-right reveal">
            <div class="cta-feature">
                <div class="cta-check">✓</div>
                <p><strong>No credit card required</strong>Full access to all reminder features during your free trial.</p>
            </div>
            <div class="cta-feature">
                <div class="cta-check">✓</div>
                <p><strong>Set up in under 2 minutes</strong>Import your subjects, choose your notification style, and go.
                </p>
            </div>
            <div class="cta-feature">
                <div class="cta-check">✓</div>
                <p><strong>Cancel anytime</strong>No lock-in. Your data is always yours to export.</p>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        const obs = new IntersectionObserver((entries) => {
            entries.forEach((e, i) => {
                if (e.isIntersecting) {
                    setTimeout(() => e.target.classList.add('in'), i * 70);
                }
            });
        }, {
            threshold: 0.06
        });
        document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
    </script>
@endpush
