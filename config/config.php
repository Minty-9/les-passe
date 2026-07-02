<?php
// ============================================
//  Les Passe — App Configuration
// ============================================

// ── Database ──
define('DB_HOST', 'mysql.railway.internal');
define('DB_NAME', 'railway');
define('DB_USER', 'root');
define('DB_PASS', 'jYeFhKEqKHpnhzRnHNnQwzxoOPebgFkk');          // XAMPP default is empty — change if yours differs
define('DB_CHARSET', 'utf8mb4');

// ── App ──
define('APP_NAME', 'Les Passe');
define('APP_URL',  '');
define('APP_ENV',  'production');         // change to 'production' when live

// ── Pass settings ──
define('PASS_DURATIONS', [1, 3, 6]);       // allowed durations in hours
define('PASS_WARN_MINS', 15);              // minutes before expiry to show warning
define('CODE_LENGTH', 6);                  // digits in access code

// ── Error display ──
if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}