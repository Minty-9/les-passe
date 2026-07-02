<?php
$result   = null;
$pass     = null;
$logModel = new EntryLog();

// Handle POST — code typed manually
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code      = trim($_POST['code'] ?? '');
    $code      = preg_replace('/\D/', '', $code); // strip non-digits
    $codeEntered = str_pad($code, 6, '0', STR_PAD_LEFT);

    if (strlen($code) !== 6) {
        $result = 'invalid_format';
    } else {
        $passModel = new Pass();
        $pass      = $passModel->findByCode($codeEntered);

        if (!$pass) {
            // Code doesn't exist
            $result = 'denied_invalid';
            $logModel->record([
                'estate_id'    => current_estate_id(),
                'pass_id'      => null,
                'guard_id'     => current_user_id(),
                'code_entered' => $codeEntered,
                'result'       => 'denied_invalid',
            ]);
        } elseif ($pass['status'] === 'used') {
            $result = 'denied_used';
            $logModel->record([
                'estate_id'    => current_estate_id(),
                'pass_id'      => $pass['id'],
                'guard_id'     => current_user_id(),
                'code_entered' => $codeEntered,
                'result'       => 'denied_used',
            ]);
        } elseif ($pass['status'] === 'cancelled' || $pass['status'] === 'expired' || strtotime($pass['expires_at']) <= time()) {
            $result = 'denied_expired';
            // Mark expired in DB if not already
            if ($pass['status'] === 'active') {
                Database::connect()->prepare("UPDATE passes SET status='expired' WHERE id=?")->execute([$pass['id']]);
            }
            $logModel->record([
                'estate_id'    => current_estate_id(),
                'pass_id'      => $pass['id'],
                'guard_id'     => current_user_id(),
                'code_entered' => $codeEntered,
                'result'       => 'denied_expired',
            ]);
        } else {
            // GRANTED — mark pass as used
            $result = 'granted';
            $passModel->markUsed($pass['id']);
            $logModel->record([
                'estate_id'    => current_estate_id(),
                'pass_id'      => $pass['id'],
                'guard_id'     => current_user_id(),
                'code_entered' => $codeEntered,
                'result'       => 'granted',
            ]);
        }
    }
}

// Handle GET — QR scan lands here with ?code=XXXXXX
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['code'])) {
    $_POST['code'] = $_GET['code'];
    $_SERVER['REQUEST_METHOD'] = 'POST';
    // Re-run by redirecting to POST equivalent
    header('Location: ' . APP_URL . '/guard/verify');
    exit;
}
?>
<?php ob_start(); ?>

<div style="max-width:480px;margin:0 auto;">

  <h1 class="page-title">Verify visitor pass</h1>
  <p class="page-sub">Enter the 6-digit code or scan the visitor's QR code.</p>

  <!-- RESULT — GRANTED -->
  <?php if ($result === 'granted' && $pass): ?>
  <div style="background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.3);border-radius:var(--rl);padding:28px 24px;text-align:center;margin-bottom:20px;">
    <div style="font-size:52px;margin-bottom:8px;">✅</div>
    <div style="font-family:'Syne',sans-serif;font-size:24px;font-weight:700;color:#4ade80;margin-bottom:4px;">Access Granted</div>
    <div style="font-size:15px;color:var(--muted);margin-bottom:20px;">Visitor may proceed</div>
    <div style="background:var(--bg2);border:1px solid var(--border);border-radius:var(--r);padding:16px;text-align:left;margin-bottom:16px;">
      <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:14px;">
        <span style="color:var(--muted);">Visitor</span>
        <span style="font-weight:500;"><?= e($pass['visitor_name']) ?></span>
      </div>
      <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:14px;">
        <span style="color:var(--muted);">Resident</span>
        <span>Unit <?= e($pass['unit']) ?> — <?= e($pass['resident_name']) ?></span>
      </div>
      <div style="display:flex;justify-content:space-between;font-size:14px;">
        <span style="color:var(--muted);">Code used</span>
        <span style="font-family:monospace;letter-spacing:0.12em;"><?= format_code($pass['code']) ?></span>
      </div>
    </div>
    <div style="font-size:12px;color:var(--muted);">Pass has been marked as used and cannot be reused.</div>
  </div>

  <!-- RESULT — DENIED (invalid code) -->
  <?php elseif ($result === 'denied_invalid'): ?>
  <div style="background:rgba(248,81,73,0.08);border:1px solid rgba(248,81,73,0.3);border-radius:var(--rl);padding:28px 24px;text-align:center;margin-bottom:20px;">
    <div style="font-size:52px;margin-bottom:8px;">❌</div>
    <div style="font-family:'Syne',sans-serif;font-size:24px;font-weight:700;color:#f85149;margin-bottom:4px;">Access Denied</div>
    <div style="font-size:14px;color:var(--muted);">This code does not exist. Ask the visitor to check with their host.</div>
  </div>

  <!-- RESULT — DENIED (expired) -->
  <?php elseif ($result === 'denied_expired'): ?>
  <div style="background:rgba(248,81,73,0.08);border:1px solid rgba(248,81,73,0.3);border-radius:var(--rl);padding:28px 24px;text-align:center;margin-bottom:20px;">
    <div style="font-size:52px;margin-bottom:8px;">⏰</div>
    <div style="font-family:'Syne',sans-serif;font-size:24px;font-weight:700;color:#f85149;margin-bottom:4px;">Pass Expired</div>
    <div style="font-size:14px;color:var(--muted);margin-bottom:12px;">This pass has expired or been cancelled.</div>
    <?php if ($pass): ?>
    <div style="background:var(--bg2);border:1px solid var(--border);border-radius:var(--r);padding:14px;text-align:left;font-size:13px;">
      <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
        <span style="color:var(--muted);">Visitor</span>
        <span><?= e($pass['visitor_name']) ?></span>
      </div>
      <div style="display:flex;justify-content:space-between;">
        <span style="color:var(--muted);">Expired at</span>
        <span><?= friendly_time($pass['expires_at']) ?></span>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <!-- RESULT — DENIED (already used) -->
  <?php elseif ($result === 'denied_used'): ?>
  <div style="background:rgba(248,81,73,0.08);border:1px solid rgba(248,81,73,0.3);border-radius:var(--rl);padding:28px 24px;text-align:center;margin-bottom:20px;">
    <div style="font-size:52px;margin-bottom:8px;">🔒</div>
    <div style="font-family:'Syne',sans-serif;font-size:24px;font-weight:700;color:#f85149;margin-bottom:4px;">Already Used</div>
    <div style="font-size:14px;color:var(--muted);margin-bottom:12px;">This pass has already been used at the gate.</div>
    <?php if ($pass): ?>
    <div style="background:var(--bg2);border:1px solid var(--border);border-radius:var(--r);padding:14px;text-align:left;font-size:13px;">
      <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
        <span style="color:var(--muted);">Visitor</span>
        <span><?= e($pass['visitor_name']) ?></span>
      </div>
      <div style="display:flex;justify-content:space-between;">
        <span style="color:var(--muted);">Resident</span>
        <span>Unit <?= e($pass['unit']) ?></span>
      </div>
    </div>
    <?php endif; ?>
  </div>

  <!-- RESULT — bad format -->
  <?php elseif ($result === 'invalid_format'): ?>
  <div class="flash flash-error" style="margin-bottom:16px;">Please enter a valid 6-digit code.</div>
  <?php endif; ?>

  <!-- CODE ENTRY FORM — always visible -->
  <div class="card">
    <div style="font-size:13px;font-weight:500;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:16px;">Enter access code</div>
    <form method="POST" action="<?= APP_URL ?>/guard/verify" id="verify-form">
      <div style="margin-bottom:16px;">
        <input
          type="text"
          name="code"
          id="code-input"
          class="form-input"
          placeholder="_ _ _ _ _ _"
          maxlength="7"
          inputmode="numeric"
          autocomplete="off"
          autofocus
          style="font-family:monospace;font-size:28px;letter-spacing:0.2em;text-align:center;padding:16px;"
        />
        <div style="font-size:12px;color:var(--muted);margin-top:6px;text-align:center;">Type the 6-digit code from the visitor's pass</div>
      </div>
      <button type="submit" class="btn btn-green" style="width:100%;justify-content:center;font-size:15px;padding:13px;">
        Verify pass →
      </button>
    </form>
  </div>

  <!-- QR SCANNER -->
  <div class="card" style="margin-top:14px;">
    <div style="font-size:13px;font-weight:500;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:14px;">Or scan QR code</div>
    <div id="qr-reader" style="width:100%;border-radius:var(--r);overflow:hidden;background:var(--bg3);min-height:200px;display:flex;align-items:center;justify-content:center;">
      <div id="qr-placeholder" style="text-align:center;color:var(--muted);padding:32px;font-size:14px;">
        <div style="font-size:36px;margin-bottom:10px;opacity:0.4;">📷</div>
        <button onclick="startScanner()" class="btn btn-outline" style="font-size:13px;">Start camera</button>
      </div>
    </div>
    <div id="qr-status" style="font-size:12px;color:var(--muted);text-align:center;margin-top:8px;display:none;">Scanning — point camera at QR code</div>
  </div>

</div>

<!-- QR Scanner library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
  // Auto-format code input — add · after 3 digits visually, strip on submit
  const input = document.getElementById('code-input');
  const form  = document.getElementById('verify-form');

  input.addEventListener('input', () => {
    let val = input.value.replace(/\D/g, '');
    if (val.length > 6) val = val.slice(0, 6);
    // Display with middle dot
    input.value = val.length > 3 ? val.slice(0,3) + '·' + val.slice(3) : val;
  });

  // Strip dot before submit
  form.addEventListener('submit', () => {
    input.value = input.value.replace(/\D/g, '');
  });

  // QR Scanner
  let scanner = null;
  function startScanner() {
    document.getElementById('qr-placeholder').innerHTML = '<div style="color:var(--muted);font-size:13px;padding:16px;">Starting camera...</div>';
    document.getElementById('qr-status').style.display = 'block';
    scanner = new Html5Qrcode('qr-reader');
    scanner.start(
      { facingMode: 'environment' },
      { fps: 10, qrbox: { width: 220, height: 220 } },
      (decodedText) => {
        // Extract code from URL or use raw value
        let code = decodedText;
        const match = decodedText.match(/code=(\d{6})/);
        if (match) code = match[1];
        scanner.stop().then(() => {
          // Submit the form with scanned code
          input.value = code;
          form.submit();
        });
      },
      () => {} // scan failure — silent
    ).catch(() => {
      document.getElementById('qr-placeholder').innerHTML = '<div style="color:var(--danger);font-size:13px;padding:16px;">Camera access denied. Please allow camera or use code entry above.</div>';
    });
  }
</script>

<?php
$content   = ob_get_clean();
$pageTitle = 'Verify Pass';
require_once 'views/layouts/base.php';
?>