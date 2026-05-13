@extends('app')

@section('title', 'Smart Notes Converter – StudyGenie AI')

@push('styles')
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --teal: #0d9488;
            --teal-d: #0f766e;
            --teal-l: #f0fdfa;
            --teal-m: #99f6e4;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --white: #ffffff;
            --off: #f7fffe;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background: var(--white);
            color: var(--text);
            overflow-x: hidden;
        }

        /* HERO — SPLIT */
        .hero {
            padding: 130px 6% 90px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
            background:
                radial-gradient(ellipse 60% 70% at 100% 50%, rgba(13, 148, 136, 0.08) 0%, transparent 60%),
                #fff;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--teal-l);
            border: 1px solid var(--teal-m);
            border-radius: 999px;
            padding: 0.4rem 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--teal);
            margin-bottom: 1.5rem;
        }

        .hero h1 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: clamp(2.4rem, 4.5vw, 3.8rem);
            font-weight: 800;
            letter-spacing: -2px;
            line-height: 1.1;
            margin-bottom: 1.2rem;
        }

        .hero h1 span {
            background: linear-gradient(135deg, var(--teal), #0891b2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-sub {
            font-size: 1.05rem;
            color: var(--muted);
            line-height: 1.75;
            margin-bottom: 2rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--teal), var(--teal-d));
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 0.9rem 2rem;
            font-size: 1rem;
            font-family: 'Instrument Sans', sans-serif;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 6px 24px rgba(13, 148, 136, 0.35);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 32px rgba(13, 148, 136, 0.45);
        }

        /* TRANSFORM VISUAL */
        .transform-visual {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
            animation: floatUp 0.8s 0.2s ease both;
        }

        .tv-box {
            width: 100%;
            background: var(--off);
            border: 1.5px solid var(--border);
            border-radius: 18px;
            padding: 1.5rem;
        }

        .tv-label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
            margin-bottom: 0.8rem;
        }

        .tv-raw {
            font-size: 0.8rem;
            color: var(--muted);
            line-height: 1.6;
            font-family: monospace;
        }

        .tv-arrow {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--teal), #0891b2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #fff;
            box-shadow: 0 4px 14px rgba(13, 148, 136, 0.3);
        }

        .tv-clean {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .tv-item {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            font-size: 0.82rem;
            font-weight: 500;
        }

        .tv-dot {
            width: 8px;
            height: 8px;
            background: var(--teal);
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* BEFORE / AFTER */
        .before-after {
            padding: 90px 6%;
            background: var(--off);
        }

        .ba-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 0.8rem;
        }

        .before-after h2 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: clamp(1.8rem, 3.5vw, 2.6rem);
            font-weight: 800;
            letter-spacing: -1.5px;
            margin-bottom: 3rem;
        }

        .ba-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .ba-panel {
            border-radius: 20px;
            padding: 2rem;
        }

        .ba-before {
            background: #fff;
            border: 1.5px solid #fecaca;
        }

        .ba-after {
            background: var(--teal-l);
            border: 1.5px solid var(--teal-m);
        }

        .ba-panel-label {
            font-size: 0.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .label-before {
            color: #dc2626;
        }

        .label-after {
            color: var(--teal);
        }

        .ba-content {
            font-size: 0.85rem;
            line-height: 1.8;
            color: var(--muted);
        }

        .ba-content ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .ba-content li {
            display: flex;
            gap: 0.6rem;
        }

        .ba-content li::before {
            content: '→';
            color: var(--teal);
            font-weight: 700;
            flex-shrink: 0;
        }

        /* FORMATS */
        .formats-section {
            padding: 90px 6%;
            background: #fff;
        }

        .formats-section .sec-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 0.8rem;
        }

        .formats-section h2 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: clamp(1.8rem, 3.5vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -1.5px;
            margin-bottom: 0.8rem;
        }

        .formats-section>p {
            color: var(--muted);
            margin-bottom: 3rem;
            max-width: 520px;
            line-height: 1.7;
        }

        .formats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 1.2rem;
        }

        .format-card {
            background: var(--off);
            border: 1.5px solid var(--border);
            border-radius: 18px;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
        }

        .format-card:hover {
            border-color: var(--teal);
            transform: translateY(-5px);
            box-shadow: 0 12px 36px rgba(13, 148, 136, 0.1);
        }

        .format-icon {
            font-size: 2.2rem;
            margin-bottom: 0.8rem;
        }

        .format-card h4 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 0.4rem;
        }

        .format-card p {
            font-size: 0.8rem;
            color: var(--muted);
            line-height: 1.5;
        }

        /* HOW IT WORKS */
        .how-section {
            padding: 90px 6%;
            background: linear-gradient(135deg, rgba(13, 148, 136, 0.04) 0%, rgba(8, 145, 178, 0.06) 100%), var(--off);
        }

        .how-section .sec-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 0.8rem;
        }

        .how-section h2 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: clamp(1.8rem, 3.5vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -1.5px;
            margin-bottom: 3rem;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .step {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 20px;
            padding: 2.5rem 2rem;
            text-align: center;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .step:hover {
            border-color: var(--teal);
            box-shadow: 0 16px 50px rgba(13, 148, 136, 0.1);
        }

        .step-num {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--teal), var(--teal-d));
            color: #fff;
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 6px 20px rgba(13, 148, 136, 0.3);
        }

        .step h3 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            margin-bottom: 0.6rem;
        }

        .step p {
            font-size: 0.88rem;
            color: var(--muted);
            line-height: 1.7;
        }

        .cta {
            padding: 100px 6%;
            text-align: center;
            background: linear-gradient(135deg, var(--teal) 0%, #0891b2 100%);
        }

        .cta h2 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            letter-spacing: -1.5px;
            color: #fff;
            margin-bottom: 1rem;
        }

        .cta p {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2.5rem;
            max-width: 460px;
            margin-inline: auto;
            margin-bottom: 2.5rem;
        }

        .btn-white {
            background: #fff;
            color: var(--teal);
            border: none;
            border-radius: 12px;
            padding: 0.95rem 2.5rem;
            font-size: 1rem;
            font-family: 'Instrument Sans', sans-serif;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.15);
        }

        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 32px rgba(0, 0, 0, 0.2);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(28px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes floatUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-left>* {
            animation: fadeUp 0.65s ease both;
        }

        .hero-badge {
            animation-delay: 0s;
        }

        .hero h1 {
            animation-delay: 0.1s;
        }

        .hero-sub {
            animation-delay: 0.2s;
        }

        .btn-primary {
            animation-delay: 0.3s;
        }

        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: none;
        }

        @media (max-width: 900px) {

            .hero,
            .ba-grid {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .steps {
                grid-template-columns: 1fr;
            }

            .hero {
                padding: 110px 4% 60px;
            }

            .nav-links {
                display: none;
            }
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
        <div class="hero-left">
            <div class="hero-badge">📝 Instant Conversion</div>
            <h1>Raw Notes In.<br><span>Smart Tools</span> Out.</h1>
            <p class="hero-sub">Stop spending hours organizing handwritten or messy notes. StudyGenie converts any raw input
                into structured, actionable learning tools — instantly.</p>
            <button class="btn-primary">Convert Your Notes →</button>
        </div>
        <div class="transform-visual">
            <div class="tv-box">
                <div class="tv-label">📸 Input — Raw Handwritten Notes</div>
                <div class="tv-raw">
                    "mito = powerhouse... ATP synth... respiration chain... glycolysis first step... NAD+ → NADH... krebs
                    cycle = 8 steps... CO2 released..."
                </div>
            </div>
            <div class="tv-arrow">↓</div>
            <div class="tv-box" style="border-color: var(--teal-m); background: var(--teal-l);">
                <div class="tv-label" style="color: var(--teal);">✨ Output — Structured Study Notes</div>
                <div class="tv-clean">
                    <div class="tv-item">
                        <div class="tv-dot"></div>Mitochondria: Site of ATP synthesis
                    </div>
                    <div class="tv-item">
                        <div class="tv-dot"></div>Glycolysis → Krebs Cycle → ETC
                    </div>
                    <div class="tv-item">
                        <div class="tv-dot"></div>NAD⁺ reduced to NADH (electron carrier)
                    </div>
                    <div class="tv-item">
                        <div class="tv-dot"></div>Krebs Cycle: 8 enzymatic steps, releases CO₂
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- BEFORE / AFTER -->
    <section class="before-after">
        <p class="ba-label">The Difference</p>
        <h2>Before & after StudyGenie</h2>
        <div class="ba-grid">
            <div class="ba-panel ba-before reveal">
                <div class="ba-panel-label label-before">❌ Without StudyGenie</div>
                <div class="ba-content">
                    <p>Hours of manual rewriting and organising. Messy notes that are hard to revisit. No structure, no
                        clear connections. Key concepts buried in noise. Wasted study time on admin, not learning.</p>
                </div>
            </div>
            <div class="ba-panel ba-after reveal">
                <div class="ba-panel-label label-after">✅ With StudyGenie</div>
                <div class="ba-content">
                    <ul>
                        <li>Upload raw notes in any format</li>
                        <li>AI structures and cleans content instantly</li>
                        <li>Key concepts auto-tagged and linked</li>
                        <li>Topics organized with hierarchy</li>
                        <li>100% study time on actual learning</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FORMATS -->
    <section class="formats-section">
        <p class="sec-label">Supported Inputs</p>
        <h2>Whatever format. Handled.</h2>
        <p>StudyGenie accepts your notes exactly as they are — no preparation needed.</p>
        <div class="formats-grid">
            <div class="format-card reveal">
                <div class="format-icon">📸</div>
                <h4>Handwritten Photos</h4>
                <p>Snap a photo of your notes and upload directly</p>
            </div>
            <div class="format-card reveal">
                <div class="format-icon">📄</div>
                <h4>PDF Documents</h4>
                <p>Textbooks, past papers, lecture slides</p>
            </div>
            <div class="format-card reveal">
                <div class="format-icon">🎙️</div>
                <h4>Voice Memos</h4>
                <p>Recorded lectures and spoken notes</p>
            </div>
            <div class="format-card reveal">
                <div class="format-icon">📋</div>
                <h4>Pasted Text</h4>
                <p>Copy-paste from anywhere into StudyGenie</p>
            </div>
            <div class="format-card reveal">
                <div class="format-icon">📝</div>
                <h4>Word Docs</h4>
                <p>DOCX, Google Docs exports, TXT files</p>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how-section">
        <p class="sec-label">Process</p>
        <h2>From chaos to clarity in 3 steps</h2>
        <div class="steps">
            <div class="step reveal">
                <div class="step-num">1</div>
                <h3>Upload Raw Notes</h3>
                <p>A photo of handwriting, an audio recording, or a messy document — any format works.</p>
            </div>
            <div class="step reveal">
                <div class="step-num">2</div>
                <h3>AI Cleans & Structures</h3>
                <p>StudyGenie transforms chaos into clean, tagged, hierarchically organized notes.</p>
            </div>
            <div class="step reveal">
                <div class="step-num">3</div>
                <h3>Use Instantly</h3>
                <p>Your notes are now searchable, shareable, and ready to become flashcards or quizzes.</p>
            </div>
        </div>
    </section>

    <section class="cta">
        <h2>Your messy notes.<br>Instantly transformed.</h2>
        <p>Upload your first set of notes and see them become a powerful study tool in seconds.</p>
        <button class="btn-white">Convert Notes Free →</button>
    </section>
@endsection

@push('scripts')
    <script>
        const reveals = document.querySelectorAll('.reveal');
        const io = new IntersectionObserver((entries) => {
            entries.forEach((e, i) => {
                if (e.isIntersecting) setTimeout(() => e.target.classList.add('visible'), i * 90);
            });
        }, {
            threshold: 0.08
        });
        reveals.forEach(r => io.observe(r));
    </script>
@endpush
