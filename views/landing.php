<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Les Passe — Smart Estate Visitor Access System | Lagos</title>
  <meta name="description" content="Replace your estate visitor book with Les Passe. Residents generate digital gate passes, guards verify instantly, admins audit every entry. Built for Lagos gated estates." />

  <!-- OG -->
  <meta property="og:title" content="Les Passe — Smart Estate Visitor Access System" />
  <meta property="og:description" content="Residents generate time-limited visitor passes. Guards verify at the gate instantly. Admins see every entry in real time." />
  <meta property="og:image" content="https://www.lespasse.ng/public/assets/og-image.png" />
  <meta property="og:url" content="https://www.lespasse.ng" />
  <meta property="og:type" content="website" />
  <meta name="twitter:card" content="summary_large_image" />

  <link rel="icon" type="image/x-icon" href="/public/assets/icons/favicon.ico" />
  <link rel="apple-touch-icon" href="/public/assets/icons/apple-touch-icon.png" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet" />

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    :root {
      --bg:      #0a0e13;
      --bg2:     #111620;
      --bg3:     #181e2a;
      --border:  rgba(48,220,128,0.12);
      --border-h:rgba(48,220,128,0.30);
      --green:   #30dc80;
      --greend:  #22c55e;
      --greent:  #4ade80;
      --greenbg: rgba(48,220,128,0.07);
      --muted:   #8b949e;
      --text:    #e6edf3;
      --r:       12px;
      --rl:      20px;
    }
    body { background:var(--bg); color:var(--text); font-family:'DM Sans',sans-serif; font-size:16px; line-height:1.65; -webkit-font-smoothing:antialiased; overflow-x:hidden; }
    a { text-decoration:none; color:inherit; }
    img { display:block; max-width:100%; }
    ::-webkit-scrollbar { width:5px; }
    ::-webkit-scrollbar-thumb { background:rgba(48,220,128,0.2); border-radius:3px; }

    /* ── GRID BACKGROUND ── */
    .grid-bg {
      position:fixed; inset:0; pointer-events:none; z-index:0;
      background-image: linear-gradient(rgba(48,220,128,0.025) 1px,transparent 1px), linear-gradient(90deg,rgba(48,220,128,0.025) 1px,transparent 1px);
      background-size:56px 56px;
    }

    /* ── NAV ── */
    nav {
      position:fixed; top:0; left:0; right:0; z-index:100;
      background:rgba(10,14,19,0.88); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px);
      border-bottom:1px solid var(--border);
    }
    .nav-inner { max-width:1100px; margin:0 auto; padding:14px 24px; display:flex; align-items:center; justify-content:space-between; }
    .nav-brand { display:flex; align-items:center; gap:10px; }
    .nav-brand img { width:30px; height:30px; }
    .nav-brand-text { font-family:'Syne',sans-serif; font-size:18px; font-weight:800; color:var(--greent); letter-spacing:-0.01em; }
    .nav-links { display:flex; align-items:center; gap:28px; }
    .nav-links a { font-size:14px; color:var(--muted); transition:color 0.2s; }
    .nav-links a:hover { color:var(--text); }
    .nav-cta { background:var(--green); color:#0a0e13 !important; font-weight:600 !important; padding:9px 20px; border-radius:var(--r); font-size:14px !important; transition:background 0.2s,transform 0.15s !important; }
    .nav-cta:hover { background:var(--greend) !important; transform:translateY(-1px); }
    .ham { display:none; background:none; border:none; color:var(--text); font-size:22px; cursor:pointer; }
    .mob-menu { display:none; flex-direction:column; gap:16px; padding:16px 24px 20px; border-top:1px solid var(--border); background:var(--bg2); }
    .mob-menu.open { display:flex; }
    .mob-menu a { color:var(--muted); font-size:15px; }

    /* ── SECTIONS ── */
    section { position:relative; z-index:1; }
    .container { max-width:1100px; margin:0 auto; padding:0 24px; }
    .container-sm { max-width:760px; margin:0 auto; padding:0 24px; }

    /* ── HERO ── */
    .hero { min-height:100vh; display:flex; align-items:center; padding:120px 24px 80px; max-width:1100px; margin:0 auto; }
    .hero-content { max-width:660px; }
    .hero-eyebrow { display:inline-flex; align-items:center; gap:8px; font-size:12px; color:var(--greent); font-weight:500; background:rgba(74,222,128,0.08); border:1px solid rgba(74,222,128,0.22); padding:5px 14px; border-radius:999px; margin-bottom:28px; letter-spacing:0.04em; }
    .hero-dot { width:7px; height:7px; border-radius:50%; background:var(--greent); animation:blink 2s ease-in-out infinite; }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.35} }
    .hero h1 { font-family:'Syne',sans-serif; font-size:clamp(40px,6vw,72px); font-weight:800; line-height:1.06; letter-spacing:-0.03em; margin-bottom:24px; }
    .hero h1 span { color:var(--greent); }
    .hero-sub { font-size:18px; color:var(--muted); line-height:1.7; max-width:520px; margin-bottom:36px; font-weight:300; }
    .hero-ctas { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:48px; }
    .btn-primary { display:inline-flex; align-items:center; gap:8px; background:var(--green); color:#0a0e13; font-weight:600; font-size:15px; padding:13px 28px; border-radius:var(--r); border:none; cursor:pointer; transition:background 0.2s,transform 0.15s; }
    .btn-primary:hover { background:var(--greend); transform:translateY(-1px); }
    .btn-secondary { display:inline-flex; align-items:center; gap:8px; background:transparent; color:var(--text); font-size:15px; padding:13px 28px; border-radius:var(--r); border:1px solid rgba(255,255,255,0.14); cursor:pointer; transition:all 0.2s; }
    .btn-secondary:hover { border-color:rgba(255,255,255,0.28); background:rgba(255,255,255,0.04); }
    .hero-trust { display:flex; align-items:center; gap:16px; font-size:13px; color:var(--muted); flex-wrap:wrap; }
    .hero-trust span { display:flex; align-items:center; gap:6px; }
    .hero-trust span::before { content:'✓'; color:var(--greent); font-weight:600; }

    /* ── PROBLEM SECTION ── */
    .problem { padding:80px 0; background:var(--bg2); border-top:1px solid var(--border); border-bottom:1px solid var(--border); }
    .problem-grid { display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:center; }
    .problem-label { font-size:11px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:#f87171; margin-bottom:12px; }
    .problem h2 { font-family:'Syne',sans-serif; font-size:clamp(26px,3.5vw,36px); font-weight:700; letter-spacing:-0.02em; margin-bottom:16px; }
    .problem-sub { font-size:15px; color:var(--muted); line-height:1.75; margin-bottom:28px; font-weight:300; }
    .pain-list { display:flex; flex-direction:column; gap:14px; }
    .pain-item { display:flex; align-items:flex-start; gap:12px; padding:14px 16px; background:rgba(248,81,73,0.06); border:1px solid rgba(248,81,73,0.15); border-radius:var(--r); }
    .pain-icon { font-size:18px; flex-shrink:0; margin-top:1px; }
    .pain-text { font-size:14px; color:var(--muted); line-height:1.6; }
    .pain-text strong { color:var(--text); font-weight:500; }

    /* ── HOW IT WORKS ── */
    .how { padding:100px 0; }
    .section-eyebrow { font-size:11px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:var(--greent); margin-bottom:12px; display:flex; align-items:center; gap:9px; }
    .section-eyebrow::before { content:''; width:18px; height:2px; background:var(--greend); border-radius:2px; display:block; }
    .section-title { font-family:'Syne',sans-serif; font-size:clamp(26px,3.5vw,38px); font-weight:700; letter-spacing:-0.02em; margin-bottom:10px; }
    .section-sub { font-size:15px; color:var(--muted); margin-bottom:56px; font-weight:300; max-width:520px; }
    .steps-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
    .step-card { background:var(--bg2); border:1px solid var(--border); border-radius:var(--rl); padding:28px; position:relative; transition:border-color 0.22s; }
    .step-card:hover { border-color:var(--border-h); }
    .step-num { font-family:'Syne',sans-serif; font-size:48px; font-weight:800; color:rgba(48,220,128,0.12); line-height:1; margin-bottom:16px; }
    .step-icon { font-size:28px; margin-bottom:12px; }
    .step-title { font-family:'Syne',sans-serif; font-size:17px; font-weight:700; margin-bottom:8px; }
    .step-desc { font-size:14px; color:var(--muted); line-height:1.7; }
    .step-arrow { display:none; }

    /* ── ROLES ── */
    .roles { padding:100px 0; background:var(--bg2); border-top:1px solid var(--border); border-bottom:1px solid var(--border); }
    .roles-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-top:56px; }
    .role-card { background:var(--bg3); border:1px solid var(--border); border-radius:var(--rl); padding:28px; transition:border-color 0.22s,transform 0.22s; }
    .role-card:hover { border-color:var(--border-h); transform:translateY(-4px); }
    .role-icon-wrap { width:52px; height:52px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:24px; margin-bottom:18px; }
    .role-icon-green  { background:rgba(48,220,128,0.1); border:1px solid rgba(48,220,128,0.2); }
    .role-icon-blue   { background:rgba(96,165,250,0.1); border:1px solid rgba(96,165,250,0.2); }
    .role-icon-orange { background:rgba(251,146,60,0.1); border:1px solid rgba(251,146,60,0.2); }
    .role-badge { display:inline-block; font-size:10px; font-weight:600; padding:3px 10px; border-radius:999px; margin-bottom:12px; letter-spacing:0.06em; text-transform:uppercase; }
    .badge-green  { background:rgba(48,220,128,0.1); color:var(--greent); border:1px solid rgba(48,220,128,0.2); }
    .badge-blue   { background:rgba(96,165,250,0.1); color:#60a5fa; border:1px solid rgba(96,165,250,0.2); }
    .badge-orange { background:rgba(251,146,60,0.1); color:#fb923c; border:1px solid rgba(251,146,60,0.2); }
    .role-title { font-family:'Syne',sans-serif; font-size:18px; font-weight:700; margin-bottom:8px; }
    .role-desc { font-size:14px; color:var(--muted); line-height:1.7; margin-bottom:18px; }
    .role-features { list-style:none; display:flex; flex-direction:column; gap:8px; }
    .role-features li { font-size:13px; color:var(--muted); display:flex; align-items:flex-start; gap:8px; }
    .role-features li::before { content:'✓'; color:var(--greent); font-weight:700; flex-shrink:0; }

    /* ── FEATURES ── */
    .features { padding:100px 0; }
    .features-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:16px; margin-top:56px; }
    .feat-card { background:var(--bg2); border:1px solid var(--border); border-radius:var(--rl); padding:24px; transition:border-color 0.22s; }
    .feat-card:hover { border-color:var(--border-h); }
    .feat-icon { font-size:24px; margin-bottom:14px; }
    .feat-title { font-family:'Syne',sans-serif; font-size:16px; font-weight:700; margin-bottom:6px; }
    .feat-desc { font-size:13px; color:var(--muted); line-height:1.7; }

    /* ── PRICING ── */
    .pricing { padding:100px 0; background:var(--bg2); border-top:1px solid var(--border); border-bottom:1px solid var(--border); }
    .pricing-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-top:56px; }
    .price-card { background:var(--bg3); border:1px solid var(--border); border-radius:var(--rl); padding:28px; position:relative; transition:border-color 0.22s,transform 0.22s; }
    .price-card:hover { border-color:var(--border-h); transform:translateY(-4px); }
    .price-card.popular { border-color:rgba(48,220,128,0.4); background:rgba(48,220,128,0.04); }
    .popular-badge { position:absolute; top:-12px; left:50%; transform:translateX(-50%); background:var(--green); color:#0a0e13; font-size:11px; font-weight:700; padding:4px 14px; border-radius:999px; letter-spacing:0.06em; white-space:nowrap; }
    .price-name { font-family:'Syne',sans-serif; font-size:16px; font-weight:700; margin-bottom:4px; }
    .price-size { font-size:12px; color:var(--muted); margin-bottom:20px; }
    .price-amount { font-family:'Syne',sans-serif; font-size:34px; font-weight:800; color:var(--greent); margin-bottom:4px; }
    .price-period { font-size:12px; color:var(--muted); margin-bottom:6px; }
    .price-setup { font-size:12px; color:var(--muted); padding:6px 10px; background:rgba(255,255,255,0.04); border-radius:6px; margin-bottom:22px; }
    .price-divider { border:none; border-top:1px solid var(--border); margin:18px 0; }
    .price-features { list-style:none; display:flex; flex-direction:column; gap:10px; margin-bottom:24px; }
    .price-features li { font-size:13px; color:var(--muted); display:flex; align-items:flex-start; gap:8px; }
    .price-features li::before { content:'✓'; color:var(--greent); font-weight:700; flex-shrink:0; }
    .price-cta { width:100%; padding:12px; border-radius:var(--r); font-size:14px; font-weight:600; cursor:pointer; transition:all 0.2s; border:none; }
    .price-cta-outline { background:transparent; color:var(--text); border:1px solid rgba(255,255,255,0.15) !important; }
    .price-cta-outline:hover { border-color:rgba(255,255,255,0.3) !important; background:rgba(255,255,255,0.04); }
    .price-cta-solid { background:var(--green); color:#0a0e13; }
    .price-cta-solid:hover { background:var(--greend); }
    .annual-note { text-align:center; margin-top:20px; font-size:13px; color:var(--muted); }
    .annual-note strong { color:var(--greent); }

    /* ── TRUST ── */
    .trust { padding:80px 0; }
    .trust-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:24px; margin-top:48px; }
    .trust-item { text-align:center; padding:28px 20px; background:var(--bg2); border:1px solid var(--border); border-radius:var(--rl); }
    .trust-num { font-family:'Syne',sans-serif; font-size:40px; font-weight:800; color:var(--greent); margin-bottom:6px; }
    .trust-label { font-size:13px; color:var(--muted); }

    /* ── CTA BANNER ── */
    .cta-banner { padding:100px 0; }
    .cta-box { background:linear-gradient(135deg,rgba(48,220,128,0.08) 0%,rgba(48,220,128,0.02) 100%); border:1px solid rgba(48,220,128,0.2); border-radius:24px; padding:60px 48px; text-align:center; }
    .cta-box h2 { font-family:'Syne',sans-serif; font-size:clamp(28px,4vw,44px); font-weight:800; letter-spacing:-0.02em; margin-bottom:16px; }
    .cta-box p { font-size:16px; color:var(--muted); max-width:480px; margin:0 auto 36px; font-weight:300; }
    .cta-btns { display:flex; gap:12px; justify-content:center; flex-wrap:wrap; }

    /* ── CONTACT ── */
    .contact { padding:100px 0; background:var(--bg2); border-top:1px solid var(--border); }
    .contact-grid { display:grid; grid-template-columns:1fr 1fr; gap:60px; align-items:start; }
    .contact-info h2 { font-family:'Syne',sans-serif; font-size:clamp(24px,3vw,34px); font-weight:700; letter-spacing:-0.02em; margin-bottom:12px; }
    .contact-info p { font-size:15px; color:var(--muted); line-height:1.75; margin-bottom:28px; font-weight:300; }
    .contact-channels { display:flex; flex-direction:column; gap:12px; }
    .contact-ch { display:flex; align-items:center; gap:12px; padding:14px 16px; background:var(--bg3); border:1px solid var(--border); border-radius:var(--r); font-size:14px; color:var(--text); transition:border-color 0.2s; }
    .contact-ch:hover { border-color:var(--border-h); }
    .contact-ch-icon { font-size:20px; }
    .contact-ch-label { color:var(--muted); font-size:12px; }
    .form-wrap { background:var(--bg3); border:1px solid var(--border); border-radius:var(--rl); padding:32px; }
    .form-title { font-family:'Syne',sans-serif; font-size:18px; font-weight:700; margin-bottom:4px; }
    .form-sub { font-size:13px; color:var(--muted); margin-bottom:22px; }
    .form-group { margin-bottom:14px; }
    .form-group label { display:block; font-size:12px; color:var(--muted); margin-bottom:5px; }
    .form-input { width:100%; background:var(--bg); border:1px solid rgba(255,255,255,0.09); border-radius:var(--r); color:var(--text); font-family:'DM Sans',sans-serif; font-size:14px; padding:10px 13px; outline:none; transition:border-color 0.2s; }
    .form-input:focus { border-color:rgba(74,222,128,0.4); }
    textarea.form-input { min-height:90px; resize:vertical; }
    select.form-input { cursor:pointer; }
    .form-submit { width:100%; background:var(--green); color:#0a0e13; border:none; border-radius:var(--r); font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600; padding:12px; cursor:pointer; transition:background 0.2s,transform 0.15s; margin-top:4px; }
    .form-submit:hover { background:var(--greend); transform:translateY(-1px); }

    /* ── FOOTER ── */
    footer { padding:32px 24px; border-top:1px solid var(--border); }
    .footer-inner { max-width:1100px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; }
    .footer-brand { font-family:'Syne',sans-serif; font-size:16px; font-weight:800; color:var(--greent); }
    .footer-links { display:flex; gap:20px; }
    .footer-links a { font-size:13px; color:var(--muted); transition:color 0.2s; }
    .footer-links a:hover { color:var(--text); }
    .footer-copy { font-size:12px; color:var(--muted); }

    /* ── RESPONSIVE ── */
    @media (max-width:768px) {
      .nav-links { display:none; }
      .ham { display:block; }
      .problem-grid { grid-template-columns:1fr; gap:40px; }
      .steps-grid { grid-template-columns:1fr; }
      .roles-grid { grid-template-columns:1fr; }
      .pricing-grid { grid-template-columns:1fr; }
      .contact-grid { grid-template-columns:1fr; gap:40px; }
      .cta-box { padding:40px 24px; }
      .hero { padding:100px 24px 60px; }
    }
    @media (max-width:480px) {
      .features-grid { grid-template-columns:1fr; }
      .trust-grid { grid-template-columns:1fr 1fr; }
    }
  </style>
</head>
<body>

<div class="grid-bg"></div>

<!-- NAV -->
<nav>
  <div class="nav-inner">
    <div class="nav-brand">
      <img src="/public/assets/icons/favicon-32.png" alt="Les Passe" />
      <span class="nav-brand-text">Les Passe</span>
    </div>
    <div class="nav-links">
      <a href="#how">How it works</a>
      <a href="#pricing">Pricing</a>
      <a href="#contact">Contact</a>
      <a href="/auth/login" class="nav-cta">Sign in</a>
    </div>
    <button class="ham" id="ham" aria-label="Menu">&#9776;</button>
  </div>
  <div class="mob-menu" id="mob-menu">
    <a href="#how">How it works</a>
    <a href="#pricing">Pricing</a>
    <a href="#contact">Contact</a>
    <a href="/auth/login" style="color:var(--greent);">Sign in →</a>
  </div>
</nav>

<!-- HERO -->
<section>
  <div class="hero">
    <div class="hero-content">
      <div class="hero-eyebrow">
        <span class="hero-dot"></span>
        Now live — serving Lagos gated estates
      </div>
      <h1>Your estate gate,<br><span>finally digital.</span></h1>
      <p class="hero-sub">Les Passe replaces your visitor book and gate phone calls with a smart digital access system. Residents generate passes, guards verify instantly, you see everything.</p>
      <div class="hero-ctas">
        <a href="#contact" class="btn-primary">Get started free →</a>
        <a href="/auth/login" class="btn-secondary">View live demo</a>
      </div>
      <div class="hero-trust">
        <span>30-day free trial</span>
        <span>No setup hassle</span>
        <span>Works on any phone</span>
        <span>Lagos-built</span>
      </div>
    </div>
  </div>
</section>

<!-- PROBLEM -->
<section class="problem" id="problem">
  <div class="container">
    <div class="problem-grid">
      <div>
        <div class="problem-label">⚠ The problem</div>
        <h2>The visitor book isn't working.</h2>
        <p class="problem-sub">Most Lagos estates still use a physical visitor book, a phone call to the resident, and a guard who has to remember faces. It's slow, it gets abused, and there's zero audit trail when something goes wrong.</p>
        <p style="font-size:15px;color:var(--muted);font-weight:300;line-height:1.75;">Sound familiar? You're not alone. Hundreds of estates across Lekki, Ajah, VGC, GRA, and Magodo deal with the same problems every day.</p>
      </div>
      <div class="pain-list">
        <div class="pain-item">
          <div class="pain-icon">📋</div>
          <div class="pain-text"><strong>The physical visitor book</strong> — handwriting nobody can read, pages that go missing, no way to check who came in last Tuesday.</div>
        </div>
        <div class="pain-item">
          <div class="pain-icon">📞</div>
          <div class="pain-text"><strong>Calling the resident every time</strong> — phone is off, not answering, number is wrong. Visitor waits at the gate for 20 minutes.</div>
        </div>
        <div class="pain-item">
          <div class="pain-icon">🚪</div>
          <div class="pain-text"><strong>Guards letting people in on trust</strong> — "I'm here to see Flat 5B" and the guard waves them through. No verification, no record.</div>
        </div>
        <div class="pain-item">
          <div class="pain-icon">❓</div>
          <div class="pain-text"><strong>No audit trail</strong> — when something goes missing or goes wrong, there's no way to know who came in and when.</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how" id="how">
  <div class="container">
    <div class="section-eyebrow">How it works</div>
    <h2 class="section-title">Three steps. Done.</h2>
    <p class="section-sub">No training required. No new hardware. Works on the phones your residents and guards already have.</p>
    <div class="steps-grid">
      <div class="step-card">
        <div class="step-num">01</div>
        <div class="step-icon">📱</div>
        <div class="step-title">Resident generates a pass</div>
        <div class="step-desc">From their phone, the resident opens Les Passe, enters their visitor's name, picks how long the pass should last (1, 3, or 6 hours), and taps generate. A 6-digit code and QR code appear instantly.</div>
      </div>
      <div class="step-card">
        <div class="step-num">02</div>
        <div class="step-icon">💬</div>
        <div class="step-title">Visitor receives the pass</div>
        <div class="step-desc">The resident shares the code via WhatsApp in seconds. The visitor arrives at the gate and shows the code or QR on their phone. No app download needed for visitors.</div>
      </div>
      <div class="step-card">
        <div class="step-num">03</div>
        <div class="step-icon">✅</div>
        <div class="step-title">Guard verifies and grants access</div>
        <div class="step-desc">The guard types the 6-digit code or scans the QR on any Android or iPhone. The screen shows green for valid, red for invalid or expired. One tap, done. The entry is logged automatically.</div>
      </div>
    </div>
  </div>
</section>

<!-- ROLES -->
<section class="roles" id="roles">
  <div class="container">
    <div class="section-eyebrow">Who uses Les Passe</div>
    <h2 class="section-title">Built for everyone at the gate.</h2>
    <p class="section-sub">Three roles, three dashboards. Everyone sees exactly what they need and nothing they don't.</p>
    <div class="roles-grid">
      <div class="role-card">
        <div class="role-icon-wrap role-icon-green">🏠</div>
        <div class="role-badge badge-green">Resident</div>
        <div class="role-title">Residents</div>
        <div class="role-desc">Generate and manage visitor passes from anywhere. Share them via WhatsApp in seconds.</div>
        <ul class="role-features">
          <li>Generate passes with 1, 3, or 6 hour expiry</li>
          <li>6-digit code + QR code on every pass</li>
          <li>Share instantly via WhatsApp</li>
          <li>Cancel active passes anytime</li>
          <li>View full pass history</li>
        </ul>
      </div>
      <div class="role-card">
        <div class="role-icon-wrap role-icon-orange">🛡️</div>
        <div class="role-badge badge-orange">Security</div>
        <div class="role-title">Security Guards</div>
        <div class="role-desc">Simple, fast verification. Big buttons, clear results. Works perfectly on a ₦30k Android phone.</div>
        <ul class="role-features">
          <li>Type code or scan QR to verify</li>
          <li>Instant green/red result screen</li>
          <li>Detects expired and already-used passes</li>
          <li>No training needed — one screen interface</li>
          <li>Works on slow 3G connections</li>
        </ul>
      </div>
      <div class="role-card">
        <div class="role-icon-wrap role-icon-blue">📊</div>
        <div class="role-badge badge-blue">Admin</div>
        <div class="role-title">Estate Admin</div>
        <div class="role-desc">Full visibility and control. Manage residents and guards, see every entry, audit any incident.</div>
        <ul class="role-features">
          <li>Dashboard with today's passes and entries</li>
          <li>Complete entry log with timestamps</li>
          <li>Add, suspend, or remove residents</li>
          <li>Create and manage guard accounts</li>
          <li>See which guard verified each entry</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="features" id="features">
  <div class="container">
    <div class="section-eyebrow">Features</div>
    <h2 class="section-title">Everything your estate needs.</h2>
    <p class="section-sub">No bloat, no unnecessary complexity. Just the features that make gate management actually work.</p>
    <div class="features-grid">
      <div class="feat-card">
        <div class="feat-icon">🔢</div>
        <div class="feat-title">6-digit access codes</div>
        <div class="feat-desc">Every pass gets a unique 6-digit code. Easy to read aloud, easy to type. No app download required for visitors.</div>
      </div>
      <div class="feat-card">
        <div class="feat-icon">🔲</div>
        <div class="feat-title">QR code on every pass</div>
        <div class="feat-desc">Visitors can show their QR code for even faster gate entry. Guards scan directly from the visitor's phone screen.</div>
      </div>
      <div class="feat-card">
        <div class="feat-icon">⏱️</div>
        <div class="feat-title">Time-limited passes</div>
        <div class="feat-desc">Choose 1, 3, or 6 hour validity. Passes expire automatically — no manual cleanup, no codes that work forever.</div>
      </div>
      <div class="feat-card">
        <div class="feat-icon">📱</div>
        <div class="feat-title">WhatsApp sharing</div>
        <div class="feat-desc">Residents share passes the way Lagos already communicates — via WhatsApp. No extra apps, no learning curve.</div>
      </div>
      <div class="feat-card">
        <div class="feat-icon">📋</div>
        <div class="feat-title">Complete audit trail</div>
        <div class="feat-desc">Every entry attempt is logged — successful or denied — with the time, guard name, and visitor details. Searchable at any time.</div>
      </div>
      <div class="feat-card">
        <div class="feat-icon">👥</div>
        <div class="feat-title">Multi-role access</div>
        <div class="feat-desc">Admin, resident, and guard accounts. Each person sees only what they need. Proper security from day one.</div>
      </div>
      <div class="feat-card">
        <div class="feat-icon">📵</div>
        <div class="feat-title">Works on any phone</div>
        <div class="feat-desc">Designed for real Lagos conditions. Works on cheap Android phones, slow 3G connections, and outdoor bright light.</div>
      </div>
      <div class="feat-card">
        <div class="feat-icon">🔒</div>
        <div class="feat-title">One-time use passes</div>
        <div class="feat-desc">Once a pass is used at the gate, it can't be reused. No code sharing abuse, no unauthorized re-entry.</div>
      </div>
      <div class="feat-card">
        <div class="feat-icon">⚡</div>
        <div class="feat-title">Instant verification</div>
        <div class="feat-desc">Results appear in under a second. No lag, no loading screens. Guards can keep the queue moving.</div>
      </div>
    </div>
  </div>
</section>

<!-- PRICING -->
<section class="pricing" id="pricing">
  <div class="container">
    <div class="section-eyebrow">Pricing</div>
    <h2 class="section-title">Simple, honest pricing.</h2>
    <p class="section-sub">Priced for Nigerian estates — from small residential closes to large gated communities. Every plan includes a 30-day free trial.</p>
    <div class="pricing-grid">
      <div class="price-card">
        <div class="price-name">Starter</div>
        <div class="price-size">6–30 residents</div>
        <div class="price-amount">₦15,000</div>
        <div class="price-period">per month</div>
        <div class="price-setup">+ ₦50,000 one-time setup fee</div>
        <hr class="price-divider" />
        <ul class="price-features">
          <li>Up to 30 resident accounts</li>
          <li>Unlimited visitor passes</li>
          <li>1 guard account</li>
          <li>Entry logs (30 days)</li>
          <li>WhatsApp sharing</li>
          <li>Email support</li>
        </ul>
        <button class="price-cta price-cta-outline" onclick="document.getElementById('contact').scrollIntoView({behavior:'smooth'})">Get started</button>
      </div>

      <div class="price-card popular">
        <div class="popular-badge">⭐ Most Popular</div>
        <div class="price-name">Growth</div>
        <div class="price-size">31–200 residents</div>
        <div class="price-amount">₦35,000</div>
        <div class="price-period">per month</div>
        <div class="price-setup">+ ₦75,000 one-time setup fee</div>
        <hr class="price-divider" />
        <ul class="price-features">
          <li>Up to 200 resident accounts</li>
          <li>Unlimited visitor passes</li>
          <li>5 guard accounts</li>
          <li>Entry logs (90 days)</li>
          <li>WhatsApp sharing</li>
          <li>Priority support</li>
          <li>Monthly activity report</li>
        </ul>
        <button class="price-cta price-cta-solid" onclick="document.getElementById('contact').scrollIntoView({behavior:'smooth'})">Get started</button>
      </div>

      <div class="price-card">
        <div class="price-name">Estate Pro</div>
        <div class="price-size">201–2000+ residents</div>
        <div class="price-amount">₦75,000</div>
        <div class="price-period">per month</div>
        <div class="price-setup">+ ₦100,000 one-time setup fee</div>
        <hr class="price-divider" />
        <ul class="price-features">
          <li>Unlimited resident accounts</li>
          <li>Unlimited visitor passes</li>
          <li>Unlimited guard accounts</li>
          <li>Full audit logs (unlimited)</li>
          <li>Multiple gate support</li>
          <li>Custom estate branding</li>
          <li>Dedicated support</li>
        </ul>
        <button class="price-cta price-cta-outline" onclick="document.getElementById('contact').scrollIntoView({behavior:'smooth'})">Contact us</button>
      </div>
    </div>
    <p class="annual-note">Pay annually and save <strong>17%</strong> — Starter ₦150k/yr · Growth ₦350k/yr · Pro ₦750k/yr</p>
  </div>
</section>

<!-- TRUST STATS -->
<section class="trust">
  <div class="container">
    <div class="section-eyebrow">Why Les Passe</div>
    <h2 class="section-title">Built specifically for Lagos.</h2>
    <p class="section-sub" style="margin-bottom:0;">Not a foreign product retrofitted for Nigeria. Built from scratch by a Lagos developer who understands how estates here actually operate.</p>
    <div class="trust-grid">
      <div class="trust-item">
        <div class="trust-num">&lt;1s</div>
        <div class="trust-label">Pass verification time</div>
      </div>
      <div class="trust-item">
        <div class="trust-num">3</div>
        <div class="trust-label">Role types (admin, resident, guard)</div>
      </div>
      <div class="trust-item">
        <div class="trust-num">24/7</div>
        <div class="trust-label">Always online, no downtime</div>
      </div>
      <div class="trust-item">
        <div class="trust-num">₦0</div>
        <div class="trust-label">Cost for first 30 days</div>
      </div>
    </div>
  </div>
</section>

<!-- CTA BANNER -->
<section class="cta-banner">
  <div class="container">
    <div class="cta-box">
      <h2>Ready to upgrade your gate security?</h2>
      <p>Get set up in one afternoon. We handle everything — from creating your estate's accounts to training your security team.</p>
      <div class="cta-btns">
        <a href="#contact" class="btn-primary">Start your free trial →</a>
        <a href="/auth/login" class="btn-secondary">See it live first</a>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section class="contact" id="contact">
  <div class="container">
    <div class="contact-grid">
      <div class="contact-info">
        <div class="section-eyebrow">Get in touch</div>
        <h2>Let's set up your estate.</h2> 
        <p>Send us a message and we'll get back to you within 24 hours. We'll walk you through how Les Passe works, answer your questions, and set up a free trial for your estate.</p>
        <div class="contact-channels">
          <a href="https://wa.me/2349052369958?text=Hi%2C%20I%27m%20interested%20in%20Les%20Passe%20for%20my%20estate." target="_blank" class="contact-ch">
            <div class="contact-ch-icon">📱</div>
            <div>
              <div class="contact-ch-label">WhatsApp — fastest response</div>
              <div style="font-size:14px;font-weight:500;">+234 905 236 9958</div>
            </div>
          </a>
          <a href="mailto:simeondavid@lespasse.ng" class="contact-ch">
            <div class="contact-ch-icon">✉️</div>
            <div>
              <div class="contact-ch-label">Email</div>
              <div style="font-size:14px;font-weight:500;">simeondavid@lespasse.ng</div>
            </div>
          </a>
        </div>
      </div>

      <div class="form-wrap">
        <div class="form-title">Request a free trial</div>
        <div class="form-sub">Fill in your details and we'll be in touch within 24 hours.</div>
        <form onsubmit="handleForm(event)">
          <div class="form-group">
            <label>Your name</label>
            <input type="text" class="form-input" placeholder="e.g. Chukwuemeka Ade" required id="f-name" />
          </div>
          <div class="form-group">
            <label>Estate name</label>
            <input type="text" class="form-input" placeholder="e.g. Greenfield Estate, Lekki" required id="f-estate" />
          </div>
          <div class="form-group">
            <label>Approximate number of units</label>
            <select class="form-input" id="f-size">
              <option value="">Select estate size</option>
              <option>6–30 units (Starter)</option>
              <option>31–200 units (Growth)</option>
              <option>200+ units (Pro)</option>
            </select>
          </div>
          <div class="form-group">
            <label>WhatsApp number</label>
            <input type="tel" class="form-input" placeholder="080XXXXXXXX" required id="f-phone" />
          </div>
          <div class="form-group">
            <label>Anything else? <span style="color:var(--muted);font-size:11px;">(optional)</span></label>
            <textarea class="form-input" placeholder="Tell us about your estate's current security setup..." id="f-msg"></textarea>
          </div>
          <button type="submit" class="form-submit">Send request →</button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-inner">
    <div class="footer-brand">Les Passe</div>
    <div class="footer-links">
      <a href="#how">How it works</a>
      <a href="#pricing">Pricing</a>
      <a href="/auth/login">Sign in</a>
    </div>
    <div class="footer-copy">© <?= date('Y') ?> Les Passe · Secure Access. Total Control.</div>
  </div>
</footer>

<script>
  // Hamburger
  document.getElementById('ham').addEventListener('click', () => {
    document.getElementById('mob-menu').classList.toggle('open');
  });
  document.querySelectorAll('#mob-menu a').forEach(a => {
    a.addEventListener('click', () => document.getElementById('mob-menu').classList.remove('open'));
  });

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) { e.preventDefault(); target.scrollIntoView({ behavior:'smooth' }); }
    });
  });

  // Contact form
  function handleForm(e) {
    e.preventDefault();
    const name   = document.getElementById('f-name').value;
    const estate = document.getElementById('f-estate').value;
    const size   = document.getElementById('f-size').value;
    const phone  = document.getElementById('f-phone').value;
    const msg    = document.getElementById('f-msg').value;
    const text   = `New Les Passe trial request:\n\nName: ${name}\nEstate: ${estate}\nSize: ${size}\nPhone: ${phone}\nMessage: ${msg || 'None'}`;
    window.open('https://wa.me/2348143336222?text=' + encodeURIComponent(text), '_blank');
  }

  // Fade in on scroll
  const io = new IntersectionObserver(entries => {
    entries.forEach(e => { if(e.isIntersecting) { e.target.style.opacity='1'; e.target.style.transform='translateY(0)'; io.unobserve(e.target); } });
  }, { threshold: 0.08 });
  document.querySelectorAll('.step-card,.role-card,.feat-card,.price-card,.trust-item').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.55s ease, transform 0.55s ease';
    io.observe(el);
  });
</script>
</body>
</html>