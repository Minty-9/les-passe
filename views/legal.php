<?php
// Privacy Policy and Terms — one template, two documents ($legalPage is set by index.php)
$bizName    = 'LesPasse Technologies';          // replace with your registered business name if different
$bizAddress = '10 Unity Close Shangisha Magodo Lagos, Nigeria';     // replace with your registered address
$bizEmail   = 'hello@lespasse.ng';
$updated    = 'November 2026';

$isPrivacy = ($legalPage ?? 'privacy') === 'privacy';

$privacy = [
    ['Who we are', [
        'Les Passe (“we”, “us”) provides a digital visitor-pass service to gated estates. This policy explains what personal data we handle and why.',
        'For the information an estate and its residents enter into Les Passe, the estate is the data controller and we act as its data processor: we only process that data to run the service for the estate. For people who contact us or visit this website, we are the controller. We handle personal data in line with the Nigeria Data Protection Act 2023 (NDPA).',
    ], []],
    ['What we collect', [], [
        'Account details: name, unit or house number, phone number, email address, role (resident, guard or admin) and a password, which we store only in hashed form.',
        'Visitor passes: the visitor name and optional phone number a resident enters, the 6-digit code, the validity window and the pass status.',
        'Gate activity: when a code is checked, the result, the time and which guard checked it.',
        'Enquiries: what you submit in our contact form or send us by email or WhatsApp.',
        'Technical data: standard server logs (such as IP address, browser and device type, and pages requested) and a session cookie that keeps you signed in.',
    ]],
    ['How we use it', ['We do not sell personal data and we do not use it for advertising.'], [
        'To provide and run the service for your estate.',
        'To show estate admins the passes and entry logs for their own estate.',
        'To keep the service secure and prevent abuse.',
        'To give support and improve reliability.',
        'To comply with the law.',
    ]],
    ['Who can see it', [
        'We use service providers to run Les Passe, including our hosting provider (Railway), a font provider for this website (Google Fonts) and a QR-code image service. When a resident shares a pass on WhatsApp, the message passes through WhatsApp under its own terms and we do not receive a copy. We may disclose data where the law requires it.',
    ], [
        'Residents see their own passes.',
        'Guards see what they need to verify a pass: the visitor’s name, the host’s name and unit, and the result.',
        'Estate admins see their estate’s residents, guards, passes and entry logs.',
        'Other estates cannot see your estate’s data.',
    ]],
    ['Where data is stored', [
        'Our hosting provider’s servers may be outside Nigeria. Where personal data is transferred across borders, we take steps to make sure appropriate safeguards are in place, as the NDPA requires.',
    ], []],
    ['How long we keep it', [
        'We keep an estate’s data while its account is active. If an estate ends its subscription, we delete or return its data within 90 days of a written request. An estate can also ask us to delete older entry logs sooner.',
    ], []],
    ['Security', [
        'We use HTTPS, store passwords in hashed form, restrict access by role and keep each estate’s data separate. No system is perfectly secure. If we become aware of a breach affecting personal data, we will tell the affected estate without undue delay so it can meet its own obligations.',
    ], []],
    ['Your rights', [
        'Under the NDPA you may ask to access your personal data, correct it, delete it, object to or restrict its processing, receive a portable copy, and withdraw consent where processing relies on it.',
        'Because your estate controls resident and visitor data in Les Passe, please contact your estate admin first and we will help the estate respond. For personal data we control, email us at the address below. You also have the right to complain to the Nigeria Data Protection Commission.',
    ], []],
    ['Children', [
        'Les Passe is for adults. Residents may create passes for visitors of any age, but we do not knowingly create accounts for children.',
    ], []],
    ['Changes to this policy', [
        'We may update this policy. We will change the date at the top and tell estate admins about significant changes.',
    ], []],
];

$terms = [
    ['About these terms', [
        'These terms govern the use of Les Passe by estates that subscribe to it (“the Estate”) and by the residents, guards and admins the Estate invites (“Users”). By using Les Passe you agree to them. The person who signs an Estate up confirms they have authority to do so.',
    ], []],
    ['The service', [
        'Les Passe lets residents create time-limited visitor passes, lets guards check them at the gate and records every check. It is a software tool. It is not a security guarantee, and it does not provide guards, physical security or insurance. Decisions about who enters the estate always remain with the Estate and its security team.',
    ], []],
    ['Accounts', [], [
        'The Estate’s admin creates and manages resident and guard accounts.',
        'Give accurate information and keep your password secret.',
        'Do not share logins. Each guard should use their own account so the entry log is accurate.',
        'Tell us promptly if you suspect misuse. We may suspend an account we believe is compromised.',
    ]],
    ['The Estate’s responsibilities', [], [
        'Make sure it has the right to collect and process residents’ and visitors’ personal data, and tell residents how it is used.',
        'Keep resident and guard lists accurate and remove people who leave.',
        'Train guards, and keep a manual fallback for the gate in case the internet or the service is unavailable.',
        'Use entry logs lawfully and only for the Estate’s security and administration.',
    ]],
    ['Acceptable use', [
        'You must not use Les Passe unlawfully, try to reach another estate’s data or accounts, probe, overload or interfere with the service, copy, resell or reverse-engineer it, or create passes under false identities to avoid gate checks.',
    ], []],
    ['Plans, pilots and fees', [
        'Plans and prices are shown on our website and may change. We give existing customers at least 30 days’ notice of price changes. Fees are invoiced monthly or annually in advance, plus any one-time setup fee. Founding-estate pilots and free trials run for the period we agree in writing.',
        'If a payment is overdue, we will give at least 7 days’ notice by email or WhatsApp before pausing the Estate’s access, and we will restore access promptly once the account is settled. Fees already paid are not refundable except where the law requires.',
    ], []],
    ['Availability and changes', [
        'We work to keep Les Passe available but cannot promise uninterrupted service. We may carry out maintenance and improve or change features.',
    ], []],
    ['Your data', [
        'The Estate owns the data it enters. It permits us to process that data to provide the service, as described in our Privacy Policy. We may use aggregated, anonymised usage statistics to improve Les Passe. When the subscription ends we will, on request, export or delete the Estate’s data.',
    ], []],
    ['Intellectual property', [
        'Les Passe, its software, name and logo belong to us. While a subscription is active, the Estate and its Users have a limited, non-exclusive right to use the service for the Estate’s own purposes.',
    ], []],
    ['Disclaimers and liability', [
        'To the extent the law allows, Les Passe is provided “as is”. We are not liable for indirect or consequential loss, for incidents at the estate, for decisions made at the gate, or for losses caused by network or device failures outside our control. Our total liability for any claim is limited to the fees the Estate paid us in the three months before the claim arose. Nothing in these terms limits liability that cannot be limited under Nigerian law.',
    ], []],
    ['Ending the agreement', [
        'Either party may end the subscription at any time, effective at the end of the paid period. We may suspend or end access immediately for serious breach, such as misuse or unlawful activity. When a subscription ends we handle data as described in our Privacy Policy.',
    ], []],
    ['Changes to these terms', [
        'We may update these terms. We will change the date at the top and give estate admins reasonable notice of significant changes.',
    ], []],
    ['Governing law', [
        'These terms are governed by the laws of the Federal Republic of Nigeria. We will first try to resolve any dispute in good faith. If that fails, the courts of Lagos State have jurisdiction.',
    ], []],
];

$doc   = $isPrivacy ? $privacy : $terms;
$title = $isPrivacy ? 'Privacy Policy' : 'Terms of Service';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= e($title) ?> — Les Passe</title>
  <meta name="description" content="<?= e($title) ?> for Les Passe, the digital visitor-pass system for gated estates." />
  <link rel="canonical" href="https://www.lespasse.ng/<?= $isPrivacy ? 'privacy' : 'terms' ?>" />
  <meta name="theme-color" content="#0a0e13" />
  <link rel="icon" type="image/x-icon" href="/public/assets/icons/favicon.ico" />
  <link rel="icon" type="image/png" sizes="32x32" href="/public/assets/icons/favicon-32.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
    :root { --bg:#0a0e13; --bg2:#111620; --border:rgba(48,220,128,0.12); --greent:#4ade80; --muted:#8b949e; --text:#e6edf3; }
    body { background:var(--bg); color:var(--text); font-family:'DM Sans',sans-serif; font-size:16px; line-height:1.7; -webkit-font-smoothing:antialiased; }
    a { color:var(--greent); text-decoration:none; }
    a:hover { text-decoration:underline; }
    header { border-bottom:1px solid var(--border); background:rgba(10,14,19,0.9); }
    .bar { max-width:860px; margin:0 auto; padding:14px 24px; display:flex; align-items:center; justify-content:space-between; }
    .brand { display:flex; align-items:center; gap:10px; color:var(--greent); font-family:'Syne',sans-serif; font-weight:800; font-size:18px; }
    .brand img { width:30px; height:30px; border-radius:8px; border:1px solid var(--border); }
    .brand:hover { text-decoration:none; }
    main { max-width:760px; margin:0 auto; padding:48px 24px 72px; }
    h1 { font-family:'Syne',sans-serif; font-size:clamp(28px,5vw,40px); font-weight:800; letter-spacing:-0.02em; margin-bottom:6px; }
    .updated { font-size:13px; color:var(--muted); margin-bottom:36px; }
    h2 { font-family:'Syne',sans-serif; font-size:18px; font-weight:700; margin:32px 0 10px; }
    p { color:#c4cbd3; font-size:15px; font-weight:300; margin-bottom:12px; }
    ul { margin:0 0 12px 20px; }
    li { color:#c4cbd3; font-size:15px; font-weight:300; margin-bottom:8px; }
    .contact { margin-top:36px; padding:18px 20px; background:var(--bg2); border:1px solid var(--border); border-radius:14px; font-size:14px; color:var(--muted); }
    footer { border-top:1px solid var(--border); padding:24px; text-align:center; font-size:13px; color:var(--muted); }
    footer a { margin:0 10px; color:var(--muted); }
    footer a:hover { color:var(--text); }
  </style>
</head>
<body>
<header>
  <div class="bar">
    <a href="/" class="brand"><img src="/public/assets/icons/favicon-32.png" alt="" width="30" height="30" />Les Passe</a>
    <a href="/" style="font-size:14px;">← Back to home</a>
  </div>
</header>
<main>
  <h1><?= e($title) ?></h1>
  <p class="updated">Last updated: <?= e($updated) ?></p>

  <?php foreach ($doc as $i => $s): ?>
    <h2><?= ($i + 1) ?>. <?= e($s[0]) ?></h2>
    <?php foreach ($s[1] as $para): ?><p><?= e($para) ?></p><?php endforeach; ?>
    <?php if (!empty($s[2])): ?>
      <ul><?php foreach ($s[2] as $li): ?><li><?= e($li) ?></li><?php endforeach; ?></ul>
    <?php endif; ?>
  <?php endforeach; ?>

  <h2><?= count($doc) + 1 ?>. Contact</h2>
  <div class="contact">
    <?= e($bizName) ?><br>
    <?= e($bizAddress) ?><br>
    <a href="mailto:<?= e($bizEmail) ?>"><?= e($bizEmail) ?></a>
  </div>
</main>
<footer>
  <a href="/">Home</a><a href="/privacy">Privacy</a><a href="/terms">Terms</a><a href="/auth/login">Sign in</a>
  <div style="margin-top:10px;">&copy; <?= date('Y') ?> Les Passe</div>
</footer>
</body>
</html>
