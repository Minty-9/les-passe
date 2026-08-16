<?php
// ============================================
//  Les Passe — App Configuration
//  Reads from environment variables on Railway
//  Falls back to local XAMPP values for dev
// ============================================

// ── Database ──
define('DB_HOST',    $_ENV['MYSQLHOST']          ?? 'localhost');
define('DB_NAME',    $_ENV['MYSQLDATABASE']      ?? 'lespasse_db');
define('DB_USER',    $_ENV['MYSQLUSER']          ?? 'root');
define('DB_PASS',    $_ENV['MYSQLPASSWORD']      ?? '');
define('DB_PORT',    $_ENV['MYSQLPORT']          ?? '3306');
define('DB_CHARSET', 'utf8mb4');

// ── App ──
define('APP_NAME', 'Les Passe');
define('APP_URL',  rtrim($_ENV['APP_URL'] ?? 'http://localhost/lespasse', '/'));
define('APP_ENV',  $_ENV['APP_ENV'] ?? 'development');

// ── Pass settings ──
define('PASS_DURATIONS', [1, 3, 6]);
define('PASS_WARN_MINS', 15);
define('CODE_LENGTH', 6);

// ── Error display ──
if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}