<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($pageTitle) ? e($pageTitle) . ' — ' : '' ?>Les Passe</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    :root {
      --bg:       #0d1117;
      --bg2:      #161b22;
      --bg3:      #1c2330;
      --border:   rgba(48,220,128,0.10);
      --border-h: rgba(48,220,128,0.28);
      --green:    #30dc80;
      --greend:   #22c55e;
      --greent:   #4ade80;
      --greenbg:  rgba(48,220,128,0.07);
      --muted:    #8b949e;
      --text:     #e6edf3;
      --danger:   #f85149;
      --warn:     #f0883e;
      --r:        10px;
      --rl:       16px;
    }
    body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; font-size: 15px; line-height: 1.65; -webkit-font-smoothing: antialiased; min-height: 100vh; display: flex; flex-direction: column; }
    a { color: var(--greent); text-decoration: none; }
    a:hover { text-decoration: underline; }
    img { display: block; max-width: 100%; }
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: var(--bg); }
    ::-webkit-scrollbar-thumb { background: rgba(48,220,128,0.18); border-radius: 3px; }

    /* ── NAV ── */
    .topnav {
      background: rgba(13,17,23,0.92); backdrop-filter: blur(14px);
      border-bottom: 1px solid var(--border);
      position: sticky; top: 0; z-index: 100;
    }
    .topnav-inner {
      max-width: 1100px; margin: 0 auto;
      display: flex; align-items: center; justify-content: space-between;
      padding: 14px 24px;
    }
    .nav-logo { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 800; color: var(--greent); letter-spacing: -0.01em; }
    .nav-user  { display: flex; align-items: center; gap: 14px; font-size: 13px; color: var(--muted); }
    .nav-role  { font-size: 11px; padding: 3px 10px; border-radius: 999px; background: var(--greenbg); border: 1px solid var(--border); color: var(--greent); text-transform: capitalize; }
    .nav-logout { font-size: 13px; color: var(--muted); border: 1px solid rgba(255,255,255,0.09); padding: 5px 13px; border-radius: var(--r); transition: all 0.2s; }
    .nav-logout:hover { color: var(--text); border-color: rgba(255,255,255,0.22); text-decoration: none; }

    /* ── LAYOUT ── */
    .page { max-width: 1060px; margin: 0 auto; padding: 40px 24px 60px; flex: 1; }
    .page-title { font-family: 'Syne', sans-serif; font-size: clamp(22px,3.5vw,30px); font-weight: 700; letter-spacing: -0.02em; margin-bottom: 4px; }
    .page-sub   { font-size: 14px; color: var(--muted); margin-bottom: 32px; }

    /* ── CARDS ── */
    .card { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--rl); padding: 24px; }
    .card + .card { margin-top: 16px; }

    /* ── STAT GRID ── */
    .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px,1fr)); gap: 14px; margin-bottom: 28px; }
    .stat-card { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--rl); padding: 20px 22px; }
    .stat-num  { font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 700; margin-bottom: 2px; }
    .stat-label{ font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.07em; }

    /* ── TABLE ── */
    .tbl { width: 100%; border-collapse: collapse; font-size: 14px; }
    .tbl th { text-align: left; font-size: 11px; font-weight: 500; color: var(--muted); text-transform: uppercase; letter-spacing: 0.07em; padding: 10px 14px; border-bottom: 1px solid var(--border); }
    .tbl td { padding: 12px 14px; border-bottom: 1px solid rgba(255,255,255,0.04); vertical-align: middle; }
    .tbl tr:last-child td { border-bottom: none; }
    .tbl tr:hover td { background: rgba(255,255,255,0.02); }

    /* ── BADGES ── */
    .badge { display: inline-block; font-size: 11px; font-weight: 500; padding: 3px 10px; border-radius: 999px; }
    .badge-active    { background: rgba(34,197,94,0.12);  color: #4ade80; border: 1px solid rgba(34,197,94,0.2);  }
    .badge-used      { background: rgba(96,165,250,0.12); color: #60a5fa; border: 1px solid rgba(96,165,250,0.2); }
    .badge-expired   { background: rgba(255,255,255,0.06);color: var(--muted); border: 1px solid rgba(255,255,255,0.09); }
    .badge-cancelled { background: rgba(248,81,73,0.1);   color: #f85149; border: 1px solid rgba(248,81,73,0.2);  }
    .badge-warn      { background: rgba(240,136,62,0.12); color: #f0883e; border: 1px solid rgba(240,136,62,0.2); }
    .badge-granted   { background: rgba(34,197,94,0.12);  color: #4ade80; border: 1px solid rgba(34,197,94,0.2);  }
    .badge-denied    { background: rgba(248,81,73,0.1);   color: #f85149; border: 1px solid rgba(248,81,73,0.2);  }

    /* ── BUTTONS ── */
    .btn { display: inline-flex; align-items: center; gap: 7px; font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 500; padding: 10px 20px; border-radius: var(--r); border: none; cursor: pointer; transition: all 0.18s; text-decoration: none; }
    .btn:hover { text-decoration: none; }
    .btn-green   { background: var(--green); color: #0d1117; }
    .btn-green:hover { background: var(--greend); transform: translateY(-1px); }
    .btn-outline { background: transparent; color: var(--text); border: 1px solid rgba(255,255,255,0.12); }
    .btn-outline:hover { border-color: rgba(255,255,255,0.26); background: rgba(255,255,255,0.04); }
    .btn-danger  { background: transparent; color: var(--danger); border: 1px solid rgba(248,81,73,0.25); }
    .btn-danger:hover { background: rgba(248,81,73,0.08); }
    .btn-sm { font-size: 12px; padding: 6px 13px; }

    /* ── FORMS ── */
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 12px; color: var(--muted); margin-bottom: 6px; letter-spacing: 0.03em; }
    .form-input {
      width: 100%; background: var(--bg); border: 1px solid rgba(255,255,255,0.10);
      border-radius: var(--r); color: var(--text);
      font-family: 'DM Sans', sans-serif; font-size: 14px;
      padding: 10px 13px; outline: none; transition: border-color 0.2s;
    }
    .form-input:focus { border-color: rgba(74,222,128,0.4); }
    select.form-input { cursor: pointer; }
    textarea.form-input { resize: vertical; min-height: 80px; }

    /* ── FLASH ── */
    .flash { padding: 12px 16px; border-radius: var(--r); font-size: 14px; margin-bottom: 20px; }
    .flash-error   { background: rgba(248,81,73,0.10);  border: 1px solid rgba(248,81,73,0.25);  color: #f85149; }
    .flash-success { background: rgba(34,197,94,0.10);  border: 1px solid rgba(34,197,94,0.25);  color: #4ade80; }
    .flash-warn    { background: rgba(240,136,62,0.10); border: 1px solid rgba(240,136,62,0.25); color: #f0883e; }

    /* ── DIVIDER ── */
    hr { border: none; border-top: 1px solid var(--border); margin: 24px 0; }

    /* ── EMPTY STATE ── */
    .empty { text-align: center; padding: 48px 24px; color: var(--muted); font-size: 14px; }
    .empty-icon { font-size: 32px; margin-bottom: 12px; opacity: 0.4; }

    /* ── RESPONSIVE ── */
    @media (max-width: 600px) {
      .page { padding: 24px 16px 48px; }
      .stat-grid { grid-template-columns: 1fr 1fr; }
      .tbl th, .tbl td { padding: 10px 10px; }
      .hide-mobile { display: none; }
    }
  </style>
  <?php if (isset($extraHead)) echo $extraHead; ?>
</head>
<body>

<nav class="topnav">
  <div class="topnav-inner">
    <span class="nav-logo">Les Passe</span>
    <?php if (is_logged_in()): ?>
    <div class="nav-user">
      <span><?= e(current_user_name()) ?></span>
      <span class="nav-role"><?= e(current_role()) ?></span>
      <a href="<?= APP_URL ?>/auth/logout" class="nav-logout">Log out</a>
    </div>
    <?php endif; ?>
  </div>
</nav>

<div class="page">
  <?php
    $flash = get_flash();
    if ($flash):
      $cls = $flash['type'] === 'error' ? 'flash-error' : ($flash['type'] === 'warn' ? 'flash-warn' : 'flash-success');
  ?>
  <div class="flash <?= $cls ?>"><?= e($flash['message']) ?></div>
  <?php endif; ?>

  <?php echo $content ?? ''; ?>
</div>

<footer style="text-align:center;padding:20px;font-size:12px;color:var(--muted);border-top:1px solid var(--border);">
  Les Passe &copy; <?= date('Y') ?> &nbsp;·&nbsp; Estate visitor access system
</footer>

</body>
</html>