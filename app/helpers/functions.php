<?php
// ============================================
//  Les Passe — General Helpers
// ============================================

// Generate a unique 6-digit code for a pass
// Keeps regenerating if code already exists in DB
function generate_pass_code(): string {
    $db = Database::connect();
    do {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $stmt = $db->prepare('SELECT id FROM passes WHERE code = ?');
        $stmt->execute([$code]);
    } while ($stmt->fetch());
    return $code;
}

// Format code for display — 482716 → 482·716
function format_code(string $code): string {
    return substr($code, 0, 3) . '·' . substr($code, 3);
}

// Calculate expiry datetime from duration in hours
function expiry_from_hours(int $hours): string {
    return date('Y-m-d H:i:s', strtotime("+{$hours} hours"));
}

// Human-readable countdown — returns "2h 14m" or "8m 43s"
function time_remaining(string $expires_at): string {
    $diff = strtotime($expires_at) - time();
    if ($diff <= 0) return 'Expired';
    $h = floor($diff / 3600);
    $m = floor(($diff % 3600) / 60);
    $s = $diff % 60;
    if ($h > 0)  return "{$h}h {$m}m";
    if ($m > 0)  return "{$m}m {$s}s";
    return "{$s}s";
}

// Check if a pass is still valid right now
function pass_is_valid(array $pass): bool {
    return $pass['status'] === 'active'
        && strtotime($pass['expires_at']) > time();
}

// Is pass expiring within the warning window?
function pass_is_expiring(array $pass): bool {
    $diff = strtotime($pass['expires_at']) - time();
    return $diff > 0 && $diff <= (PASS_WARN_MINS * 60);
}

// Auto-expire passes that are past their time
// Call this at the top of dashboards
function expire_old_passes(): void {
    $db = Database::connect();
    $db->prepare(
        "UPDATE passes SET status = 'expired'
         WHERE status = 'active' AND expires_at < NOW()"
    )->execute();
}

// Generate QR code URL using free API — no library needed
// Returns an <img> tag ready to drop in HTML
function qr_code_img(string $code, int $size = 160): string {
    $data = urlencode(APP_URL . '/guard/verify?code=' . $code);
    $src  = "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data={$data}&bgcolor=ffffff&color=000000&margin=6";
    return '<img src="' . $src . '" alt="QR code for pass ' . htmlspecialchars($code) . '" width="' . $size . '" height="' . $size . '" />';
}

// Safe output — always escape before printing user data
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Redirect helper
function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

// Format Nigerian datetime nicely — "Today, 2:15 PM"
function friendly_time(string $datetime): string {
    $ts    = strtotime($datetime);
    $today = strtotime('today');
    $yesterday = strtotime('yesterday');
    if ($ts >= $today)     return 'Today, '     . date('g:i A', $ts);
    if ($ts >= $yesterday) return 'Yesterday, ' . date('g:i A', $ts);
    return date('d M Y, g:i A', $ts);
}

// Duration label — 1 → "1 hour", 3 → "3 hours"
function duration_label(int $hours): string {
    return $hours === 1 ? '1 hour' : "{$hours} hours";
}

// Status badge HTML for pass status
function pass_status_badge(array $pass): string {
    if ($pass['status'] === 'used')      return '<span class="badge badge-used">Used</span>';
    if ($pass['status'] === 'cancelled') return '<span class="badge badge-cancelled">Cancelled</span>';
    if ($pass['status'] === 'expired' || strtotime($pass['expires_at']) <= time())
                                         return '<span class="badge badge-expired">Expired</span>';
    if (pass_is_expiring($pass))         return '<span class="badge badge-warn">Expiring soon</span>';
    return '<span class="badge badge-active">Active</span>';
}