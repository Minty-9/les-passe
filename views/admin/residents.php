<?php
$userModel = new User();
$estateId  = current_estate_id();
$residents = $userModel->allResidents($estateId);
$guards    = $userModel->allByRole($estateId, 'guard');
$error     = null;

// Handle add user (resident or guard)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $name  = trim($_POST['name']  ?? '');
    $email = trim($_POST['email'] ?? '');
    $unit  = trim($_POST['unit']  ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $role  = trim($_POST['role']  ?? 'resident');
    $role  = in_array($role, ['resident', 'guard']) ? $role : 'resident';

    if (!$name || !$email || ($role === 'resident' && !$unit)) {
        $error = $role === 'resident'
            ? 'Please fill in name, email and unit.'
            : 'Please fill in name and email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email.';
    } elseif ($userModel->findByEmail($email)) {
        $error = 'A user with this email already exists.';
    } else {
        $tempPassword = strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        $created = $userModel->create([
            'estate_id' => $estateId,
            'name'      => $name,
            'email'     => $email,
            'phone'     => $phone ?: null,
            'password'  => password_hash($tempPassword, PASSWORD_BCRYPT),
            'role'      => $role,
            'unit'      => $role === 'resident' ? $unit : null,
        ]);
        if ($created) {
            $label = $role === 'guard' ? 'Guard' : 'Resident';
            set_flash('success', "{$label} added. Temporary password: {$tempPassword} — share this with them securely.");
            redirect(APP_URL . '/admin/residents');
        } else {
            $error = 'Something went wrong. Please try again.';
        }
    }
}
?>
<?php ob_start(); ?>

<div style="display:flex;align-items:flex-start;justify-content:space-between;flex-wrap:wrap;gap:12px;margin-bottom:8px;">
  <div>
    <a href="<?= APP_URL ?>/admin" class="btn btn-outline btn-sm" style="margin-bottom:14px;">← Back to dashboard</a>
    <h1 class="page-title">Manage residents & guards</h1>
    <p class="page-sub"><?= count($residents) ?> residents &nbsp;·&nbsp; <?= count($guards) ?> guards</p>
  </div>
  <button onclick="document.getElementById('add-form').style.display='block';this.style.display='none';" id="add-btn" class="btn btn-green">
    + Add user
  </button>
</div>

<?php if (!empty($error)): ?>
<div class="flash flash-error"><?= e($error) ?></div>
<?php endif; ?>

<!-- ADD USER FORM (hidden by default) -->
<div id="add-form" class="card" style="display:none;margin-bottom:20px;">
  <div style="font-size:13px;font-weight:500;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:16px;">Add new user</div>
  <form method="POST" action="<?= APP_URL ?>/admin/residents">
    <input type="hidden" name="action" value="add" />

    <div class="form-group">
      <label>Account type</label>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:4px;">
        <label style="cursor:pointer;">
          <input type="radio" name="role" value="resident" checked style="display:none;" class="role-radio" />
          <div class="role-option" data-role="resident" style="background:var(--bg3);border:1px solid var(--green);border-radius:var(--r);padding:12px;text-align:center;transition:all 0.2s;">
            <div style="font-weight:500;color:var(--greent);">Resident</div>
            <div style="font-size:11px;color:var(--muted);margin-top:2px;">Generates visitor passes</div>
          </div>
        </label>
        <label style="cursor:pointer;">
          <input type="radio" name="role" value="guard" style="display:none;" class="role-radio" />
          <div class="role-option" data-role="guard" style="background:var(--bg3);border:1px solid rgba(255,255,255,0.09);border-radius:var(--r);padding:12px;text-align:center;transition:all 0.2s;">
            <div style="font-weight:500;">Guard</div>
            <div style="font-size:11px;color:var(--muted);margin-top:2px;">Verifies passes at gate</div>
          </div>
        </label>
      </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
      <div class="form-group">
        <label>Full name</label>
        <input type="text" name="name" class="form-input" placeholder="e.g. Chioma Eze" required />
      </div>
      <div class="form-group" id="unit-field">
        <label>Unit / House no.</label>
        <input type="text" name="unit" class="form-input" placeholder="e.g. D7" />
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" class="form-input" placeholder="user@email.com" required />
      </div>
      <div class="form-group">
        <label>Phone <span style="color:var(--muted);font-size:11px;">(optional)</span></label>
        <input type="tel" name="phone" class="form-input" placeholder="080XXXXXXXX" />
      </div>
    </div>
    <div style="display:flex;gap:10px;margin-top:8px;">
      <button type="submit" class="btn btn-green">Add user</button>
      <button type="button" onclick="document.getElementById('add-form').style.display='none';document.getElementById('add-btn').style.display='inline-flex';" class="btn btn-outline">Cancel</button>
    </div>
  </form>
</div>

<!-- RESIDENTS TABLE -->
<div class="card" style="margin-bottom:16px;">
  <div style="font-size:13px;font-weight:500;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:16px;">Residents</div>
  <?php if (empty($residents)): ?>
  <div class="empty"><div class="empty-icon">👥</div>No residents added yet.</div>
  <?php else: ?>
  <div style="overflow-x:auto;">
    <table class="tbl">
      <thead>
        <tr><th>Name</th><th>Unit</th><th class="hide-mobile">Email</th><th class="hide-mobile">Phone</th><th>Status</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($residents as $r): ?>
        <tr>
          <td><?= e($r['name']) ?></td>
          <td><?= e($r['unit'] ?? '—') ?></td>
          <td class="hide-mobile" style="color:var(--muted);"><?= e($r['email']) ?></td>
          <td class="hide-mobile" style="color:var(--muted);"><?= e($r['phone'] ?? '—') ?></td>
          <td><?= $r['status'] === 'active' ? '<span class="badge badge-active">Active</span>' : '<span class="badge badge-cancelled">Suspended</span>' ?></td>
          <td>
            <form method="POST" action="<?= APP_URL ?>/admin/suspend" style="display:inline;" onsubmit="return confirm('<?= $r['status'] === 'active' ? 'Suspend' : 'Reactivate' ?> <?= e($r['name']) ?>?')">
              <input type="hidden" name="user_id" value="<?= $r['id'] ?>" />
              <input type="hidden" name="new_status" value="<?= $r['status'] === 'active' ? 'suspended' : 'active' ?>" />
              <button type="submit" class="btn btn-sm <?= $r['status'] === 'active' ? 'btn-danger' : 'btn-outline' ?>"><?= $r['status'] === 'active' ? 'Suspend' : 'Reactivate' ?></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<!-- GUARDS TABLE -->
<div class="card">
  <div style="font-size:13px;font-weight:500;color:var(--muted);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:16px;">Guards</div>
  <?php if (empty($guards)): ?>
  <div class="empty"><div class="empty-icon">🛡️</div>No guards added yet.</div>
  <?php else: ?>
  <div style="overflow-x:auto;">
    <table class="tbl">
      <thead>
        <tr><th>Name</th><th class="hide-mobile">Email</th><th class="hide-mobile">Phone</th><th>Status</th><th></th></tr>
      </thead>
      <tbody>
        <?php foreach ($guards as $g): ?>
        <tr>
          <td><?= e($g['name']) ?></td>
          <td class="hide-mobile" style="color:var(--muted);"><?= e($g['email']) ?></td>
          <td class="hide-mobile" style="color:var(--muted);"><?= e($g['phone'] ?? '—') ?></td>
          <td><?= $g['status'] === 'active' ? '<span class="badge badge-active">Active</span>' : '<span class="badge badge-cancelled">Suspended</span>' ?></td>
          <td>
            <form method="POST" action="<?= APP_URL ?>/admin/suspend" style="display:inline;" onsubmit="return confirm('<?= $g['status'] === 'active' ? 'Suspend' : 'Reactivate' ?> <?= e($g['name']) ?>?')">
              <input type="hidden" name="user_id" value="<?= $g['id'] ?>" />
              <input type="hidden" name="new_status" value="<?= $g['status'] === 'active' ? 'suspended' : 'active' ?>" />
              <button type="submit" class="btn btn-sm <?= $g['status'] === 'active' ? 'btn-danger' : 'btn-outline' ?>"><?= $g['status'] === 'active' ? 'Suspend' : 'Reactivate' ?></button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <?php endif; ?>
</div>

<script>
  document.querySelectorAll('.role-radio').forEach(radio => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('.role-option').forEach(opt => {
        opt.style.borderColor = 'rgba(255,255,255,0.09)';
        opt.querySelector('div').style.color = 'var(--text)';
      });
      const sel = radio.nextElementSibling;
      sel.style.borderColor = 'var(--green)';
      sel.querySelector('div').style.color = 'var(--greent)';

      // Hide unit field for guards
      document.getElementById('unit-field').style.display = radio.value === 'guard' ? 'none' : 'block';
      document.querySelector('[name="unit"]').required = radio.value !== 'guard';
    });
  });
</script>

<?php
$content   = ob_get_clean();
$pageTitle = 'Manage Users';
require_once 'views/layouts/base.php';
?>