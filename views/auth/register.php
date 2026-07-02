<?php
// Handle POST registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']     ?? '');
    $email    = trim($_POST['email']    ?? '');
    $phone    = trim($_POST['phone']    ?? '');
    $unit     = trim($_POST['unit']     ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm']  ?? '');
    $error    = null;

    if (!$name || !$email || !$password || !$unit) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $userModel = new User();
        // Check email not already taken
        if ($userModel->findByEmail($email)) {
            $error = 'An account with this email already exists.';
        } else {
            $created = $userModel->create([
                'estate_id' => 1, // default estate — admin can reassign
                'name'      => $name,
                'email'     => $email,
                'phone'     => $phone ?: null,
                'password'  => password_hash($password, PASSWORD_BCRYPT),
                'role'      => 'resident',
                'unit'      => $unit,
            ]);
            if ($created) {
                set_flash('success', 'Account created! You can now sign in.');
                redirect(APP_URL . '/auth/login');
            } else {
                $error = 'Something went wrong. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register — Les Passe</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --bg: #0d1117; --bg2: #161b22; --bg3: #1c2330;
      --border: rgba(48,220,128,0.10);
      --green: #30dc80; --greend: #22c55e; --greent: #4ade80;
      --muted: #8b949e; --text: #e6edf3; --danger: #f85149;
      --r: 10px; --rl: 16px;
    }
    body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; font-size: 15px; line-height: 1.65; -webkit-font-smoothing: antialiased; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 24px; }
    body::before { content:''; position:fixed; inset:0; pointer-events:none; background-image:linear-gradient(rgba(48,220,128,0.03) 1px,transparent 1px),linear-gradient(90deg,rgba(48,220,128,0.03) 1px,transparent 1px); background-size:48px 48px; -webkit-mask-image:radial-gradient(ellipse 80% 80% at 50% 0%,black 30%,transparent 100%); mask-image:radial-gradient(ellipse 80% 80% at 50% 0%,black 30%,transparent 100%); }
    .brand { font-family:'Syne',sans-serif; font-size:22px; font-weight:800; color:var(--greent); margin-bottom:6px; }
    .brand-sub { font-size:13px; color:var(--muted); margin-bottom:28px; }
    .box { background:var(--bg2); border:1px solid var(--border); border-radius:var(--rl); padding:32px; width:100%; max-width:420px; }
    .box-title { font-family:'Syne',sans-serif; font-size:20px; font-weight:700; margin-bottom:4px; }
    .box-sub { font-size:13px; color:var(--muted); margin-bottom:22px; }
    .form-group { margin-bottom:14px; }
    .form-group label { display:block; font-size:12px; color:var(--muted); margin-bottom:5px; }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    .form-input { width:100%; background:var(--bg3); border:1px solid rgba(255,255,255,0.09); border-radius:var(--r); color:var(--text); font-family:'DM Sans',sans-serif; font-size:14px; padding:10px 13px; outline:none; transition:border-color 0.2s; }
    .form-input:focus { border-color:rgba(74,222,128,0.4); }
    .btn-green { width:100%; background:var(--green); color:#0d1117; font-family:'DM Sans',sans-serif; font-size:14px; font-weight:600; padding:11px; border-radius:var(--r); border:none; cursor:pointer; transition:background 0.2s,transform 0.15s; margin-top:6px; }
    .btn-green:hover { background:var(--greend); transform:translateY(-1px); }
    .error { background:rgba(248,81,73,0.10); border:1px solid rgba(248,81,73,0.25); color:var(--danger); font-size:13px; padding:10px 14px; border-radius:var(--r); margin-bottom:16px; }
    .hint { font-size:12px; color:var(--muted); margin-top:4px; }
    .divider { border:none; border-top:1px solid rgba(255,255,255,0.07); margin:20px 0; }
    .login-link { text-align:center; font-size:13px; color:var(--muted); margin-top:16px; }
    .login-link a { color:var(--greent); }
    .required { color:var(--greent); }
  </style>
</head>
<body>
  <div class="brand">Les Passe</div>
  <div class="brand-sub">Create your resident account</div>

  <div class="box">
    <h1 class="box-title">Create account</h1>
    <p class="box-sub">Register as a resident to start generating visitor passes.</p>

    <?php if (!empty($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= APP_URL ?>/auth/register">
      <div class="form-group">
        <label>Full name <span class="required">*</span></label>
        <input type="text" name="name" class="form-input"
               placeholder="Chukwuemeka Ade"
               value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required />
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Unit / House no. <span class="required">*</span></label>
          <input type="text" name="unit" class="form-input"
                 placeholder="e.g. C14"
                 value="<?= htmlspecialchars($_POST['unit'] ?? '') ?>" required />
        </div>
        <div class="form-group">
          <label>Phone number</label>
          <input type="tel" name="phone" class="form-input"
                 placeholder="080XXXXXXXX"
                 value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" />
        </div>
      </div>

      <div class="form-group">
        <label>Email address <span class="required">*</span></label>
        <input type="email" name="email" class="form-input"
               placeholder="you@email.com"
               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required />
      </div>

      <div class="form-row">
        <div class="form-group">
          <label>Password <span class="required">*</span></label>
          <input type="password" name="password" class="form-input"
                 placeholder="Min. 8 characters" required />
        </div>
        <div class="form-group">
          <label>Confirm password</label>
          <input type="password" name="confirm" class="form-input"
                 placeholder="Repeat password" required />
        </div>
      </div>

      <button type="submit" class="btn-green">Create account →</button>
    </form>
  </div>

  <div class="login-link">
    Already have an account? <a href="<?= APP_URL ?>/auth/login">Sign in</a>
  </div>
</body>
</html>