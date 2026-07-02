<?php
// Handle POST — create the pass
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $visitorName  = trim($_POST['visitor_name']  ?? '');
    $visitorPhone = trim($_POST['visitor_phone'] ?? '');
    $duration     = (int) ($_POST['duration_hrs'] ?? 3);
    $error        = null;

    if (!$visitorName) {
        $error = 'Please enter your visitor\'s name.';
    } elseif (!in_array($duration, PASS_DURATIONS)) {
        $error = 'Please select a valid pass duration.';
    } else {
        $passModel = new Pass();
        $code      = generate_pass_code();
        $passId    = $passModel->create([
            'estate_id'     => current_estate_id(),
            'resident_id'   => current_user_id(),
            'visitor_name'  => $visitorName,
            'visitor_phone' => $visitorPhone ?: null,
            'code'          => $code,
            'duration_hrs'  => $duration,
            'expires_at'    => expiry_from_hours($duration),
        ]);

        if ($passId) {
            // Redirect to the pass card so they can share it
            redirect(APP_URL . '/resident/pass/' . $passId);
        } else {
            $error = 'Something went wrong. Please try again.';
        }
    }
}
?>
<?php ob_start(); ?>

<div style="max-width:520px;">
  <a href="<?= APP_URL ?>/resident" class="btn btn-outline btn-sm" style="margin-bottom:24px;">← Back to dashboard</a>

  <h1 class="page-title">Generate visitor pass</h1>
  <p class="page-sub">Fill in your visitor's details and choose how long the pass should be valid.</p>

  <?php if (!empty($error)): ?>
  <div class="flash flash-error"><?= e($error) ?></div>
  <?php endif; ?>

  <div class="card">
    <form method="POST" action="<?= APP_URL ?>/resident/generate">

      <div class="form-group">
        <label for="visitor_name">Visitor's full name <span style="color:var(--greent);">*</span></label>
        <input type="text" id="visitor_name" name="visitor_name" class="form-input"
               placeholder="e.g. Adeola Martins"
               value="<?= e($_POST['visitor_name'] ?? '') ?>"
               required autofocus />
      </div>

      <div class="form-group">
        <label for="visitor_phone">Visitor's phone number <span style="color:var(--muted);font-size:11px;">(optional)</span></label>
        <input type="tel" id="visitor_phone" name="visitor_phone" class="form-input"
               placeholder="e.g. 08012345678"
               value="<?= e($_POST['visitor_phone'] ?? '') ?>" />
      </div>

      <div class="form-group">
        <label>Pass duration <span style="color:var(--greent);">*</span></label>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-top:4px;">
          <?php foreach (PASS_DURATIONS as $hrs): ?>
          <label style="cursor:pointer;">
            <input type="radio" name="duration_hrs" value="<?= $hrs ?>"
                   <?= (($_POST['duration_hrs'] ?? 3) == $hrs) ? 'checked' : '' ?>
                   style="display:none;" class="dur-radio" />
            <div class="dur-option" data-hrs="<?= $hrs ?>" style="
              background:var(--bg3);
              border:1px solid <?= (($_POST['duration_hrs'] ?? 3) == $hrs) ? 'var(--green)' : 'rgba(255,255,255,0.09)' ?>;
              border-radius:var(--r);
              padding:14px 10px;
              text-align:center;
              transition:border-color 0.2s,background 0.2s;
            ">
              <div style="font-family:'Syne',sans-serif;font-size:22px;font-weight:700;color:<?= (($_POST['duration_hrs'] ?? 3) == $hrs) ? 'var(--greent)' : 'var(--text)' ?>;margin-bottom:3px;"><?= $hrs ?>h</div>
              <div style="font-size:12px;color:var(--muted);"><?= duration_label($hrs) ?></div>
            </div>
          </label>
          <?php endforeach; ?>
        </div>
      </div>

      <hr style="border:none;border-top:1px solid var(--border);margin:20px 0;" />

      <!-- What happens next info box -->
      <div style="background:var(--bg3);border:1px solid var(--border);border-left:3px solid var(--green);border-radius:0 var(--r) var(--r) 0;padding:14px 16px;margin-bottom:20px;font-size:13px;color:var(--muted);line-height:1.7;">
        <strong style="color:var(--text);">What happens next:</strong><br>
        A 6-digit access code and QR code will be generated. Share it with your visitor via WhatsApp — they show it to security at the gate.
      </div>

      <button type="submit" class="btn btn-green" style="width:100%;justify-content:center;font-size:15px;padding:13px;">
        Generate pass →
      </button>

    </form>
  </div>
</div>

<script>
  // Duration selector highlight
  document.querySelectorAll('.dur-radio').forEach(radio => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('.dur-option').forEach(opt => {
        opt.style.borderColor = 'rgba(255,255,255,0.09)';
        opt.style.background  = 'var(--bg3)';
        opt.querySelector('div').style.color = 'var(--text)';
      });
      const selected = radio.nextElementSibling;
      selected.style.borderColor = 'var(--green)';
      selected.style.background  = 'rgba(48,220,128,0.05)';
      selected.querySelector('div').style.color = 'var(--greent)';
    });
  });
</script>

<?php
$content   = ob_get_clean();
$pageTitle = 'Generate Pass';
require_once 'views/layouts/base.php';
?>