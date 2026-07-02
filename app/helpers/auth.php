<?php
// ============================================
//  Les Passe — Auth Helpers
// ============================================

// Check if anyone is logged in
function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

// Get current user's role
function current_role(): string {
    return $_SESSION['role'] ?? '';
}

// Get current user's ID
function current_user_id(): int {
    return (int) ($_SESSION['user_id'] ?? 0);
}

// Get current user's estate ID
function current_estate_id(): int {
    return (int) ($_SESSION['estate_id'] ?? 0);
}

// Get current user's name
function current_user_name(): string {
    return $_SESSION['name'] ?? '';
}

// Protect a route — kick out wrong roles
function require_role(string $role): void {
    if (!is_logged_in()) {
        header('Location: ' . APP_URL . '/auth/login');
        exit;
    }
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
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['estate_id'] = $user['estate_id'];
    $_SESSION['name']      = $user['name'];
    $_SESSION['role']      = $user['role'];
    $_SESSION['unit']      = $user['unit'] ?? null;
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