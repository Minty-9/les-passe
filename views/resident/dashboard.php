<?php
// Auto-expire any passes whose time is up
expire_old_passes();

$passModel = new Pass();
$passes    = $passModel->allForResident(current_user_id());

// Split into active and history
$active  = array_filter($passes, fn($p) => $p['status'] === 'active' && strtotime($p['expires_at']) > time());
$history = array_filter($passes, fn($p) => !in_array($p, $active));

// Stats
$totalPasses    = count($passes);
$activePasses   = count($active);
$usedPasses     = count(array_filter($passes, fn($p) => $p['status'] === 'used'));
?>
<?php ob_start(); ?>

<div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:28px;">
  <div>
    <h1 class="page-title">Welcome, <?= e(explode(' ', current_user_name())[0]) ?> 👋</h1>
    <p class="page-sub">Unit <?= e($_SESSION['unit'] ?? '—') ?> &nbsp;·&nbsp; Greenfield Estate</p>
  </div>
  <a href="<?= APP_URL ?>/resident/generate" class="btn btn-green">
    + Generate visitor pass
  </a>
</div>

<!-- STATS -->
<div class="stat-grid">
  <div class="stat-card">
    <div class="stat-num" style="color:var(--greent);"><?= $activePasses ?></div>
    <div class="stat-label">Active passes</div>
  </div>
  <div class="stat-card">
    <div class="stat-num"><?= $totalPasses ?></div>
    <div class="stat-label">Total generated</div>
  </div>
  <div class="stat-card">
    <div class="stat-num" style="color:#60a5fa;"><?= $usedPasses ?></div>
    <div class="stat-label">Passes used</div>
  </div>
</div>

<!-- ACTIVE PASSES -->
<?php if (!empty($active)): ?>
<div class="card" style="margin-bottom:20px;">
  <div style="font-size:13px;font-weight:500;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:16px;">Active passes</div>
  <?php foreach ($active as $pass): ?>
  <div style="background:var(--bg3);border:1px solid var(--border<?= pass_is_expiring($pass) ? '-h' : '' ?>);border-radius:var(--r);padding:16px 20px;margin-bottom:10px;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:12px;">
    <div>
      <div style="font-size:16px;font-weight:500;margin-bottom:4px;"><?= e($pass['visitor_name']) ?></div>
      <div style="font-family:monospace;font-size:20px;letter-spacing:0.15em;color:var(--greent);margin-bottom:6px;">
        <?= format_code($pass['code']) ?>
      </div>
      <div style="font-size:12px;color:var(--muted);">
        <?= duration_label($pass['duration_hrs']) ?> pass
        &nbsp;·&nbsp;
        <?php if (pass_is_expiring($pass)): ?>
          <span style="color:var(--warn);">Expires in <?= time_remaining($pass['expires_at']) ?></span>
        <?php else: ?>
          Expires in <?= time_remaining($pass['expires_at']) ?>
        <?php endif; ?>
      </div>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
      <?= pass_status_badge($pass) ?>
      <a href="<?= APP_URL ?>/resident/pass/<?= $pass['id'] ?>" class="btn btn-outline btn-sm">View pass</a>
      <form method="POST" action="<?= APP_URL ?>/resident/cancel" style="display:inline;" onsubmit="return confirm('Cancel this pass for <?= e($pass['visitor_name']) ?>?')">
        <input type="hidden" name="pass_id" value="<?= $pass['id'] ?>" />
        <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
      </form>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<?php else: ?>
<div class="card" style="margin-bottom:20px;">
  <div class="empty">
    <div class="empty-icon">🔑</div>
    No active passes right now.<br>
    <a href="<?= APP_URL ?>/resident/generate" style="color:var(--greent);">Generate one for your next visitor →</a>
  </div>
</div>
<?php endif; ?>

<!-- HISTORY -->
<?php if (!empty($history)): ?>
<div class="card">
  <div style="font-size:13px;font-weight:500;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:16px;">Pass history</div>
  <div style="overflow-x:auto;">
    <table class="tbl">
      <thead>
        <tr>
          <th>Visitor</th>
          <th>Code</th>
          <th>Duration</th>
          <th>Issued</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($history as $pass): ?>
        <tr>
          <td><?= e($pass['visitor_name']) ?></td>
          <td><span style="font-family:monospace;letter-spacing:0.1em;color:var(--muted);"><?= format_code($pass['code']) ?></span></td>
          <td><?= duration_label($pass['duration_hrs']) ?></td>
          <td class="hide-mobile"><?= friendly_time($pass['created_at']) ?></td>
          <td><?= pass_status_badge($pass) ?></td>
          <td><a href="<?= APP_URL ?>/resident/pass/<?= $pass['id'] ?>" class="btn btn-outline btn-sm">View</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>

<?php
$content = ob_get_clean();
$pageTitle = 'Dashboard';
require_once 'views/layouts/base.php';
?>