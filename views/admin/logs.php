<?php
$logModel = new EntryLog();
$estateId = current_estate_id();
$logs     = $logModel->allForEstate($estateId, 200);

$granted = count(array_filter($logs, fn($l) => $l['result'] === 'granted'));
$denied  = count($logs) - $granted;
?>
<?php ob_start(); ?>

<a href="<?= APP_URL ?>/admin" class="btn btn-outline btn-sm" style="margin-bottom:14px;">← Back to dashboard</a>
<h1 class="page-title">Entry logs</h1>
<p class="page-sub">Full gate verification history — every attempt, granted or denied.</p>

<div class="stat-grid">
  <div class="stat-card">
    <div class="stat-num"><?= count($logs) ?></div>
    <div class="stat-label">Total attempts</div>
  </div>
  <div class="stat-card">
    <div class="stat-num" style="color:#4ade80;"><?= $granted ?></div>
    <div class="stat-label">Granted</div>
  </div>
  <div class="stat-card">
    <div class="stat-num" style="color:#f85149;"><?= $denied ?></div>
    <div class="stat-label">Denied</div>
  </div>
</div>

<div class="card">
  <?php if (empty($logs)): ?>
  <div class="empty">
    <div class="empty-icon">🚪</div>
    No gate activity recorded yet.
  </div>
  <?php else: ?>
  <div style="overflow-x:auto;">
    <table class="tbl">
      <thead>
        <tr>
          <th>Time</th>
          <th>Visitor</th>
          <th>Code entered</th>
          <th class="hide-mobile">Guard</th>
          <th>Result</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($logs as $log): ?>
        <tr>
          <td style="color:var(--muted);white-space:nowrap;"><?= friendly_time($log['logged_at']) ?></td>
          <td><?= $log['visitor_name'] ? e($log['visitor_name']) : '<span style="color:var(--muted);">—</span>' ?></td>
          <td><span style="font-family:monospace;letter-spacing:0.08em;"><?= format_code($log['code_entered']) ?></span></td>
          <td class="hide-mobile" style="color:var(--muted);"><?= $log['guard_name'] ? e($log['guard_name']) : '—' ?></td>
          <td>
            <?php
              $labels = [
                'granted'        => ['Granted', 'badge-granted'],
                'denied_invalid' => ['Invalid code', 'badge-denied'],
                'denied_expired' => ['Expired', 'badge-denied'],
                'denied_used'    => ['Already used', 'badge-denied'],
              ];
              [$label, $cls] = $labels[$log['result']] ?? ['Denied', 'badge-denied'];
            ?>
            <span class="badge <?= $cls ?>"><?= $label ?></span>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<?php
$content   = ob_get_clean();
$pageTitle = 'Entry Logs';
require_once 'views/layouts/base.php';
?>