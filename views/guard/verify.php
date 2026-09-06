<?php
$result   = null;
$pass     = null;
$logModel = new EntryLog();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code        = preg_replace('/\D/', '', trim($_POST['code'] ?? ''));
    $codeEntered = str_pad($code, 6, '0', STR_PAD_LEFT);

    if (strlen($code) !== 6) {
        $result = 'invalid_format';
    } else {
        $passModel = new Pass();
        $pass      = $passModel->findByCode($codeEntered);

        if (!$pass) {
            $result = 'denied_invalid';
            $logModel->record(['estate_id'=>current_estate_id(),'pass_id'=>null,'guard_id'=>current_user_id(),'code_entered'=>$codeEntered,'result'=>'denied_invalid']);
        } elseif ($pass['status'] === 'used') {
            $result = 'denied_used';
            $logModel->record(['estate_id'=>current_estate_id(),'pass_id'=>$pass['id'],'guard_id'=>current_user_id(),'code_entered'=>$codeEntered,'result'=>'denied_used']);
        } elseif ($pass['status'] === 'cancelled' || $pass['status'] === 'expired' || strtotime($pass['expires_at']) <= time()) {
            $result = 'denied_expired';
            if ($pass['status'] === 'active') {
                Database::connect()->prepare("UPDATE passes SET status='expired' WHERE id=?")->execute([$pass['id']]);
            }
            $logModel->record(['estate_id'=>current_estate_id(),'pass_id'=>$pass['id'],'guard_id'=>current_user_id(),'code_entered'=>$codeEntered,'result'=>'denied_expired']);
        } else {
            $result = 'granted';
            $passModel->markUsed($pass['id']);
            $logModel->record(['estate_id'=>current_estate_id(),'pass_id'=>$pass['id'],'guard_id'=>current_user_id(),'code_entered'=>$codeEntered,'result'=>'granted']);
        }
    }
}
?>
<?php ob_start(); ?>

<style>
/* Guard verify — bold full-screen results */
.verify-wrap { max-width: 420px; margin: 0 auto; }

/* RESULT SCREENS — fill the card boldly */
.result-granted {
  background: #052e16;
  border: 2px solid #16a34a;
  border-radius: 20px;
  padding: 36px 24px;
  text-align: center;
  margin-bottom: 20px;
}
.result-denied {
  background: #1c0a0a;
  border: 2px solid #dc2626;
  border-radius: 20px;
  padding: 36px 24px;
  text-align: center;
  margin-bottom: 20px;
}
.result-warn {
  background: #1c1200;
  border: 2px solid #d97706;
  border-radius: 20px;
  padding: 36px 24px;
  text-align: center;
  margin-bottom: 20px;
}

.result-icon  { font-size: 64px; margin-bottom: 10px; line-height: 1; }
.result-title-granted { font-family:'Syne',sans-serif; font-size:30px; font-weight:800; color:#4ade80; margin-bottom:6px; }
.result-title-denied  { font-family:'Syne',sans-serif; font-size:30px; font-weight:800; color:#f87171; margin-bottom:6px; }
.result-title-warn    { font-family:'Syne',sans-serif; font-size:30px; font-weight:800; color:#fbbf24; margin-bottom:6px; }
.result-sub   { font-size:14px; color:rgba(255,255,255,0.55); margin-bottom:18px; }

.result-details {
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 12px;
  padding: 14px 16px;
  text-align: left;
  font-size:14px;
}
.result-details .rd-row { display:flex; justify-content:space-between; margin-bottom:7px; }
.result-details .rd-row:last-child { margin-bottom:0; }
.result-details .rd-label { color:rgba(255,255,255,0.4); }
.result-details .rd-val   { color:#fff; font-weight:500; }
.result-note { font-size:12px; color:rgba(255,255,255,0.35); margin-top:12px; }

/* CODE ENTRY — big for cheap Android */
.verify-card { background:var(--bg2); border:1px solid var(--border); border-radius:16px; padding:22px; margin-bottom:14px; }
.verify-label { font-size:11px; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:0.09em; margin-bottom:14px; }

.code-input-big {
  width: 100%;
  background: #0d1117;
  border: 2px solid rgba(48,220,128,0.25);
  border-radius: 12px;
  color: #4ade80;
  font-family: monospace;
  font-size: 36px;
  font-weight: 700;
  letter-spacing: 0.25em;
  text-align: center;
  padding: 18px;
  outline: none;
  transition: border-color 0.2s;
  margin-bottom: 12px;
}
.code-input-big:focus { border-color: rgba(48,220,128,0.6); }

.verify-btn {
  width: 100%;
  background: #30dc80;
  color: #0d1117;
  border: none;
  border-radius: 12px;
  font-size: 16px;
  font-weight: 700;
  padding: 15px;
  cursor: pointer;
  transition: background 0.18s, transform 0.15s;
}
.verify-btn:hover { background: #22c55e; transform: translateY(-1px); }
.verify-btn:active { transform: translateY(0); }

/* QR Scanner */
.qr-card { background:var(--bg2); border:1px solid var(--border); border-radius:16px; padding:22px; }
.qr-start-btn { display:flex; align-items:center; justify-content:center; gap:8px; padding:12px 22px; border-radius:10px; border:1px solid rgba(255,255,255,0.12); background:transparent; color:var(--text); font-size:14px; cursor:pointer; transition:all 0.18s; }
.qr-start-btn:hover { border-color:rgba(74,222,128,0.4); background:rgba(74,222,128,0.05); color:var(--green-t); }
</style>

<div class="verify-wrap">
  <h1 class="page-title" style="margin-bottom:4px;">Verify pass</h1>
  <p class="page-sub">Enter the 6-digit code or scan the visitor's QR.</p>

  <!-- RESULT: GRANTED -->
  <?php if ($result === 'granted' && $pass): ?>
  <div class="result-granted">
    <div class="result-icon">✅</div>
    <div class="result-title-granted">Access Granted</div>
    <div class="result-sub">Visitor may proceed through the gate</div>
    <div class="result-details">
      <div class="rd-row"><span class="rd-label">Visitor</span><span class="rd-val"><?= e($pass['visitor_name']) ?></span></div>
      <div class="rd-row"><span class="rd-label">Resident</span><span class="rd-val">Unit <?= e($pass['unit']) ?> — <?= e($pass['resident_name']) ?></span></div>
      <div class="rd-row"><span class="rd-label">Code used</span><span class="rd-val" style="font-family:monospace;letter-spacing:0.1em;"><?= format_code($pass['code']) ?></span></div>
    </div>
    <div class="result-note">Pass marked as used — cannot be reused.</div>
  </div>

  <!-- RESULT: INVALID -->
  <?php elseif ($result === 'denied_invalid'): ?>
  <div class="result-denied">
    <div class="result-icon">❌</div>
    <div class="result-title-denied">Access Denied</div>
    <div class="result-sub">This code does not exist in the system.</div>
    <div class="result-details">
      <div class="rd-row"><span class="rd-label">Action</span><span class="rd-val">Ask visitor to check with their host</span></div>
    </div>
  </div>

  <!-- RESULT: EXPIRED -->
  <?php elseif ($result === 'denied_expired'): ?>
  <div class="result-denied">
    <div class="result-icon">⏰</div>
    <div class="result-title-denied">Pass Expired</div>
    <div class="result-sub">This pass has expired or been cancelled.</div>
    <?php if ($pass): ?>
    <div class="result-details">
      <div class="rd-row"><span class="rd-label">Visitor</span><span class="rd-val"><?= e($pass['visitor_name']) ?></span></div>
      <div class="rd-row"><span class="rd-label">Expired at</span><span class="rd-val"><?= friendly_time($pass['expires_at']) ?></span></div>
    </div>
    <?php endif; ?>
  </div>

  <!-- RESULT: ALREADY USED -->
  <?php elseif ($result === 'denied_used'): ?>
  <div class="result-warn">
    <div class="result-icon">🔒</div>
    <div class="result-title-warn">Already Used</div>
    <div class="result-sub">This pass was already used at the gate.</div>
    <?php if ($pass): ?>
    <div class="result-details">
      <div class="rd-row"><span class="rd-label">Visitor</span><span class="rd-val"><?= e($pass['visitor_name']) ?></span></div>
      <div class="rd-row"><span class="rd-label">Resident</span><span class="rd-val">Unit <?= e($pass['unit']) ?></span></div>
    </div>
    <?php endif; ?>
  </div>

  <?php elseif ($result === 'invalid_format'): ?>
  <div class="flash flash-error" style="margin-bottom:16px;">Please enter a valid 6-digit code.</div>
  <?php endif; ?>

  <!-- CODE ENTRY -->
  <div class="verify-card">
    <div class="verify-label">Enter access code</div>
    <form method="POST" action="<?= APP_URL ?>/guard/verify" id="verify-form">
      <input
        type="tel"
        name="code"
        id="code-input"
        class="code-input-big"
        placeholder="· · · · · ·"
        maxlength="7"
        inputmode="numeric"
        autocomplete="off"
        autofocus
      />
      <button type="submit" class="verify-btn">Verify →</button>
    </form>
  </div>

  <!-- QR SCANNER -->
  <div class="qr-card">
    <div class="verify-label" style="margin-bottom:12px;">Or scan QR code</div>
    <div id="qr-reader" style="width:100%;border-radius:10px;overflow:hidden;background:var(--bg3);min-height:160px;display:flex;align-items:center;justify-content:center;">
      <div id="qr-placeholder" style="text-align:center;padding:24px;">
        <div style="font-size:28px;margin-bottom:10px;opacity:0.4;">📷</div>
        <button onclick="startScanner()" class="qr-start-btn">Start camera scan</button>
      </div>
    </div>
    <div id="qr-status" style="font-size:12px;color:var(--muted);text-align:center;margin-top:8px;display:none;">Scanning — point at QR code</div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
const input = document.getElementById('code-input');
const form  = document.getElementById('verify-form');

input.addEventListener('input', () => {
  let val = input.value.replace(/\D/g, '');
  if (val.length > 6) val = val.slice(0, 6);
  input.value = val.length > 3 ? val.slice(0,3) + '·' + val.slice(3) : val;
});
form.addEventListener('submit', () => { input.value = input.value.replace(/\D/g, ''); });

let scanner = null;
function startScanner() {
  document.getElementById('qr-placeholder').innerHTML = '<div style="color:var(--muted);font-size:13px;padding:16px;">Starting camera...</div>';
  document.getElementById('qr-status').style.display = 'block';
  scanner = new Html5Qrcode('qr-reader');
  scanner.start(
    { facingMode: 'environment' },
    { fps: 10, qrbox: { width: 200, height: 200 } },
    (decoded) => {
      let code = decoded;
      const match = decoded.match(/code=(\d{6})/);
      if (match) code = match[1];
      scanner.stop().then(() => { input.value = code; form.submit(); });
    },
    () => {}
  ).catch(() => {
    document.getElementById('qr-placeholder').innerHTML = '<div style="color:var(--danger);font-size:13px;padding:16px;">Camera denied. Use code entry above.</div>';
  });
}
</script>

<?php
$content   = ob_get_clean();
$pageTitle = 'Verify Pass';
require_once __DIR__ . '/../../views/layouts/base.php';
?>