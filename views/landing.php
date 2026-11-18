<?php
// ============================================================
//  Les Passe — landing page (served at "/")
//  Edit only the values in this first block.
// ============================================================
$waNumber  = '09052369958';                    // WhatsApp number, international format, no "+" (e.g. '2348012345678'). Empty = WhatsApp button hidden
$instagram = '';                    // Instagram handle without "@". Empty = icon hidden
$xHandle   = '';                    // X handle without "@". Empty = icon hidden
$email     = 'hello@lespasse.ng';

$plans = [
    ['name' => 'Starter', 'size' => '6–30 residents', 'price' => '₦15,000', 'setup' => '₦50,000', 'popular' => false,
     'features' => ['Up to 30 resident accounts', 'Unlimited visitor passes', '3 guard accounts', '30 days of entry logs', 'WhatsApp sharing', 'Email support']],
    ['name' => 'Growth', 'size' => '31–200 residents', 'price' => '₦35,000', 'setup' => '₦75,000', 'popular' => true,
     'features' => ['Up to 200 resident accounts', 'Unlimited visitor passes', '10 guard accounts', '90 days of entry logs', 'WhatsApp sharing', 'Priority support, same-day replies']],
    ['name' => 'Estate Pro', 'size' => '201–2000+ residents', 'price' => '₦75,000', 'setup' => '₦100,000', 'popular' => false,
     'features' => ['Unlimited resident accounts', 'Unlimited visitor passes', 'Unlimited guard accounts', 'Full entry history', 'Direct WhatsApp support line', 'Multiple gates (coming soon)', 'Custom estate branding (coming soon)']],
];

$faqs = [
    ['Do visitors need to install anything?', 'No. A visitor just receives a 6-digit code (and a QR link if the resident sends one) on WhatsApp and shows it at the gate.'],
    ['Does the gate need internet?', 'Yes. The guard’s phone needs a data connection to check a pass, and there is no offline mode yet. If the network drops, guards fall back to your usual manual process until it returns.'],
    ['What happens when a pass expires or has been used?', 'Every pass has a time window and works once. If it has expired, been cancelled or already used, the guard sees a clear red result and the attempt is logged.'],
    ['Who creates resident and guard accounts?', 'Your estate admin. We set up your estate, create the admin account and help you load residents and guards. Bulk import from a spreadsheet is coming soon.'],
    ['How long does setup take?', 'For a small estate, usually an afternoon: we create the estate, add your admin, load residents and guards, and walk your security team through the gate screen.'],
    ['What data do you store?', 'Resident and guard account details, the visitor names and optional phone numbers residents enter, and a log of every pass and gate check. Details are in our <a href="/privacy">Privacy Policy</a>.'],
    ['Who owns our data?', 'Your estate does. We process it on your behalf to run the service, and we delete it or hand it back if you leave.'],
    ['Does Les Passe replace our security guards?', 'No. It gives guards a fast, reliable way to check visitors. The decision at the gate always stays with your security team.'],
    ['Can we pause or cancel?', 'Plans are monthly and you can cancel at any time. If a payment is overdue, we give notice before pausing access. See our <a href="/terms">Terms</a>.'],
];

$roleHome  = ['admin' => '/admin', 'resident' => '/resident', 'guard' => '/guard'];
$signedIn  = is_logged_in();
$dashUrl   = $signedIn ? ($roleHome[current_role()] ?? '/auth/login') : '/auth/login';
$dashLabel = $signedIn ? 'Open dashboard' : 'Sign in';

// ---------- helpers ----------
function lp_icon(string $name, int $size = 22): string {
    static $paths = [
        'shield'    => '<path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6l8-3z"/><path d="M8.5 12l2.5 2.5L16 9.5"/>',
        'qr'        => '<rect x="3" y="3" width="6" height="6" rx="1"/><rect x="15" y="3" width="6" height="6" rx="1"/><rect x="3" y="15" width="6" height="6" rx="1"/><path d="M15 15h2v2h-2zM19 15h2M15 19h2M19 19h2v2"/>',
        'clock'     => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'chat'      => '<path d="M21 12a8 8 0 0 1-11.6 7.1L4 21l1.9-5.4A8 8 0 1 1 21 12z"/>',
        'clipboard' => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4h6v3H9zM8.5 12h7M8.5 16h5"/>',
        'users'     => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.6 2.9-6 6.5-6s6.5 2.4 6.5 6"/><circle cx="17" cy="9" r="2.5"/><path d="M17.5 14c2.5.3 4 2.2 4 5"/>',
        'phone'     => '<rect x="7" y="2.5" width="10" height="19" rx="2.5"/><path d="M11 18.5h2"/>',
        'lock'      => '<rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/>',
        'bolt'      => '<path d="M13 2L4 14h7l-1 8 9-12h-7l1-8z"/>',
        'book'      => '<path d="M4 5a2 2 0 0 1 2-2h12v17H6a2 2 0 0 0-2 2V5z"/><path d="M8 7h7M8 11h5"/>',
        'call'      => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/>',
        'search'    => '<circle cx="11" cy="11" r="6"/><path d="M20 20l-4-4"/>',
        'door'      => '<path d="M5 21V4a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v17M3 21h18"/><circle cx="12.5" cy="12.5" r="0.8"/>',
        'home'      => '<path d="M4 21V10l8-6 8 6v11M9 21v-6h6v6"/>',
        'chart'     => '<path d="M4 20V4M4 20h16M8 16v-5M12 16V8M16 16v-3"/>',
        'mail'      => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
        'instagram' => '<rect x="3.5" y="3.5" width="17" height="17" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17" cy="7" r="0.7"/>',
        'x'         => '<path d="M4 4l16 16M20 4L4 20"/>',
        'arrow'     => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'check'     => '<path d="M5 12.5l4.5 4.5L19 7.5"/>',
        'key'       => '<circle cx="8" cy="15" r="4"/><path d="M11 12l9-9M16 7l3 3"/>',
        'hash'      => '<path d="M5 9h14M5 15h14M10 4L8 20M16 4l-2 16"/>',
    ];
    $d = $paths[$name] ?? '';
    return '<svg class="ic" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $d . '</svg>';
}

// Returns an <img> if the file exists in public/assets/landing/, otherwise an empty string
function lp_shot(string $file, string $alt, bool $eager = false, string $class = ''): string {
    $path = dirname(__DIR__) . '/public/assets/landing/' . $file;
    if (!is_file($path)) return '';
    $size = @getimagesize($path);
    $wh   = $size ? ' width="' . (int) $size[0] . '" height="' . (int) $size[1] . '"' : '';
    $load = $eager ? ' fetchpriority="high"' : ' loading="lazy"';
    return '<img src="/public/assets/landing/' . e($file) . '" alt="' . e($alt) . '"' . $wh . $load . ' class="' . e($class) . '" />';
}

function lp_phone(string $img): string {
    return $img === '' ? '' : '<div class="phone">' . $img . '</div>';
}

$heroShot    = lp_shot('hero-pass-card.webp', 'A Les Passe visitor pass showing the 6-digit access code and QR code', true);
$problemShot = lp_shot('problem-gate.webp', 'A security guard writing in a paper visitors’ book at an estate gate', false, 'photo');
$stepGen     = lp_shot('step-generate.webp', 'A resident creating a visitor pass in Les Passe', false, 'shot-crop');
$stepVerify  = lp_shot('role-guard-granted.webp', 'The Access Granted screen a guard sees after a valid pass is checked', false, 'shot-crop');
$denied      = lp_shot('role-guard-denied.webp', 'The red result screen a guard sees when a pass is expired or invalid', false, '');
$roleRes     = lp_shot('role-resident.webp', 'The resident dashboard with active visitor passes', false, 'shot-crop');
$roleGuard   = lp_shot('role-guard-entry.webp', 'The guard screen with a 6-digit code box and QR scanner', false, 'shot-crop');
$roleAdmin   = lp_shot('role-admin.webp', 'The estate admin dashboard showing today’s passes and gate activity', false, 'shot-crop');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Les Passe — Digital visitor passes for Lagos gated estates</title>
  <meta name="description" content="Replace the visitor book with Les Passe. Residents create a 6-digit pass, guards verify it at the gate, and admins get a full record of every entry. Built for Lagos gated estates." />
  <link rel="canonical" href="https://www.lespasse.ng/" />
  <meta name="theme-color" content="#0a0e13" />

  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="Les Passe" />
  <meta property="og:title" content="Les Passe — Digital visitor passes for Lagos gated estates" />
  <meta property="og:description" content="Residents create a 6-digit pass. Guards verify it at the gate. Admins see every entry." />
  <meta property="og:url" content="https://www.lespasse.ng/" />
  <meta property="og:image" content="https://www.lespasse.ng/public/assets/og-image.jpg" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:image" content="https://www.lespasse.ng/public/assets/og-image.jpg" />

  <link rel="icon" type="image/x-icon" href="/public/assets/icons/favicon.ico" />
  <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/icons/favicon-32.png" />
  <link rel="apple-touch-icon" href="/public/assets/icons/apple-touch-icon.png" />
  <link rel="manifest" href="/manifest.json" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />

  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; scroll-padding-top: 76px; }
    :root {
      --bg:#0a0e13; --bg2:#111620; --bg3:#181e2a;
      --border:rgba(48,220,128,0.12); --border-h:rgba(48,220,128,0.30);
      --green:#30dc80; --greend:#22c55e; --greent:#4ade80; --greenbg:rgba(48,220,128,0.08);
      --muted:#8b949e; --text:#e6edf3; --r:12px; --rl:20px;
    }
    body { background:var(--bg); color:var(--text); font-family:'DM Sans',sans-serif; font-size:16px; line-height:1.65; -webkit-font-smoothing:antialiased; overflow-x:hidden; }
    a { color:inherit; text-decoration:none; }
    img { display:block; max-width:100%; height:auto; }
    .ic { flex-shrink:0; }
    .container { max-width:1100px; margin:0 auto; padding:0 24px; }
    section { position:relative; }
    h1,h2,h3 { font-family:'Syne',sans-serif; letter-spacing:-0.02em; }
    .eyebrow { display:flex; align-items:center; gap:9px; font-size:11px; font-weight:600; letter-spacing:0.12em; text-transform:uppercase; color:var(--greent); margin-bottom:12px; }
    .eyebrow::before { content:''; width:18px; height:2px; background:var(--greend); border-radius:2px; }
    .section-title { font-size:clamp(26px,3.6vw,38px); font-weight:700; margin-bottom:10px; }
    .section-sub { font-size:15px; color:var(--muted); font-weight:300; max-width:540px; margin-bottom:48px; }

    /* NAV */
    nav.top { position:fixed; top:0; left:0; right:0; z-index:100; background:rgba(10,14,19,0.88); backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border-bottom:1px solid var(--border); }
    .nav-inner { max-width:1100px; margin:0 auto; padding:12px 24px; display:flex; align-items:center; justify-content:space-between; }
    .brand { display:flex; align-items:center; gap:10px; }
    .brand img { width:32px; height:32px; border-radius:8px; border:1px solid var(--border); }
    .brand span { font-family:'Syne',sans-serif; font-size:18px; font-weight:800; color:var(--greent); }
    .nav-links { display:flex; align-items:center; gap:26px; }
    .nav-links a { font-size:14px; color:var(--muted); transition:color .2s; }
    .nav-links a:hover { color:var(--text); }
    .nav-links a.btn-nav { background:var(--green); color:#0a0e13; font-weight:600; padding:9px 18px; border-radius:var(--r); }
    .nav-links a.btn-nav:hover { background:var(--greend); color:#0a0e13; }
    .ham { display:none; background:none; border:none; color:var(--text); cursor:pointer; padding:6px; }
    .mob-menu { display:none; flex-direction:column; gap:16px; padding:16px 24px 20px; border-top:1px solid var(--border); background:var(--bg2); }
    .mob-menu.open { display:flex; }
    .mob-menu a { color:var(--muted); font-size:15px; }

    /* BUTTONS */
    .btn { display:inline-flex; align-items:center; gap:8px; font-family:'DM Sans',sans-serif; font-weight:600; font-size:15px; padding:13px 26px; border-radius:var(--r); border:none; cursor:pointer; transition:all .2s; }
    .btn-primary { background:var(--green); color:#0a0e13; }
    .btn-primary:hover { background:var(--greend); transform:translateY(-1px); }
    .btn-ghost { background:transparent; color:var(--text); border:1px solid rgba(255,255,255,0.16); font-weight:500; }
    .btn-ghost:hover { border-color:rgba(255,255,255,0.3); background:rgba(255,255,255,0.04); }

    /* HERO */
    .hero { padding:130px 0 70px; background:radial-gradient(ellipse 70% 50% at 50% 0%, rgba(48,220,128,0.09), transparent 70%); }
    .hero-grid { display:grid; grid-template-columns:1.15fr 0.85fr; gap:48px; align-items:center; }
    .hero-grid.solo { grid-template-columns:1fr; max-width:680px; }
    .pill { display:inline-flex; align-items:center; gap:8px; font-size:12px; color:var(--greent); font-weight:500; background:rgba(74,222,128,0.08); border:1px solid rgba(74,222,128,0.22); padding:5px 14px; border-radius:999px; margin-bottom:26px; }
    .dot { width:7px; height:7px; border-radius:50%; background:var(--greent); animation:blink 2s ease-in-out infinite; }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.35} }
    .hero h1 { font-size:clamp(38px,5.6vw,66px); font-weight:800; line-height:1.06; margin-bottom:22px; }
    .hero h1 span { color:var(--greent); }
    .hero-sub { font-size:18px; color:var(--muted); max-width:520px; font-weight:300; margin-bottom:32px; }
    .hero-ctas { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:34px; }
    .trust { display:flex; flex-wrap:wrap; gap:8px 20px; font-size:13px; color:var(--muted); }
    .trust span { display:flex; align-items:center; gap:6px; }
    .trust .ic { color:var(--greent); }

    .phone { max-width:290px; margin:0 auto; padding:8px; border-radius:38px; background:#1b2330; border:1px solid rgba(255,255,255,0.09); box-shadow:0 30px 70px rgba(0,0,0,.55), 0 0 90px rgba(48,220,128,0.09); }
    .phone img { border-radius:30px; width:100%; height:auto; }

    /* ENTRY STRIP */
    .entry { padding:10px 0 60px; }
    .entry-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
    .entry-card { display:flex; gap:16px; align-items:flex-start; background:var(--bg2); border:1px solid var(--border); border-radius:var(--rl); padding:22px 24px; }
    .icon-box { width:46px; height:46px; border-radius:12px; display:flex; align-items:center; justify-content:center; background:var(--greenbg); border:1px solid var(--border); color:var(--greent); flex-shrink:0; }
    .entry-card h3 { font-size:16px; font-weight:700; margin-bottom:4px; }
    .entry-card p { font-size:14px; color:var(--muted); margin-bottom:12px; }
    .entry-card p:last-child { margin-bottom:0; }
    .link-arrow { display:inline-flex; align-items:center; gap:6px; font-size:14px; font-weight:600; color:var(--greent); }

    /* PROBLEM */
    .problem { padding:84px 0; background:var(--bg2); border-top:1px solid var(--border); border-bottom:1px solid var(--border); }
    .two { display:grid; grid-template-columns:1fr 1fr; gap:56px; align-items:center; }
    .problem h2 { font-size:clamp(26px,3.5vw,36px); margin-bottom:14px; }
    .problem .lead { font-size:15px; color:var(--muted); font-weight:300; margin-bottom:26px; }
    .pains { display:flex; flex-direction:column; gap:12px; }
    .pain { display:flex; gap:14px; align-items:flex-start; padding:14px 16px; background:rgba(248,81,73,0.05); border:1px solid rgba(248,81,73,0.14); border-radius:var(--r); }
    .pain .ic { color:#f87171; margin-top:2px; }
    .pain p { font-size:14px; color:var(--muted); }
    .pain strong { color:var(--text); font-weight:500; }
    .photo { border-radius:var(--rl); border:1px solid var(--border); }
    .logbook { background:#14181f; border:1px solid rgba(255,255,255,0.08); border-radius:16px; padding:22px 22px 18px; transform:rotate(-1.5deg); box-shadow:0 24px 50px rgba(0,0,0,.4); }
    .logbook-title { font-family:'Syne',sans-serif; font-size:13px; letter-spacing:0.14em; text-transform:uppercase; color:var(--muted); margin-bottom:14px; }
    .lb-head, .lb-row { display:grid; grid-template-columns:1.4fr 0.8fr 0.8fr; gap:10px; padding:9px 0; border-bottom:1px dashed rgba(255,255,255,0.12); font-size:14px; }
    .lb-head { color:var(--muted); font-size:11px; text-transform:uppercase; letter-spacing:0.1em; }
    .lb-row { font-style:italic; color:#b9c0c8; }
    .lb-row .faint { opacity:.35; }
    .lb-note { margin-top:16px; font-size:13px; color:#f87171; font-style:italic; }

    /* HOW */
    .how { padding:96px 0; }
    .steps { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
    .step { background:var(--bg2); border:1px solid var(--border); border-radius:var(--rl); padding:26px; display:flex; flex-direction:column; transition:border-color .22s; }
    .step:hover { border-color:var(--border-h); }
    .step-num { font-family:'Syne',sans-serif; font-size:44px; font-weight:800; color:rgba(48,220,128,0.14); line-height:1; margin-bottom:10px; }
    .step h3 { font-size:17px; margin-bottom:8px; }
    .step p { font-size:14px; color:var(--muted); margin-bottom:20px; }
    .step-visual { margin-top:auto; }
    .shot-crop { width:100%; height:340px; object-fit:cover; object-position:top; border-radius:14px; border:1px solid rgba(255,255,255,0.08); }
    .visual-icon { height:150px; display:flex; align-items:center; justify-content:center; border-radius:14px; background:var(--bg3); border:1px solid var(--border); color:var(--greent); }
    .wa { background:#0b141a; border-radius:14px; padding:18px 14px; border:1px solid rgba(255,255,255,0.06); }
    .wa-bubble { background:#005c4b; color:#e9edef; border-radius:10px 10px 10px 2px; padding:10px 12px 6px; font-size:13px; line-height:1.5; max-width:94%; }
    .wa-bubble b { font-weight:500; color:#fff; }
    .wa-time { text-align:right; font-size:11px; color:rgba(233,237,239,.6); margin-top:2px; }

    /* WHY */
    .why { padding:84px 0; background:var(--bg2); border-top:1px solid var(--border); border-bottom:1px solid var(--border); }
    .why-grid { display:grid; grid-template-columns:1.1fr 0.9fr; gap:56px; align-items:center; }
    .why-grid.solo { grid-template-columns:1fr; }
    .stats { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .why-grid.solo .stats { grid-template-columns:repeat(4,1fr); }
    .stat { background:var(--bg3); border:1px solid var(--border); border-radius:var(--rl); padding:22px; }
    .stat b { display:block; font-family:'Syne',sans-serif; font-size:30px; font-weight:800; color:var(--greent); margin-bottom:4px; }
    .stat span { font-size:13px; color:var(--muted); }

    /* ROLES */
    .roles { padding:96px 0; }
    .role-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
    .role { background:var(--bg2); border:1px solid var(--border); border-radius:var(--rl); padding:26px; transition:border-color .22s, transform .22s; }
    .role:hover { border-color:var(--border-h); transform:translateY(-4px); }
    .role .shot-crop { height:300px; margin-bottom:20px; }
    .role h3 { font-size:18px; margin:14px 0 6px; }
    .role > p { font-size:14px; color:var(--muted); margin-bottom:16px; }
    .ticks { list-style:none; display:flex; flex-direction:column; gap:9px; }
    .ticks li { display:flex; gap:9px; font-size:13px; color:var(--muted); }
    .ticks .ic { color:var(--greent); margin-top:2px; }

    /* FEATURES */
    .features { padding:0 0 96px; }
    .feat-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:16px; }
    .feat { background:var(--bg2); border:1px solid var(--border); border-radius:var(--rl); padding:24px; transition:border-color .22s; }
    .feat:hover { border-color:var(--border-h); }
    .feat .icon-box { margin-bottom:14px; }
    .feat h3 { font-size:16px; margin-bottom:6px; }
    .feat p { font-size:13px; color:var(--muted); }

    /* PRICING */
    .pricing { padding:96px 0; background:var(--bg2); border-top:1px solid var(--border); border-bottom:1px solid var(--border); }
    .founding { display:flex; gap:14px; align-items:flex-start; background:rgba(48,220,128,0.07); border:1px solid rgba(48,220,128,0.28); border-radius:var(--rl); padding:18px 22px; margin-bottom:36px; }
    .founding .ic { color:var(--greent); margin-top:2px; }
    .founding p { font-size:14px; color:var(--muted); }
    .founding strong { color:var(--text); font-weight:500; }
    .price-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
    .price-card { position:relative; background:var(--bg3); border:1px solid var(--border); border-radius:var(--rl); padding:28px; display:flex; flex-direction:column; transition:border-color .22s, transform .22s; }
    .price-card:hover { border-color:var(--border-h); transform:translateY(-4px); }
    .price-card.popular { border-color:rgba(48,220,128,0.42); background:rgba(48,220,128,0.04); }
    .popular-badge { position:absolute; top:-12px; left:50%; transform:translateX(-50%); background:var(--green); color:#0a0e13; font-size:11px; font-weight:700; padding:4px 14px; border-radius:999px; letter-spacing:0.06em; white-space:nowrap; text-transform:uppercase; }
    .price-name { font-family:'Syne',sans-serif; font-size:17px; font-weight:700; }
    .price-size { font-size:12px; color:var(--muted); margin-bottom:18px; }
    .price-amount { font-family:'Syne',sans-serif; font-size:34px; font-weight:800; color:var(--greent); }
    .price-amount small { font-family:'DM Sans',sans-serif; font-size:13px; font-weight:400; color:var(--muted); }
    .price-setup { font-size:12px; color:var(--muted); margin:6px 0 20px; }
    .price-card .ticks { margin-bottom:24px; flex:1; }
    .price-cta { display:block; text-align:center; padding:12px; border-radius:var(--r); font-size:14px; font-weight:600; border:1px solid rgba(255,255,255,0.16); transition:all .2s; }
    .price-cta:hover { border-color:rgba(255,255,255,0.3); background:rgba(255,255,255,0.04); }
    .popular .price-cta { background:var(--green); color:#0a0e13; border-color:var(--green); }
    .popular .price-cta:hover { background:var(--greend); }
    .price-note { text-align:center; margin-top:22px; font-size:13px; color:var(--muted); }
    .price-note strong { color:var(--greent); font-weight:500; }

    /* FAQ */
    .faqs { padding:96px 0; }
    .faq-wrap { max-width:760px; }
    details.faq { background:var(--bg2); border:1px solid var(--border); border-radius:var(--r); margin-bottom:10px; }
    details.faq summary { cursor:pointer; list-style:none; padding:16px 20px; font-weight:500; display:flex; justify-content:space-between; gap:16px; }
    details.faq summary::-webkit-details-marker { display:none; }
    details.faq summary::after { content:'+'; color:var(--greent); font-size:20px; line-height:1; }
    details.faq[open] summary::after { content:'–'; }
    details.faq p { padding:0 20px 18px; font-size:14px; color:var(--muted); }
    details.faq p a { color:var(--greent); text-decoration:underline; }

    /* CTA + CONTACT */
    .cta { padding:0 0 96px; }
    .cta-box { background:linear-gradient(135deg,rgba(48,220,128,0.09),rgba(48,220,128,0.02)); border:1px solid rgba(48,220,128,0.22); border-radius:24px; padding:56px 40px; text-align:center; }
    .cta-box h2 { font-size:clamp(26px,4vw,40px); font-weight:800; margin-bottom:14px; }
    .cta-box p { color:var(--muted); max-width:480px; margin:0 auto 28px; font-weight:300; }
    .contact { padding:96px 0; background:var(--bg2); border-top:1px solid var(--border); }
    .contact h2 { font-size:clamp(24px,3vw,34px); margin-bottom:12px; }
    .contact .lead { font-size:15px; color:var(--muted); font-weight:300; margin-bottom:26px; }
    .channels { display:flex; flex-direction:column; gap:12px; }
    .channel { display:flex; align-items:center; gap:14px; padding:14px 16px; background:var(--bg3); border:1px solid var(--border); border-radius:var(--r); transition:border-color .2s; }
    .channel:hover { border-color:var(--border-h); }
    .channel small { display:block; font-size:12px; color:var(--muted); }
    .channel span { font-size:14px; font-weight:500; }
    .socials { display:flex; gap:10px; margin-top:16px; }
    .socials a { width:42px; height:42px; display:flex; align-items:center; justify-content:center; border:1px solid var(--border); border-radius:12px; color:var(--muted); transition:all .2s; }
    .socials a:hover { color:var(--greent); border-color:var(--border-h); }
    .form-card { background:var(--bg3); border:1px solid var(--border); border-radius:var(--rl); padding:30px; }
    .form-card h3 { font-size:18px; margin-bottom:4px; }
    .form-card > p { font-size:13px; color:var(--muted); margin-bottom:20px; }
    .field { margin-bottom:14px; }
    .field label { display:block; font-size:12px; color:var(--muted); margin-bottom:5px; }
    .field input, .field select, .field textarea { width:100%; background:var(--bg); border:1px solid rgba(255,255,255,0.1); border-radius:var(--r); color:var(--text); font-family:'DM Sans',sans-serif; font-size:14px; padding:10px 13px; outline:none; transition:border-color .2s; }
    .field input:focus, .field select:focus, .field textarea:focus { border-color:rgba(74,222,128,0.45); }
    .field textarea { min-height:84px; resize:vertical; }
    .form-card .btn { width:100%; justify-content:center; }

    /* FOOTER */
    footer { padding:34px 0; border-top:1px solid var(--border); }
    .foot { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px; }
    .foot-links { display:flex; flex-wrap:wrap; gap:18px; }
    .foot-links a { font-size:13px; color:var(--muted); transition:color .2s; }
    .foot-links a:hover { color:var(--text); }
    .copy { font-size:12px; color:var(--muted); }

    @media (max-width:900px) {
      .nav-links { display:none; }
      .ham { display:block; }
      .hero { padding:110px 0 50px; }
      .hero-grid, .two, .why-grid, .steps, .role-grid, .feat-grid, .price-grid, .entry-grid { grid-template-columns:1fr; }
      .two, .why-grid { gap:36px; }
      .why-grid.solo .stats { grid-template-columns:1fr 1fr; }
      .cta-box { padding:40px 22px; }
    }
    @media (prefers-reduced-motion: reduce) { * { animation:none !important; transition:none !important; } html { scroll-behavior:auto; } }
  </style>
</head>
<body>

<nav class="top">
  <div class="nav-inner">
    <a href="/" class="brand">
      <img src="/public/assets/icons/favicon-32.png" alt="" width="32" height="32" />
      <span>Les Passe</span>
    </a>
    <div class="nav-links">
      <a href="#how">How it works</a>
      <a href="#pricing">Pricing</a>
      <a href="#faq">FAQ</a>
      <a href="#contact">Contact</a>
      <a href="<?= e($dashUrl) ?>" class="btn-nav"><?= e($dashLabel) ?></a>
    </div>
    <button class="ham" id="ham" aria-label="Open menu" aria-expanded="false">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
  </div>
  <div class="mob-menu" id="mob-menu">
    <a href="#how">How it works</a>
    <a href="#pricing">Pricing</a>
    <a href="#faq">FAQ</a>
    <a href="#contact">Contact</a>
    <a href="<?= e($dashUrl) ?>" style="color:var(--greent);font-weight:600;"><?= e($dashLabel) ?> →</a>
  </div>
</nav>

<!-- HERO -->
<header class="hero">
  <div class="container">
    <div class="hero-grid<?= $heroShot === '' ? ' solo' : '' ?>">
      <div>
        <div class="pill"><span class="dot"></span>Now live for Lagos gated estates</div>
        <h1>Your estate gate,<br><span>finally digital.</span></h1>
        <p class="hero-sub">Les Passe replaces the visitor book and the gate phone call. Residents create a 6-digit pass, guards verify it in seconds, and admins get a full record of every entry.</p>
        <div class="hero-ctas">
          <a href="#contact" class="btn btn-primary">Request a free pilot <?= lp_icon('arrow', 18) ?></a>
          <a href="<?= e($dashUrl) ?>" class="btn btn-ghost"><?= $signedIn ? 'Open dashboard' : 'Resident or guard? Sign in' ?></a>
        </div>
        <div class="trust">
          <span><?= lp_icon('check', 16) ?>Runs in the phone browser</span>
          <span><?= lp_icon('check', 16) ?>Shares on WhatsApp</span>
          <span><?= lp_icon('check', 16) ?>No hardware needed</span>
          <span><?= lp_icon('check', 16) ?>Built in Lagos</span>
        </div>
      </div>
      <?php if ($heroShot !== ''): ?><div><?= lp_phone($heroShot) ?></div><?php endif; ?>
    </div>
  </div>
</header>

<!-- ENTRY STRIP -->
<section class="entry">
  <div class="container entry-grid">
    <div class="entry-card reveal">
      <div class="icon-box"><?= lp_icon('key', 22) ?></div>
      <div>
        <h3>Already on Les Passe?</h3>
        <p>Residents, guards and estate admins sign in here.</p>
        <a href="<?= e($dashUrl) ?>" class="link-arrow"><?= e($dashLabel) ?> <?= lp_icon('arrow', 16) ?></a>
      </div>
    </div>
    <div class="entry-card reveal">
      <div class="icon-box"><?= lp_icon('door', 22) ?></div>
      <div>
        <h3>Visiting someone in an estate?</h3>
        <p>Your host sends you a 6-digit code or a QR link on WhatsApp. Show it to security at the gate. If something isn’t working, ask your host or the estate security desk.</p>
      </div>
    </div>
  </div>
</section>

<!-- PROBLEM -->
<section class="problem" id="problem">
  <div class="container two">
    <div>
      <div class="eyebrow">The problem</div>
      <h2>The visitor book isn’t working.</h2>
      <p class="lead">Most Lagos estates still run on a paper book, a phone call to the resident and a guard who has to remember faces. It’s slow, it’s easy to abuse, and when something goes wrong there’s no record to check.</p>
      <div class="pains">
        <div class="pain"><?= lp_icon('book', 20) ?><p><strong>Paper books</strong> with handwriting nobody can read and pages that go missing.</p></div>
        <div class="pain"><?= lp_icon('call', 20) ?><p><strong>Calling the resident every time.</strong> Phone off, no answer, visitor waiting at the gate.</p></div>
        <div class="pain"><?= lp_icon('door', 20) ?><p><strong>Letting people in on trust.</strong> “I’m here for Flat 5B” and the barrier lifts.</p></div>
        <div class="pain"><?= lp_icon('search', 20) ?><p><strong>No audit trail.</strong> Who came in last Tuesday? Nobody can say.</p></div>
      </div>
    </div>
    <div>
      <?php if ($problemShot !== ''): echo $problemShot; else: ?>
      <div class="logbook" aria-hidden="true">
        <div class="logbook-title">Visitors’ Book</div>
        <div class="lb-head"><span>Name</span><span>Flat</span><span>Time</span></div>
        <div class="lb-row"><span>Mr. Em…</span><span>5 or 6?</span><span>3:4_ pm</span></div>
        <div class="lb-row"><span>Delivery</span><span>—</span><span>—</span></div>
        <div class="lb-row"><span class="faint">~~~~~~~</span><span>B2</span><span>6:10</span></div>
        <div class="lb-row"><span>Uncle Tunde</span><span>C14</span><span>no exit</span></div>
        <div class="lb-note">Who came in last Tuesday? Nobody can tell.</div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how" id="how">
  <div class="container">
    <div class="eyebrow">How it works</div>
    <h2 class="section-title">Three steps. Done.</h2>
    <p class="section-sub">No new hardware and nothing for visitors to install. It runs in the browser on the phones your residents and guards already have.</p>
    <div class="steps">
      <div class="step reveal">
        <div class="step-num">01</div>
        <h3>Resident creates a pass</h3>
        <p>Enter the visitor’s name, choose how long the pass lasts (1, 3 or 6 hours) and tap generate. A 6-digit code and QR appear instantly.</p>
        <div class="step-visual"><?= $stepGen !== '' ? $stepGen : '<div class="visual-icon">' . lp_icon('phone', 56) . '</div>' ?></div>
      </div>
      <div class="step reveal">
        <div class="step-num">02</div>
        <h3>Visitor gets it on WhatsApp</h3>
        <p>The resident sends the code, or the code plus a QR link, in one tap. The visitor just shows it at the gate.</p>
        <div class="step-visual">
          <div class="wa" aria-hidden="true">
            <div class="wa-bubble">
              Hi! Here is your gate pass for Palm Court Estate.<br><br>
              Visitor: <b>Ngozi Bello</b><br>
              Access code: <b>930·242</b><br>
              Valid for: 6 hours<br>
              Expires: 7:55 PM<br><br>
              Show this code to security at the gate.
              <div class="wa-time">2:21 PM</div>
            </div>
          </div>
        </div>
      </div>
      <div class="step reveal">
        <div class="step-num">03</div>
        <h3>Guard verifies in seconds</h3>
        <p>The guard types the code or scans the QR. Green means go, red means stop, and every check is logged.</p>
        <div class="step-visual"><?= $stepVerify !== '' ? $stepVerify : '<div class="visual-icon">' . lp_icon('shield', 56) . '</div>' ?></div>
      </div>
    </div>
  </div>
</section>

<!-- WHY -->
<section class="why">
  <div class="container">
    <div class="why-grid<?= $denied === '' ? ' solo' : '' ?>">
      <div>
        <div class="eyebrow">Why Les Passe</div>
        <h2 class="section-title">A clear answer at the gate, every time.</h2>
        <p class="section-sub" style="margin-bottom:28px;">Built in Lagos for how estates actually run: busy gates, shared phones and visitors who are already on WhatsApp.</p>
        <div class="stats">
          <div class="stat"><b>6 digits</b><span>Short enough to read out over a phone call</span></div>
          <div class="stat"><b>1 use</b><span>Each pass works once, then it’s dead</span></div>
          <div class="stat"><b>3 roles</b><span>Residents, guards and admins each see only their own screen</span></div>
          <div class="stat"><b>0 apps</b><span>Nothing to download from an app store</span></div>
        </div>
      </div>
      <?php if ($denied !== ''): ?><div><?= lp_phone($denied) ?></div><?php endif; ?>
    </div>
  </div>
</section>

<!-- ROLES -->
<section class="roles" id="roles">
  <div class="container">
    <div class="eyebrow">Who uses it</div>
    <h2 class="section-title">One system, three screens.</h2>
    <p class="section-sub">Everyone sees exactly what they need and nothing they don’t.</p>
    <div class="role-grid">
      <div class="role reveal">
        <?= $roleRes ?>
        <div class="icon-box"><?= lp_icon('home', 22) ?></div>
        <h3>Residents</h3>
        <p>Create and manage visitor passes from your phone.</p>
        <ul class="ticks">
          <li><?= lp_icon('check', 16) ?>Create a pass in seconds</li>
          <li><?= lp_icon('check', 16) ?>Choose a 1, 3 or 6 hour window</li>
          <li><?= lp_icon('check', 16) ?>Share on WhatsApp: code only, or code plus QR link</li>
          <li><?= lp_icon('check', 16) ?>Cancel an active pass any time</li>
          <li><?= lp_icon('check', 16) ?>See every pass you’ve issued</li>
        </ul>
      </div>
      <div class="role reveal">
        <?= $roleGuard ?>
        <div class="icon-box"><?= lp_icon('shield', 22) ?></div>
        <h3>Security guards</h3>
        <p>One simple screen with big buttons and a clear result.</p>
        <ul class="ticks">
          <li><?= lp_icon('check', 16) ?>Type the 6-digit code or scan the QR</li>
          <li><?= lp_icon('check', 16) ?>Green or red result at a glance</li>
          <li><?= lp_icon('check', 16) ?>Catches expired, cancelled and used passes</li>
          <li><?= lp_icon('check', 16) ?>No training manual needed</li>
          <li><?= lp_icon('check', 16) ?>Every check logged under their name</li>
        </ul>
      </div>
      <div class="role reveal">
        <?= $roleAdmin ?>
        <div class="icon-box"><?= lp_icon('chart', 22) ?></div>
        <h3>Estate admin</h3>
        <p>Full visibility and control over your estate.</p>
        <ul class="ticks">
          <li><?= lp_icon('check', 16) ?>Today’s passes and gate activity at a glance</li>
          <li><?= lp_icon('check', 16) ?>Full entry log with times and guard names</li>
          <li><?= lp_icon('check', 16) ?>Add, pause or reactivate residents and guards</li>
          <li><?= lp_icon('check', 16) ?>Your estate’s data is separate from every other estate</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="features">
  <div class="container">
    <div class="eyebrow">Features</div>
    <h2 class="section-title">What’s inside.</h2>
    <p class="section-sub">Only what makes gate management work. No bloat.</p>
    <div class="feat-grid">
      <div class="feat reveal"><div class="icon-box"><?= lp_icon('hash', 22) ?></div><h3>6-digit access codes</h3><p>Every pass gets a unique code that’s easy to read aloud and easy to type.</p></div>
      <div class="feat reveal"><div class="icon-box"><?= lp_icon('qr', 22) ?></div><h3>QR on every pass</h3><p>Guards can scan straight from the visitor’s phone for faster entry.</p></div>
      <div class="feat reveal"><div class="icon-box"><?= lp_icon('clock', 22) ?></div><h3>Time-limited passes</h3><p>Choose a 1, 3 or 6 hour window. Passes expire on their own.</p></div>
      <div class="feat reveal"><div class="icon-box"><?= lp_icon('chat', 22) ?></div><h3>WhatsApp sharing</h3><p>Residents share passes the way Lagos already communicates.</p></div>
      <div class="feat reveal"><div class="icon-box"><?= lp_icon('clipboard', 22) ?></div><h3>Complete audit trail</h3><p>Every gate check is logged with time, guard and result, whether it passed or failed.</p></div>
      <div class="feat reveal"><div class="icon-box"><?= lp_icon('users', 22) ?></div><h3>Role-based access</h3><p>Admin, resident and guard accounts, each with only the access they need.</p></div>
      <div class="feat reveal"><div class="icon-box"><?= lp_icon('phone', 22) ?></div><h3>Runs in the browser</h3><p>Works on Android and iPhone with nothing to install from an app store.</p></div>
      <div class="feat reveal"><div class="icon-box"><?= lp_icon('lock', 22) ?></div><h3>One-time use</h3><p>Once a pass is used it can’t be used again, so a shared code can’t be reused.</p></div>
      <div class="feat reveal"><div class="icon-box"><?= lp_icon('bolt', 22) ?></div><h3>Fast checks</h3><p>Light pages and a simple screen keep the queue moving.</p></div>
    </div>
  </div>
</section>

<!-- PRICING -->
<section class="pricing" id="pricing">
  <div class="container">
    <div class="eyebrow">Pricing</div>
    <h2 class="section-title">Simple, honest pricing.</h2>
    <p class="section-sub">Priced for Nigerian estates, from small closes to large communities. Billed per estate, not per resident.</p>
    <div class="founding">
      <?= lp_icon('key', 22) ?>
      <p><strong>Founding estates:</strong> our first three estates get 60 days free and no setup fee, in return for honest feedback and permission to share a short case study. After that, every new estate starts with a 30-day free trial.</p>
    </div>
    <div class="price-grid">
      <?php foreach ($plans as $p): ?>
      <div class="price-card<?= $p['popular'] ? ' popular' : '' ?> reveal">
        <?php if ($p['popular']): ?><div class="popular-badge">Most popular</div><?php endif; ?>
        <div class="price-name"><?= e($p['name']) ?></div>
        <div class="price-size"><?= e($p['size']) ?></div>
        <div class="price-amount"><?= e($p['price']) ?> <small>/ month</small></div>
        <div class="price-setup">+ <?= e($p['setup']) ?> one-time setup fee</div>
        <ul class="ticks">
          <?php foreach ($p['features'] as $f): ?>
          <li><?= lp_icon('check', 16) ?><span><?= e($f) ?></span></li>
          <?php endforeach; ?>
        </ul>
        <a href="#contact" class="price-cta">Get started</a>
      </div>
      <?php endforeach; ?>
    </div>
    <p class="price-note">Pay annually and save about <strong>17%</strong>: Starter ₦150,000/yr · Growth ₦350,000/yr · Pro ₦750,000/yr</p>
  </div>
</section>

<!-- FAQ -->
<section class="faqs" id="faq">
  <div class="container">
    <div class="eyebrow">FAQ</div>
    <h2 class="section-title">Questions estates ask us.</h2>
    <p class="section-sub">Straight answers, including the limits.</p>
    <div class="faq-wrap">
      <?php foreach ($faqs as $f): ?>
      <details class="faq reveal"><summary><?= e($f[0]) ?></summary><p><?= $f[1] ?></p></details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta">
  <div class="container">
    <div class="cta-box">
      <h2>Ready to retire the visitor book?</h2>
      <p>We’ll set up your estate, load your residents and walk your security team through the gate screen.</p>
      <a href="#contact" class="btn btn-primary">Request a free pilot <?= lp_icon('arrow', 18) ?></a>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section class="contact" id="contact">
  <div class="container two" style="align-items:start;">
    <div>
      <div class="eyebrow">Get in touch</div>
      <h2>Let’s set up your estate.</h2>
      <p class="lead">Tell us about your estate and we’ll reply within one working day to arrange a short walkthrough.</p>
      <div class="channels">
        <?php if ($waNumber !== ''): ?>
        <a class="channel" href="https://wa.me/<?= e($waNumber) ?>?text=<?= rawurlencode('Hi, I’m interested in Les Passe for my estate.') ?>" target="_blank" rel="noopener">
          <div class="icon-box"><?= lp_icon('chat', 22) ?></div>
          <div><small>WhatsApp, fastest reply</small><span>Chat with us</span></div>
        </a>
        <?php endif; ?>
        <a class="channel" href="mailto:<?= e($email) ?>">
          <div class="icon-box"><?= lp_icon('mail', 22) ?></div>
          <div><small>Email</small><span><?= e($email) ?></span></div>
        </a>
      </div>
      <?php if ($instagram !== '' || $xHandle !== ''): ?>
      <div class="socials">
        <?php if ($instagram !== ''): ?><a href="https://instagram.com/<?= e($instagram) ?>" target="_blank" rel="noopener" aria-label="Les Passe on Instagram"><?= lp_icon('instagram', 20) ?></a><?php endif; ?>
        <?php if ($xHandle !== ''): ?><a href="https://x.com/<?= e($xHandle) ?>" target="_blank" rel="noopener" aria-label="Les Passe on X"><?= lp_icon('x', 20) ?></a><?php endif; ?>
      </div>
      <?php endif; ?>
    </div>
    <div class="form-card">
      <h3>Request a free pilot</h3>
      <p>Takes a minute. We’ll take it from there.</p>
      <form onsubmit="handleForm(event)">
        <div class="field"><label for="f-name">Your name</label><input id="f-name" type="text" required /></div>
        <div class="field"><label for="f-estate">Estate name and area</label><input id="f-estate" type="text" placeholder="e.g. Palm Court Estate, Lekki" required /></div>
        <div class="field"><label for="f-size">Approximate number of units</label>
          <select id="f-size"><option value="">Select</option><option>6–30 units</option><option>31–200 units</option><option>200+ units</option></select>
        </div>
        <div class="field"><label for="f-phone">Phone / WhatsApp number</label><input id="f-phone" type="tel" required /></div>
        <div class="field"><label for="f-msg">Anything we should know? (optional)</label><textarea id="f-msg"></textarea></div>
        <button type="submit" class="btn btn-primary">Send request <?= lp_icon('arrow', 18) ?></button>
      </form>
    </div>
  </div>
</section>

<footer>
  <div class="container foot">
    <a href="/" class="brand"><img src="/public/assets/icons/favicon-32.png" alt="" width="28" height="28" style="width:28px;height:28px;" /><span style="font-size:16px;">Les Passe</span></a>
    <div class="foot-links">
      <a href="#how">How it works</a>
      <a href="#pricing">Pricing</a>
      <a href="#faq">FAQ</a>
      <a href="/privacy">Privacy</a>
      <a href="/terms">Terms</a>
      <a href="<?= e($dashUrl) ?>"><?= e($dashLabel) ?></a>
    </div>
    <div class="copy">&copy; <?= date('Y') ?> Les Passe · Secure access. Total control.</div>
  </div>
</footer>

<script>
  const WA = <?= json_encode($waNumber) ?>;
  const MAIL = <?= json_encode($email) ?>;

  const ham = document.getElementById('ham');
  const mob = document.getElementById('mob-menu');
  ham.addEventListener('click', () => {
    const open = mob.classList.toggle('open');
    ham.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
  mob.querySelectorAll('a').forEach(a => a.addEventListener('click', () => mob.classList.remove('open')));

  function handleForm(e) {
    e.preventDefault();
    const v = id => document.getElementById(id).value.trim();
    const text = [
      'New Les Passe pilot request', '',
      'Name: ' + v('f-name'),
      'Estate: ' + v('f-estate'),
      'Size: ' + (v('f-size') || 'Not given'),
      'Phone: ' + v('f-phone'),
      'Notes: ' + (v('f-msg') || 'None')
    ].join('\n');
    if (WA) {
      window.open('https://wa.me/' + WA + '?text=' + encodeURIComponent(text), '_blank');
    } else {
      window.location.href = 'mailto:' + MAIL + '?subject=' + encodeURIComponent('Les Passe pilot request: ' + v('f-estate')) + '&body=' + encodeURIComponent(text);
    }
  }

  // Fade-in on scroll (content stays visible if JS fails)
  if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches && 'IntersectionObserver' in window) {
    const io = new IntersectionObserver(entries => {
      entries.forEach(en => {
        if (en.isIntersecting) { en.target.style.opacity = '1'; en.target.style.transform = 'translateY(0)'; io.unobserve(en.target); }
      });
    }, { threshold: 0.08 });
    document.querySelectorAll('.reveal').forEach(el => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(18px)';
      el.style.transition = 'opacity .55s ease, transform .55s ease';
      io.observe(el);
    });
  }
</script>
</body>
</html>
