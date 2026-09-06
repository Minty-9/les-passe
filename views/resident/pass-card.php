<?php
$passId    = (int) ($segments[2] ?? 0);
$passModel = new Pass();
$pass      = $passModel->findById($passId);

if (!$pass || (int)$pass['resident_id'] !== current_user_id()) {
    set_flash('error', 'Pass not found.');
    redirect(APP_URL . '/resident');
}

if ($pass['status'] === 'active' && strtotime($pass['expires_at']) <= time()) {
    Database::connect()->prepare("UPDATE passes SET status='expired' WHERE id=?")->execute([$pass['id']]);
    $pass['status'] = 'expired';
}

$isActive   = pass_is_valid($pass);
$isExpiring = $isActive && pass_is_expiring($pass);
$remaining  = time_remaining($pass['expires_at']);
$expiryTime = date('g:i A', strtotime($pass['expires_at']));

$waTextCode = urlencode(
    "Hi! Here is your gate pass for Greenfield Estate.\n\n" .
    "Visitor: " . $pass['visitor_name'] . "\n" .
    "Access code: " . format_code($pass['code']) . "\n" .
    "Valid for: " . duration_label($pass['duration_hrs']) . "\n" .
    "Expires: " . $expiryTime . "\n\n" .
    "Show this code to security at the gate."
);

$passUrl  = APP_URL . '/resident/pass/' . $pass['id'];
$waTextQR = urlencode(
    "Hi! Here is your gate pass for Greenfield Estate.\n\n" .
    "Visitor: " . $pass['visitor_name'] . "\n" .
    "Access code: " . format_code($pass['code']) . "\n" .
    "Valid for: " . duration_label($pass['duration_hrs']) . "\n" .
    "Expires: " . $expiryTime . "\n\n" .
    "Open this link at the gate to show your QR code:\n" . $passUrl
);
?>
<?php ob_start(); ?>

<style>
/* Pass card light theme */
.pass-card-wrap { max-width: 440px; margin: 0 auto; }

.pass-card {
  background: #ffffff;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 4px 24px rgba(0,0,0,0.18), 0 1px 4px rgba(0,0,0,0.1);
  margin-bottom: 16px;
  color: #111827;
}

.pass-card-header {
  background: #0d1117;
  padding: 16px 22px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.pass-card-logo { font-family:'Syne',sans-serif; font-size:16px; font-weight:800; color:#4ade80; letter-spacing:-0.01em; }
.pass-card-sub  { font-size:10px; color:rgba(255,255,255,0.4); margin-top:1px; }
.pass-card-id   { font-family:monospace; font-size:11px; color:rgba(255,255,255,0.3); }

.pass-card-body { padding: 22px; }

/* Status pills — light versions */
.pill { display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:600; padding:5px 13px; border-radius:999px; margin-bottom:16px; }
.pill-active    { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
.pill-expiring  { background:#fffbeb; color:#92400e; border:1px solid #fde68a; }
.pill-used      { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
.pill-expired   { background:#f9fafb; color:#6b7280; border:1px solid #e5e7eb; }
.pill-cancelled { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
.pill-dot { width:7px; height:7px; border-radius:50%; background:currentColor; animation:pulse 2s infinite; }

.visitor-label { font-size:10px; color:#9ca3af; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:3px; }
.visitor-name  { font-size:20px; font-weight:600; color:#111827; margin-bottom:18px; }

/* Code block */
.code-block {
  background: #f8fafc;
  border: 1.5px solid #e2e8f0;
  border-radius: 14px;
  padding: 20px;
  text-align: center;
  margin-bottom: 14px;
}
.code-label  { font-size:10px; color:#9ca3af; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:10px; }
.code-digits { font-family:monospace; font-size:38px; font-weight:700; letter-spacing:0.22em; color:#111827; margin-bottom:<?= $isActive ? '16px' : '0' ?>; }
.code-expired { opacity:0.25; }
.qr-wrap { display:inline-block; background:#fff; border:1.5px solid #e2e8f0; padding:8px; border-radius:10px; }
.qr-note { font-size:11px; color:#9ca3af; margin-top:8px; }

/* Meta */
.meta-divider { border:none; border-top:1px solid #f1f5f9; margin:16px 0; }
.meta-row { display:flex; justify-content:space-between; align-items:center; font-size:13px; margin-bottom:7px; }
.meta-label { color:#9ca3af; }
.meta-val   { color:#374151; font-weight:500; }

/* Countdown */
.countdown-bar { text-align:center; font-size:13px; color:#6b7280; margin-bottom:16px; }
.countdown-num { font-family:monospace; font-weight:600; color:#111827; }
.countdown-warn { color:#d97706; }

/* Action buttons — light style */
.action-copy {
  width:100%; padding:11px; border-radius:10px;
  border:1.5px solid #e2e8f0; background:#fff;
  color:#374151; font-size:13px; font-weight:500;
  cursor:pointer; display:flex; align-items:center;
  justify-content:center; gap:8px; margin-bottom:9px;
  transition:all 0.18s;
}
.action-copy:hover { border-color:#30dc80; background:#f0fdf4; }

.action-wa-code {
  width:100%; padding:11px; border-radius:10px;
  border:none; background:#25D366; color:#fff;
  font-size:13px; font-weight:600;
  cursor:pointer; display:flex; align-items:center;
  justify-content:center; gap:8px; margin-bottom:9px;
  transition:opacity 0.18s; text-decoration:none;
}
.action-wa-code:hover { opacity:0.88; }

.action-wa-qr {
  width:100%; padding:11px; border-radius:10px;
  border:1.5px solid #25D366; background:#fff;
  color:#16a34a; font-size:13px; font-weight:500;
  cursor:pointer; display:flex; align-items:center;
  justify-content:center; gap:8px;
  transition:all 0.18s; text-decoration:none;
}
.action-wa-qr:hover { background:#f0fdf4; }

.action-new {
  width:100%; padding:11px; border-radius:10px;
  border:1.5px solid #e2e8f0; background:#f9fafb;
  color:#6b7280; font-size:13px;
  cursor:pointer; display:flex; align-items:center;
  justify-content:center; gap:8px; text-decoration:none;
  transition:all 0.18s;
}
.action-new:hover { border-color:#30dc80; color:#374151; }

.pass-card-footer {
  background:#f8fafc;
  border-top:1px solid #f1f5f9;
  padding:10px 22px;
  display:flex; justify-content:space-between;
  font-size:11px; color:#9ca3af;
}
</style>

<div class="pass-card-wrap">
  <a href="<?= APP_URL ?>/resident" class="btn btn-outline btn-sm" style="margin-bottom:20px;">← Back to dashboard</a>

  <div class="pass-card">
    <!-- Header -->
    <div class="pass-card-header">
      <div>
        <div class="pass-card-logo">Les Passe</div>
        <div class="pass-card-sub">Estate visitor access system</div>
      </div>
      <div class="pass-card-id">PASS-<?= str_pad($pass['id'], 4, '0', STR_PAD_LEFT) ?></div>
    </div>

    <div class="pass-card-body">
      <!-- Status -->
      <?php if ($isExpiring): ?>
        <span class="pill pill-expiring"><span class="pill-dot"></span>Expiring in <?= $remaining ?></span>
      <?php elseif ($isActive): ?>
        <span class="pill pill-active"><span class="pill-dot"></span>Pass active</span>
      <?php elseif ($pass['status'] === 'used'): ?>
        <span class="pill pill-used">✓ Used at gate</span>
      <?php elseif ($pass['status'] === 'cancelled'): ?>
        <span class="pill pill-cancelled">Cancelled</span>
      <?php else: ?>
        <span class="pill pill-expired">Expired</span>
      <?php endif; ?>

      <!-- Visitor -->
      <div class="visitor-label">Visitor</div>
      <div class="visitor-name"><?= e($pass['visitor_name']) ?></div>

      <!-- Code + QR -->
      <div class="code-block <?= !$isActive ? 'code-expired' : '' ?>">
        <div class="code-label">Access code</div>
        <div class="code-digits"><?= format_code($pass['code']) ?></div>
        <?php if ($isActive): ?>
        <div class="qr-wrap">
          <?= qr_code_img($pass['code'], 140) ?>
        </div>
        <div class="qr-note">Guard can scan this QR at the gate</div>
        <?php endif; ?>
      </div>

      <?php if ($isActive): ?>
      <div class="countdown-bar">
        Expires in <span id="countdown" class="countdown-num <?= $isExpiring ? 'countdown-warn' : '' ?>"><?= $remaining ?></span>
      </div>
      <?php endif; ?>

      <hr class="meta-divider" />

      <!-- Meta -->
      <div class="meta-row"><span class="meta-label">Issued by</span><span class="meta-val">Unit <?= e($_SESSION['unit'] ?? '—') ?> — <?= e(current_user_name()) ?></span></div>
      <div class="meta-row"><span class="meta-label">Valid for</span><span class="meta-val"><?= duration_label($pass['duration_hrs']) ?></span></div>
      <div class="meta-row" style="margin-bottom:<?= $pass['visitor_phone'] ? '7px' : '18px' ?>;"><span class="meta-label">Issued</span><span class="meta-val"><?= friendly_time($pass['created_at']) ?></span></div>
      <?php if ($pass['visitor_phone']): ?>
      <div class="meta-row" style="margin-bottom:18px;"><span class="meta-label">Visitor phone</span><span class="meta-val"><?= e($pass['visitor_phone']) ?></span></div>
      <?php endif; ?>

      <!-- Actions -->
      <?php if ($isActive): ?>
        <button class="action-copy" onclick="copyCode('<?= $pass['code'] ?>')">📋 Copy access code</button>
        <div style="font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;text-align:center;margin:8px 0 6px;">Share via WhatsApp</div>
        <a href="https://wa.me/?text=<?= $waTextCode ?>" target="_blank" class="action-wa-code">📱 Send code only</a>
        <a href="https://wa.me/?text=<?= $waTextQR ?>" target="_blank" class="action-wa-qr">🔲 Send code + QR card link</a>
      <?php else: ?>
        <a href="<?= APP_URL ?>/resident/generate" class="action-new">+ Generate new pass</a>
      <?php endif; ?>
    </div>

    <div class="pass-card-footer">
      <span>lespasse.ng</span>
      <span>Greenfield Estate</span>
    </div>
  </div>
</div>

<script>
function copyCode(code) {
  navigator.clipboard.writeText(code).then(() => {
    const btn = document.querySelector('.action-copy');
    const orig = btn.innerHTML;
    btn.innerHTML = '✓ Copied!';
    btn.style.background = '#f0fdf4';
    btn.style.borderColor = '#30dc80';
    btn.style.color = '#15803d';
    setTimeout(() => { btn.innerHTML = orig; btn.style.background=''; btn.style.borderColor=''; btn.style.color=''; }, 2000);
  });
}

<?php if ($isActive): ?>
const expiresAt = <?= strtotime($pass['expires_at']) ?> * 1000;
function updateCountdown() {
  const diff = Math.floor((expiresAt - Date.now()) / 1000);
  if (diff <= 0) { document.getElementById('countdown').textContent = 'Expired'; location.reload(); return; }
  const h = Math.floor(diff / 3600);
  const m = Math.floor((diff % 3600) / 60);
  const s = diff % 60;
  const str = h > 0 ? h+'h '+m+'m' : m > 0 ? m+'m '+s+'s' : s+'s';
  const el = document.getElementById('countdown');
  el.textContent = str;
  if (diff < 900) el.classList.add('countdown-warn');
}
updateCountdown();
setInterval(updateCountdown, 1000);
<?php endif; ?>
</script>

<?php
$content   = ob_get_clean();
$pageTitle = 'Pass — ' . $pass['visitor_name'];
require_once __DIR__ . '/../../views/layouts/base.php';
?>