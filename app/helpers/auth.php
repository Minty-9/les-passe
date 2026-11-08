<?php
// ============================================
//  Les Passe — Auth Helpers
// ============================================

function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

function current_role(): string {
    return $_SESSION['role'] ?? '';
}

function current_user_id(): int {
    return (int) ($_SESSION['user_id'] ?? 0);
}

function current_estate_id(): int {
    return (int) ($_SESSION['estate_id'] ?? 0);
}

function current_estate_name(): string {
    return $_SESSION['estate_name'] ?? '';
}

function current_user_name(): string {
    return $_SESSION['name'] ?? '';
}

// Re-check the logged-in user against the database on every protected request.
// Suspended users, suspended estates and deleted accounts are kicked out immediately,
// and role / estate / name changes take effect without waiting for a new login.
function refresh_session_user(): void {
    $stmt = Database::connect()->prepare(
        'SELECT u.estate_id, u.name, u.role, u.unit, u.status AS user_status,
                e.name AS estate_name, e.status AS estate_status
         FROM users u
         JOIN estates e ON e.id = u.estate_id
         WHERE u.id = ? LIMIT 1'
    );
    $stmt->execute([current_user_id()]);
    $row = $stmt->fetch();

    if (!$row || $row['user_status'] !== 'active' || $row['estate_status'] !== 'active') {
        logout_user();
        header('Location: ' . APP_URL . '/auth/login');
        exit;
    }

    $_SESSION['estate_id']   = (int) $row['estate_id'];
    $_SESSION['estate_name'] = $row['estate_name'];
    $_SESSION['name']        = $row['name'];
    $_SESSION['role']        = $row['role'];
    $_SESSION['unit']        = $row['unit'];
}

// Protect a route — kick out wrong roles
function require_role(string $role): void {
    if (!is_logged_in()) {
        header('Location: ' . APP_URL . '/auth/login');
        exit;
    }
    refresh_session_user();
    if (current_role() !== $role) {
        redirect_by_role();
    }
}

// Send user to their correct dashboard
function redirect_by_role(): void {
    $role = current_role();
    $map  = [
        'admin'    => APP_URL . '/admin',
        'resident' => APP_URL . '/resident',
        'guard'    => APP_URL . '/guard',
    ];
    header('Location: ' . ($map[$role] ?? APP_URL));
    exit;
}

// Set session after login
function login_user(array $user): void {
    session_regenerate_id(true);
    $_SESSION['user_id']     = $user['id'];
    $_SESSION['estate_id']   = $user['estate_id'];
    $_SESSION['estate_name'] = $user['estate_name'] ?? '';
    $_SESSION['name']        = $user['name'];
    $_SESSION['role']        = $user['role'];
    $_SESSION['unit']        = $user['unit'] ?? null;
}

// Destroy session on logout
function logout_user(): void {
    $_SESSION = [];
    session_destroy();
}

// Flash messages — set once, read once
function set_flash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}
