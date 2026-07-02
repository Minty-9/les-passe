<?php
expire_old_passes();

$passModel = new Pass();
$logModel  = new EntryLog();
$userModel = new User();

$estateId = current_estate_id();

$todayPasses   = $passModel->todayForEstate($estateId);
$recentLogs    = $logModel->allForEstate($estateId, 8);
$todayEntries  = $logModel->todayCount($estateId);
$residents     = $userModel->allResidents($estateId);

$activeToday   = count(array_filter($todayPasses, fn($p) => $p['status'] === 'active' && strtotime($p['expires_at']) > time()));
$totalToday    = count($todayPasses);
$totalResidents= count($residents);
$activeResidents = count(array_filter($residents, fn($r) => $r['status'] === 'active'));
?>
<?php ob_start(); ?>

<div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:28px;">
  <div>
    <h1 class="page-title">Estate overview</h1>
    <p class="page-sub">Greenfield Estate &nbsp;·&nbsp; <?= date('l, j F Y') ?></p>
  </div>
  <div style="display:flex;gap:10px;">
    <a href="<?= APP_URL ?>/admin/residents" class="btn btn-outline">Manage residents</a>
    <a href="<?= APP_URL ?>/admin/logs" class="btn btn-outline">View all logs</a>
  </div>
</div>

<!-- STATS -->
<div class="stat-grid">
  <div class="stat-card">
    <div class="stat-num" style="color:var(--greent);"><?= $todayEntries ?></div>
    <div class="stat-label">Entries today</div>
  </div>
  <div class="stat-card">
    <div class="stat-num"><?= $totalToday ?></div>
    <div class="stat-label">Passes issued today</div>
  </div>
  <div class="stat-card">
    <div class="stat-num" style="color:#60a5fa;"><?= $activeToday ?></div>
    <div class="stat-label">Currently active</div>
  </div>
  <div class="stat-card">
    <div class="stat-num"><?= $activeResidents ?>/<?= $totalResidents ?></div>
    <div class="stat-label">Active residents</div>
  </div>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:16px;">

  <!-- TODAY'S PASSES -->
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
      <div style="font-size:13px;font-weight:500;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;">Today's passes</div>
      <span style="font-size:12px;color:var(--muted);"><?= $totalToday ?> total</span>
    </div>

    <?php if (empty($todayPasses)): ?>
    <div class="empty" style="padding:32px 16px;">
      <div class="empty-icon">📋</div>
      No passes generated today yet.
    </div>
    <?php else: ?>
    <div style="display:flex;flex-direction:column;gap:8px;max-height:380px;overflow-y:auto;">
      <?php foreach ($todayPasses as $pass): ?>
      <div style="background:var(--bg3);border:1px solid var(--border);border-radius:var(--r);padding:12px 14px;display:flex;justify-content:space-between;align-items:center;gap:10px;">
        <div style="min-width:0;">
          <div style="font-size:14px;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= e($pass['visitor_name']) ?></div>
          <div style="font-size:12px;color:var(--muted);">Unit <?= e($pass['unit']) ?> — <?= e($pass['resident_name']) ?></div>
        </div>
        <?= pass_status_badge($pass) ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>

  <!-- RECENT GATE ACTIVITY -->
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
      <div style="font-size:13px;font-weight:500;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;">Recent gate activity</div>
      <a href="<?= APP_URL ?>/admin/logs" style="font-size:12px;">View all →</a>
    </div>

    <?php if (empty($recentLogs)): ?>
    <div class="empty" style="padding:32px 16px;">
      <div class="empty-icon">🚪</div>
      No gate activity recorded yet.
    </div>
    <?php else: ?>
    <div style="display:flex;flex-direction:column;gap:8px;max-height:380px;overflow-y:auto;">
      <?php foreach ($recentLogs as $log): ?>
      <div style="background:var(--bg3);border:1px solid var(--border);border-radius:var(--r);padding:12px 14px;display:flex;justify-content:space-between;align-items:center;gap:10px;">
        <div style="min-width:0;">
          <div style="font-size:14px;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
            <?= $log['visitor_name'] ? e($log['visitor_name']) : 'Unknown code' ?>
          </div>
          <div style="font-size:12px;color:var(--muted);">
            <?= friendly_time($log['logged_at']) ?>
            <?= $log['guard_name'] ? ' · ' . e($log['guard_name']) : '' ?>
          </div>
        </div>
        <?php if ($log['result'] === 'granted'): ?>
          <span class="badge badge-granted">Granted</span>
        <?php else: ?>
          <span class="badge badge-denied">Denied</span>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>

</div>

<?php
$content   = ob_get_clean();
$pageTitle = 'Admin Dashboard';
require_once 'views/layouts/base.php';
?>