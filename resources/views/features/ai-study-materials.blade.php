@extends('app')

@section('title', 'AI Study Material Generator – StudyGenie AI')

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
            --blue: #3b82f6;
            --blue-d: #1d4ed8;
            --blue-l: #eff6ff;
            --blue-m: #bfdbfe;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --white: #ffffff;
            --off: #f8faff;
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

        /* HERO */
        .hero {
            padding: 130px 6% 90px;
            background:
                radial-gradient(ellipse 80% 60% at 100% 0%, rgba(59, 130, 246, 0.12) 0%, transparent 55%),
                radial-gradient(ellipse 50% 40% at 0% 100%, rgba(59, 130, 246, 0.06) 0%, transparent 55%),
                #fff;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        .hero-left {}

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--blue-l);
            border: 1px solid var(--blue-m);
            border-radius: 999px;
            padding: 0.4rem 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--blue);
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
            color: var(--blue);
        }

        .hero-sub {
            font-size: 1.05rem;
            color: var(--muted);
            line-height: 1.75;
            margin-bottom: 2rem;
            max-width: 460px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--blue), var(--blue-d));
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 0.9rem 2rem;
            font-size: 1rem;
            font-family: 'Instrument Sans', sans-serif;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 6px 24px rgba(59, 130, 246, 0.35);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 32px rgba(59, 130, 246, 0.45);
        }

        /* HERO VISUAL */
        .hero-visual {
            background: var(--off);
            border: 1.5px solid var(--border);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(59, 130, 246, 0.1);
            animation: floatUp 0.8s 0.2s ease both;
        }

        .upload-zone {
            border: 2px dashed var(--blue-m);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            background: var(--blue-l);
            margin-bottom: 1.5rem;
        }

        .upload-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .upload-zone p {
            font-size: 0.85rem;
            color: var(--blue);
            font-weight: 500;
        }

        .upload-zone small {
            color: var(--muted);
            font-size: 0.75rem;
        }

        .result-preview {
            display: flex;
            flex-direction: column;
            gap: 0.7rem;
        }

        .result-line {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.7rem 1rem;
        }

        .result-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .dot-blue {
            background: var(--blue);
        }

        .dot-teal {
            background: #0d9488;
        }

        .dot-violet {
            background: #7c3aed;
        }

        .result-line span {
            font-size: 0.82rem;
            color: var(--text);
            font-weight: 500;
        }

        .result-line .line-bar {
            margin-left: auto;
            height: 4px;
            border-radius: 2px;
            background: var(--blue-l);
        }

        /* WHAT IT DOES */
        .what-section {
            padding: 90px 6%;
            background: var(--off);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
        }

        .what-text h2 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: clamp(1.8rem, 3.5vw, 2.6rem);
            font-weight: 800;
            letter-spacing: -1.5px;
            margin-bottom: 1rem;
        }

        .what-text h2 span {
            color: var(--blue);
        }

        .what-text p {
            color: var(--muted);
            line-height: 1.8;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
        }

        .what-cards {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .what-card {
            background: #fff;
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 1.2rem 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .what-card:hover {
            border-color: var(--blue);
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.08);
        }

        .wc-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--blue-l);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
            margin-top: 0;
            color: var(--blue);
        }

        .what-card h4 {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
        }

        .what-card p {
            font-size: 0.85rem;
            color: var(--muted);
            line-height: 1.6;
            margin: 0;
        }

        /* ICON HELPERS */
        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: var(--blue-l);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--blue);
            font-weight: 700;
            font-size: 1.2rem;
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
            color: var(--blue);
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
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.2rem;
        }

        .format-card {
            background: var(--off);
            border: 1.5px solid var(--border);
            border-radius: 18px;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .format-card:hover {
            border-color: var(--blue);
            transform: translateY(-5px);
            box-shadow: 0 12px 36px rgba(59, 130, 246, 0.1);
        }

        .format-card .icon-box {
            margin-bottom: 1rem;
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
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(29, 78, 216, 0.08) 100%), var(--off);
        }

        .how-section .sec-label {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--blue);
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
            position: relative;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .step:hover {
            border-color: var(--blue);
            box-shadow: 0 16px 50px rgba(59, 130, 246, 0.1);
        }

        .step-num {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--blue), var(--blue-d));
            color: #fff;
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
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

        /* CTA */
        .cta {
            padding: 100px 6%;
            text-align: center;
            background: linear-gradient(135deg, var(--blue) 0%, var(--blue-d) 100%);
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
            color: var(--blue);
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

        /* ANIMATIONS */
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
            .what-section {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .hero {
                padding: 110px 4% 60px;
            }

            .steps {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <!-- HERO -->
    <section class="hero">
        <div class="hero-left">
            <div class="hero-badge">✨ AI-Powered</div>
            <h1>Generate Study<br>Materials <span>Automatically</span></h1>
            <p class="hero-sub">Upload any content and let StudyGenie's AI engine instantly create structured summaries,
                outlines, and key points — so you can focus entirely on learning.</p>
            <a href="/signup" class="btn-primary">Try It Free →</a>
        </div>
        <div class="hero-visual reveal">
            <div class="upload-zone">
                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                    style="margin: 0 auto 1rem; color: var(--blue);">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="17 8 12 3 7 8" />
                    <line x1="12" y1="3" x2="12" y2="15" />
                </svg>
                <p>Drop your file here</p>
            </div>
            <div class="result-preview">
                <div class="result-line">
                    <div class="result-dot dot-blue"></div>
                    <span>Summary Generated</span>
                    <div class="line-bar" style="width:60px; background: #bfdbfe;"></div>
                </div>
                <div class="result-line">
                    <div class="result-dot dot-teal"></div>
                    <span>Outline Created</span>
                    <div class="line-bar" style="width:80px; background: #99f6e4;"></div>
                </div>
                <div class="result-line">
                    <div class="result-dot dot-violet"></div>
                    <span>Key Concepts Tagged</span>
                    <div class="line-bar" style="width:45px; background: #ddd6fe;"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- WHAT IT DOES -->
    <section class="what-section">
        <div class="what-text">
            <p class="sec-label">What It Does</p>
            <h2>Your AI reads it.<br><span>You master it.</span></h2>
            <p>Stop wasting hours reorganizing lectures and textbooks into usable notes. StudyGenie's AI processes your raw
                content and produces clean, study-ready materials in seconds.</p>
        </div>
        <div class="what-cards">
            <div class="what-card reveal">
                <div class="wc-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                </div>
                <div>
                    <h4>Instant Summaries</h4>
                    <p>Condenses lengthy content into concise, focused summaries at the depth you choose.</p>
                </div>
            </div>
            <div class="what-card reveal">
                <div class="wc-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z" />
                        <path d="M9 7h6M9 11h6M9 15h4" />
                    </svg>
                </div>
                <div>
                    <h4>Topic Outlines</h4>
                    <p>Structures your content into hierarchical outlines with main topics and sub-points.</p>
                </div>
            </div>
            <div class="what-card reveal">
                <div class="wc-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="1" />
                        <circle cx="19" cy="12" r="1" />
                        <circle cx="5" cy="12" r="1" />
                    </svg>
                </div>
                <div>
                    <h4>Key Concept Tagging</h4>
                    <p>Identifies and highlights the most critical terms and ideas in your material.</p>
                </div>
            </div>
            <div class="what-card reveal">
                <div class="wc-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="6" cy="5" r="3" />
                        <circle cx="18" cy="5" r="3" />
                        <path d="M9 7H6a2 2 0 0 0-2 2v2h14v-2a2 2 0 0 0-3-2h-3" />
                        <line x1="9" y1="12" x2="15" y2="12" />
                        <path d="M9 12L6 20a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l-3-8" />
                    </svg>
                </div>
                <div>
                    <h4>Concept Linking</h4>
                    <p>Connects related ideas across your documents to build a richer understanding.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SUPPORTED FORMATS -->
    <section class="formats-section">
        <p class="sec-label">Supported Formats</p>
        <h2>Works with everything you have</h2>
        <p>No conversion needed. Upload files exactly as they are — StudyGenie handles the rest.</p>
        <div class="formats-grid">
            <div class="format-card reveal">
                <div class="icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                </div>
                <h4>PDF Files</h4>
                <p>Textbooks, lecture slides, research papers</p>
            </div>
            <div class="format-card reveal">
                <div class="icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                        <circle cx="8.5" cy="8.5" r="1.5" />
                        <polyline points="21 15 16 10 5 21" />
                    </svg>
                </div>
                <h4>Photos & Images</h4>
                <p>Handwritten notes, whiteboard shots</p>
            </div>
            <div class="format-card reveal">
                <div class="icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z" />
                        <path d="M19 10v2a7 7 0 0 1-14 0v-2" />
                        <line x1="12" y1="19" x2="12" y2="23" />
                        <line x1="8" y1="23" x2="16" y2="23" />
                    </svg>
                </div>
                <h4>Voice Memos</h4>
                <p>Recorded lectures, personal audio notes</p>
            </div>
            <div class="format-card reveal">
                <div class="icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                    </svg>
                </div>
                <h4>Text & Docs</h4>
                <p>DOCX, TXT, copied paste content</p>
            </div>
            <div class="format-card reveal">
                <div class="icon-box">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="2" y1="12" x2="22" y2="12" />
                        <path
                            d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                    </svg>
                </div>
                <h4>Web Pages</h4>
                <p>Articles, blog posts, online resources</p>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="how-section">
        <p class="sec-label">Process</p>
        <h2>Three steps to study-ready</h2>
        <div class="steps">
            <div class="step reveal">
                <div class="step-num">1</div>
                <h3>Upload Your Content</h3>
                <p>Drop any file — PDF, image, audio, or plain text — into the StudyGenie uploader.</p>
            </div>
            <div class="step reveal">
                <div class="step-num">2</div>
                <h3>AI Processes It</h3>
                <p>StudyGenie's engine reads, extracts, and structures the key ideas from your content.</p>
            </div>
            <div class="step reveal">
                <div class="step-num">3</div>
                <h3>Get Study Materials</h3>
                <p>Receive organized summaries, outlines, and tagged concepts — ready to study immediately.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta">
        <h2>Stop organizing.<br>Start learning.</h2>
        <p>Let StudyGenie handle the prep work so you can spend 100% of your time on what matters.</p>
        <a href="/signup" class="btn-white">Generate Your First Study Material →</a>
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
