<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Access — Les Passe</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg: #0d1117; --bg2: #161b22; --bg3: #1c2330;
      --border: rgba(48,220,128,0.10); --green: #30dc80;
      --greent: #4ade80; --muted: #8b949e; --text: #e6edf3;
      --r: 10px; --rl: 16px;
    }
    body {
      background: var(--bg); color: var(--text);
      font-family: 'DM Sans', sans-serif; font-size: 15px;
      line-height: 1.65; -webkit-font-smoothing: antialiased;
      min-height: 100vh; display: flex; flex-direction: column;
      align-items: center; justify-content: center; padding: 24px;
    }
    body::before {
      content:''; position:fixed; inset:0; pointer-events:none;
      background-image: linear-gradient(rgba(48,220,128,0.03) 1px,transparent 1px),
        linear-gradient(90deg,rgba(48,220,128,0.03) 1px,transparent 1px);
      background-size:48px 48px;
      -webkit-mask-image:radial-gradient(ellipse 80% 80% at 50% 0%,black 30%,transparent 100%);
      mask-image:radial-gradient(ellipse 80% 80% at 50% 0%,black 30%,transparent 100%);
    }
    .brand { font-family:'Syne',sans-serif; font-size:22px; font-weight:800; color:var(--greent); letter-spacing:-0.01em; margin-bottom:4px; text-align:center; }
    .brand-sub { font-size:13px; color:var(--muted); margin-bottom:28px; text-align:center; }
    .box {
      background:var(--bg2); border:1px solid var(--border);
      border-radius:var(--rl); padding:40px 32px;
      width:100%; max-width:420px;
      text-align:center; position:relative; z-index:1;
    }
    .icon { font-size:48px; margin-bottom:16px; }
    .box h1 { font-family:'Syne',sans-serif; font-size:22px; font-weight:700; margin-bottom:10px; }
    .box p { font-size:14px; color:var(--muted); line-height:1.7; margin-bottom:24px; }
    .divider { border:none; border-top:1px solid var(--border); margin:24px 0; }
    .contact-options { display:flex; flex-direction:column; gap:10px; }
    .contact-btn {
      display:flex; align-items:center; justify-content:center; gap:10px;
      padding:13px 20px; border-radius:var(--r);
      font-size:14px; font-weight:500; text-decoration:none;
      transition:all 0.2s;
    }
    .contact-wa {
      background:#25D366; color:#fff;
    }
    .contact-wa:hover { background:#22c55e; transform:translateY(-1px); }
    .contact-email {
      background:transparent; color:var(--text);
      border:1px solid rgba(255,255,255,0.12);
    }
    .contact-email:hover { border-color:rgba(255,255,255,0.25); background:rgba(255,255,255,0.04); }
    .back-link { text-align:center; font-size:13px; color:var(--muted); margin-top:16px; position:relative; z-index:1; }
    .back-link a { color:var(--greent); text-decoration:none; }
  </style>
</head>
<body>
  <div class="brand">Les Passe</div>
  <div class="brand-sub">Estate visitor access system</div>

  <div class="box">
    <div class="icon">🏠</div>
    <h1>Want access to Les Passe?</h1>
    <p>
      Les Passe accounts are set up by your estate admin.<br>
      Contact your estate manager to get your login credentials.
    </p>

    <hr class="divider" />

    <p style="font-size:13px;color:var(--muted);margin-bottom:16px;">Are you an estate manager looking to get started?</p>
    <div class="contact-options">
      <a href="https://wa.me/2349052369958?text=Hi%2C%20I%27d%20like%20to%20set%20up%20Les%20Passe%20for%20my%20estate." 
         target="_blank" class="contact-btn contact-wa">
        📱 Chat with us on WhatsApp
      </a>
      <a href="mailto:simeondavid99@gmail.com?subject=Les Passe Estate Enquiry" 
         class="contact-btn contact-email">
        ✉️ Send us an email
      </a>
    </div>
  </div>

  <div class="back-link">
    Already have an account? <a href="<?= APP_URL ?>/auth/login">Sign in</a>
  </div>
</body>
</html>