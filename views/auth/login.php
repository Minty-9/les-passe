<?php
// Handle POST login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']    ?? '');
    $password = trim($_POST['password'] ?? '');
    $error    = null;

    if (!$email || !$password) {
        $error = 'Please fill in all fields.';
    } else {
        $userModel = new User();
        $user      = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $error = 'Incorrect email or password.';
        } elseif ($user['status'] === 'suspended') {
            $error = 'Your account has been suspended. Contact your estate admin.';
        } else {
            login_user($user);
            redirect_by_role();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login — Les Passe</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg: #0d1117; --bg2: #161b22; --bg3: #1c2330;
      --border: rgba(48,220,128,0.10); --border-h: rgba(48,220,128,0.28);
      --green: #30dc80; --greend: #22c55e; --greent: #4ade80;
      --greenbg: rgba(48,220,128,0.07); --muted: #8b949e; --text: #e6edf3;
      --danger: #f85149; --r: 10px; --rl: 16px;
    }
    body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; font-size: 15px; line-height: 1.65; -webkit-font-smoothing: antialiased; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px; }
    .brand { font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 800; color: var(--greent); letter-spacing: -0.01em; margin-bottom: 6px; }
    .brand-sub { font-size: 13px; color: var(--muted); margin-bottom: 32px; text-align: center; }
    .box { background: var(--bg2); border: 1px solid var(--border); border-radius: var(--rl); padding: 32px; width: 100%; max-width: 400px; }
    .box-title { font-family: 'Syne', sans-serif; font-size: 20px; font-weight: 700; margin-bottom: 4px; }
    .box-sub   { font-size: 13px; color: var(--muted); margin-bottom: 24px; }
    .form-group { margin-bottom: 15px; }
    .form-group label { display: block; font-size: 12px; color: var(--muted); margin-bottom: 5px; }
    .form-input { width: 100%; background: var(--bg3); border: 1px solid rgba(255,255,255,0.09); border-radius: var(--r); color: var(--text); font-family: 'DM Sans', sans-serif; font-size: 14px; padding: 10px 13px; outline: none; transition: border-color 0.2s; }
    .form-input:focus { border-color: rgba(74,222,128,0.4); }
    .btn-green { width: 100%; background: var(--green); color: #0d1117; font-family: 'DM Sans', sans-serif; font-size: 14px; font-weight: 600; padding: 11px; border-radius: var(--r); border: none; cursor: pointer; transition: background 0.2s, transform 0.15s; margin-top: 4px; }
    .btn-green:hover { background: var(--greend); transform: translateY(-1px); }
    .error { background: rgba(248,81,73,0.10); border: 1px solid rgba(248,81,73,0.25); color: var(--danger); font-size: 13px; padding: 10px 14px; border-radius: var(--r); margin-bottom: 18px; }
    .demo-box { margin-top: 20px; background: var(--bg3); border: 1px solid var(--border); border-radius: var(--r); padding: 14px 16px; font-size: 12px; color: var(--muted); line-height: 1.8; }
    .demo-box strong { color: var(--greent); }
    .divider { border: none; border-top: 1px solid var(--border); margin: 20px 0; }
    .register-link { text-align: center; font-size: 13px; color: var(--muted); margin-top: 16px; }
    .register-link a { color: var(--greent); }
    /* Grid glow */
    body::before { content:''; position:fixed; inset:0; pointer-events:none; background-image: linear-gradient(rgba(48,220,128,0.03) 1px,transparent 1px), linear-gradient(90deg,rgba(48,220,128,0.03) 1px,transparent 1px); background-size:48px 48px; -webkit-mask-image:radial-gradient(ellipse 80% 80% at 50% 0%,black 30%,transparent 100%); mask-image:radial-gradient(ellipse 80% 80% at 50% 0%,black 30%,transparent 100%); }
  </style>
</head>
<body>
  <div class="brand">Les Passe</div>
  <div class="brand-sub">Estate visitor access system</div>

  <div class="box">
    <h1 class="box-title">Welcome back</h1>
    <p class="box-sub">Sign in to your account</p>

    <?php if (!empty($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= APP_URL ?>/auth/login">
      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" id="email" name="email" class="form-input"
               placeholder="you@estate.ng"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
               required autofocus />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-input"
               placeholder="Your password" required />
      </div>
      <button type="submit" class="btn-green">Sign in →</button>
    </form>

    <hr class="divider" />

    <div class="demo-box">
      <strong>Demo accounts</strong> — password for all: <strong>Demo@1234</strong><br>
      Admin &nbsp;&nbsp;&nbsp;→ admin@lespasse.ng<br>
      Resident → resident@lespasse.ng<br>
      Guard &nbsp;&nbsp;&nbsp;→ guard@lespasse.ng
    </div>
  </div>

  <div class="register-link">
    New resident? <a href="<?= APP_URL ?>/auth/register">Create an account</a>
  </div>
</body>
</html>