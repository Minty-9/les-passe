<?php
// ============================================
//  Les Passe — App Configuration
// ============================================

// ── Database ──
define('DB_HOST', 'sql111.infinityfree.com');
define('DB_NAME', 'if0_42311686_lespasse_db');
define('DB_USER', 'if0_42311686');
define('DB_PASS', 'Yfc6a8Jigd9aqzJ');          // XAMPP default is empty — change if yours differs
define('DB_CHARSET', 'utf8mb4');

// ── App ──
define('APP_NAME', 'Les Passe');
define('APP_URL',  'https://lespasseng.rf.gd');
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