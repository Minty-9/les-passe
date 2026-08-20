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

// WhatsApp share text — code only, no site link
$expiryTime   = date('g:i A', strtotime($pass['expires_at']));
$waTextCode   = urlencode(
    "Hi! Here is your gate pass for Greenfield Estate.\n\n" .
    "Visitor: " . $pass['visitor_name'] . "\n" .
    "Access code: " . format_code($pass['code']) . "\n" .
    "Valid for: " . duration_label($pass['duration_hrs']) . "\n" .
    "Expires: " . $expiryTime . "\n\n" .
    "Show this code to security at the gate."
);

// WhatsApp share — QR card link (visitor opens on phone, guard scans)
$passUrl    = APP_URL . '/resident/pass/' . $pass['id'];
$waTextQR   = urlencode(
    "Hi! Here is your gate pass for Greenfield Estate.\n\n" .
    "Visitor: " . $pass['visitor_name'] . "\n" .
    "Access code: " . format_code($pass['code']) . "\n" .
    "Valid for: " . duration_label($pass['duration_hrs']) . "\n" .
    "Expires: " . $expiryTime . "\n\n" .
    "Open this link at the gate to show your QR code:\n" . $passUrl
);
?>
<?php ob_start(); ?>

<div style="max-width:480px;margin:0 auto;">
  <a href="<?= APP_URL ?>/resident" class="btn btn-outline btn-sm" style="margin-bottom:24px;">← Back to dashboard</a>

  <!-- PASS CARD -->
  <div style="background:var(--bg2);border:1px solid <?= $isExpiring ? 'rgba(240,136,62,0.4)' : ($isActive ? 'var(--border-h)' : 'var(--border)') ?>;border-radius:var(--rl);overflow:hidden;margin-bottom:16px;">

    <!-- Header -->
    <div style="background:#0d1117;padding:18px 24px 14px;border-bottom:1px solid var(--border);display:flex;justify-content:space-between;align-items:center;">
      <div>
        <div style="font-family:'Syne',sans-serif;font-size:17px;font-weight:800;color:var(--greent);letter-spacing:-0.01em;">Les Passe</div>
        <div style="font-size:11px;color:var(--muted);margin-top:1px;">Estate visitor access system</div>
      </div>
      <div style="font-size:12px;color:var(--muted);">PASS-<?= str_pad($pass['id'], 4, '0', STR_PAD_LEFT) ?></div>
    </div>

    <div style="padding:24px;">

      <!-- Status pill -->
      <div style="margin-bottom:16px;">
        <?php if ($isExpiring): ?>
          <span class="badge badge-warn" style="font-size:12px;padding:5px 13px;">⚠ Expiring in <?= $remaining ?></span>
        <?php elseif ($isActive): ?>
          <span class="badge badge-active" style="font-size:12px;padding:5px 13px;"><span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#4ade80;margin-right:5px;animation:pulse 2s infinite;"></span>Pass active</span>
        <?php elseif ($pass['status'] === 'used'): ?>
          <span class="badge badge-used" style="font-size:12px;padding:5px 13px;">✓ Used at gate</span>
        <?php elseif ($pass['status'] === 'cancelled'): ?>
          <span class="badge badge-cancelled" style="font-size:12px;padding:5px 13px;">Cancelled</span>
        <?php else: ?>
          <span class="badge badge-expired" style="font-size:12px;padding:5px 13px;">Expired</span>
        <?php endif; ?>
      </div>

      <!-- Visitor -->
      <div style="font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:4px;">Visitor</div>
      <div style="font-size:20px;font-weight:500;margin-bottom:20px;"><?= e($pass['visitor_name']) ?></div>

      <!-- Code + QR -->
      <div style="background:var(--bg3);border:1px solid var(--border);border-radius:var(--r);padding:20px;text-align:center;margin-bottom:16px;<?= !$isActive ? 'opacity:0.35;' : '' ?>">
        <div style="font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.1em;margin-bottom:10px;">Access code</div>
        <div style="font-family:monospace;font-size:36px;font-weight:500;letter-spacing:0.2em;color:var(--greent);margin-bottom:<?= $isActive ? '16px' : '0' ?>;">
          <?= format_code($pass['code']) ?>
        </div>
        <?php if ($isActive): ?>
        <div style="display:inline-block;background:#fff;padding:8px;border-radius:8px;">
          <?= qr_code_img($pass['code'], 140) ?>
        </div>
        <div style="font-size:11px;color:var(--muted);margin-top:10px;">Guard can scan this QR at the gate</div>
        <?php endif; ?>
      </div>

      <?php if ($isActive): ?>
      <!-- Countdown -->
      <div style="text-align:center;font-size:13px;color:var(--muted);margin-bottom:18px;">
        Expires in <span id="countdown" style="font-family:monospace;font-weight:500;color:<?= $isExpiring ? 'var(--warn)' : 'var(--text)' ?>;"><?= $remaining ?></span>
      </div>
      <?php endif; ?>

      <hr style="border:none;border-top:1px solid var(--border);margin:16px 0;" />

      <!-- Meta -->
      <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:20px;font-size:13px;">
        <div style="display:flex;justify-content:space-between;">
          <span style="color:var(--muted);">Issued by</span>
          <span>Unit <?= e($_SESSION['unit'] ?? '—') ?> — <?= e(current_user_name()) ?></span>
        </div>
        <div style="display:flex;justify-content:space-between;">
          <span style="color:var(--muted);">Valid for</span>
          <span><?= duration_label($pass['duration_hrs']) ?></span>
        </div>
        <div style="display:flex;justify-content:space-between;">
          <span style="color:var(--muted);">Issued</span>
          <span><?= friendly_time($pass['created_at']) ?></span>
        </div>
        <?php if ($pass['visitor_phone']): ?>
        <div style="display:flex;justify-content:space-between;">
          <span style="color:var(--muted);">Visitor phone</span>
          <span><?= e($pass['visitor_phone']) ?></span>
        </div>
        <?php endif; ?>
      </div>

      <!-- Actions -->
      <?php if ($isActive): ?>
      <div style="display:flex;flex-direction:column;gap:9px;">

        <!-- Copy code -->
        <button onclick="copyCode('<?= $pass['code'] ?>')" class="btn btn-outline" style="width:100%;justify-content:center;">
          📋 Copy access code
        </button>

        <!-- Share options label -->
        <div style="font-size:11px;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;text-align:center;margin:4px 0 2px;">Share via WhatsApp</div>

        <!-- Share code only -->
        <a href="https://wa.me/?text=<?= $waTextCode ?>" target="_blank"
           style="display:flex;align-items:center;justify-content:center;gap:8px;padding:11px;border-radius:var(--r);background:#25D366;color:#fff;font-size:13px;font-weight:600;text-decoration:none;">
          📱 Send code only
        </a>

        <!-- Share QR card link -->
        <a href="https://wa.me/?text=<?= $waTextQR ?>" target="_blank"
           style="display:flex;align-items:center;justify-content:center;gap:8px;padding:11px;border-radius:var(--r);background:transparent;color:#25D366;font-size:13px;font-weight:500;text-decoration:none;border:1px solid rgba(37,211,102,0.35);">
          🔲 Send code + QR card link
        </a>

      </div>
      <?php else: ?>
      <a href="<?= APP_URL ?>/resident/generate" class="btn btn-outline" style="width:100%;justify-content:center;">
        + Generate new pass
      </a>
      <?php endif; ?>

    </div>

    <!-- Footer -->
    <div style="background:var(--bg3);padding:10px 24px;border-top:1px solid var(--border);display:flex;justify-content:space-between;font-size:11px;color:var(--muted);">
      <span>lespasse.ng</span>
      <span>Greenfield Estate</span>
    </div>

  </div>
</div>

<style>
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }
</style>

<script>
function copyCode(code) {
  navigator.clipboard.writeText(code).then(() => {
    const btn = document.querySelector('[onclick^="copyCode"]');
    const orig = btn.innerHTML;
    btn.innerHTML = '✓ Copied!';
    btn.style.color = 'var(--greent)';
    setTimeout(() => { btn.innerHTML = orig; btn.style.color = ''; }, 2000);
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
  let str = h > 0 ? h + 'h ' + m + 'm' : m > 0 ? m + 'm ' + s + 's' : s + 's';
  document.getElementById('countdown').textContent = str;
  if (diff < 900) document.getElementById('countdown').style.color = 'var(--warn)';
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