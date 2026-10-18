<?php
session_start();

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/app/helpers/auth.php';
require_once __DIR__ . '/app/helpers/functions.php';

require_once __DIR__ . '/app/controllers/AuthController.php';
require_once __DIR__ . '/app/controllers/ResidentController.php';
require_once __DIR__ . '/app/controllers/GuardController.php';
require_once __DIR__ . '/app/controllers/AdminController.php';
require_once __DIR__ . '/app/models/User.php';
require_once __DIR__ . '/app/models/Pass.php';
require_once __DIR__ . '/app/models/EntryLog.php';

$url        = isset($_GET['url']) ? $_GET['url'] : '';
$url        = rtrim($url, '/');
$url        = filter_var($url, FILTER_SANITIZE_URL);
$segments   = explode('/', $url);
$controller = strtolower($segments[0] ?? '');
$action     = strtolower($segments[1] ?? 'index');

switch ($controller) {

    // Root — show landing page
    case '':
        require_once __DIR__ . '/views/landing.php';
        break;

    // Auth routes
    case 'auth':
        $auth = new AuthController();
        match ($action) {
            'login'    => $auth->login(),
            'register' => $auth->register(),
            'logout'   => $auth->logout(),
            default    => $auth->login()
        };
        break;

    // Resident routes
    case 'resident':
        require_role('resident');
        $res = new ResidentController();
        match ($action) {
            'index'    => $res->index(),
            'generate' => $res->generate(),
            'pass'     => $res->pass($segments[2] ?? null),
            'cancel'   => $res->cancel(),
            default    => $res->index()
        };
        break;

    // Guard routes
    case 'guard':
        require_role('guard');
        $guard = new GuardController();
        match ($action) {
            'index'  => $guard->index(),
            'verify' => $guard->verify(),
            default  => $guard->index()
        };
        break;

    // Admin routes
    case 'admin':
        require_role('admin');
        $admin = new AdminController();
        match ($action) {
            'index'     => $admin->index(),
            'residents' => $admin->residents(),
            'logs'      => $admin->logs(),
            'suspend'   => $admin->suspend(),
            'add'       => $admin->addResident(),
            default     => $admin->index()
        };
        break;

    // 404
    default:
        http_response_code(404);
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"/><meta name="viewport" content="width=device-width,initial-scale=1"/><title>404 — Les Passe</title>
        <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400&display=swap" rel="stylesheet"/>
        <style>*{box-sizing:border-box;margin:0;padding:0}body{background:#0a0e13;color:#e6edf3;font-family:"DM Sans",sans-serif;min-height:100vh;display:flex;align-items:center;justify-content:center;text-align:center;padding:24px}h1{font-family:"Syne",sans-serif;font-size:80px;font-weight:800;color:rgba(48,220,128,0.15);line-height:1}h2{font-family:"Syne",sans-serif;font-size:24px;font-weight:700;margin:8px 0 10px}p{color:#8b949e;font-size:15px;margin-bottom:28px}a{display:inline-block;background:#30dc80;color:#0a0e13;font-weight:600;padding:11px 24px;border-radius:10px;text-decoration:none;transition:background 0.2s}a:hover{background:#22c55e}</style>
        </head><body><div><h1>404</h1><h2>Page not found</h2><p>This page does not exist or has been moved.</p><a href="' . APP_URL . '">← Back to Les Passe</a></div></body></html>';
        break;
}