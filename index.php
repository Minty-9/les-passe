<?php
session_start();

require_once 'config/config.php';
require_once 'config/Database.php';
require_once 'app/helpers/auth.php';
require_once 'app/helpers/functions.php';

require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/ResidentController.php';
require_once 'app/controllers/GuardController.php';
require_once 'app/controllers/AdminController.php';
require_once 'app/models/User.php';
require_once 'app/models/Pass.php';
require_once 'app/models/EntryLog.php';

$url        = isset($_GET['url']) ? $_GET['url'] : '';
$url        = rtrim($url, '/');
$url        = filter_var($url, FILTER_SANITIZE_URL);
$segments   = explode('/', $url);
$controller = strtolower($segments[0] ?? '');
$action     = strtolower($segments[1] ?? 'index');

switch ($controller) {

    case '':
        if (is_logged_in()) {
            redirect_by_role();
        } else {
            $auth = new AuthController();
            $auth->login();
        }
        break;

    case 'auth':
        $auth = new AuthController();
        match ($action) {
            'login'    => $auth->login(),
            'register' => $auth->register(),
            'logout'   => $auth->logout(),
            default    => $auth->login()
        };
        break;

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

    case 'guard':
        require_role('guard');
        $guard = new GuardController();
        match ($action) {
            'index'  => $guard->index(),
            'verify' => $guard->verify(),
            default  => $guard->index()
        };
        break;

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

    default:
        http_response_code(404);
        echo '<div style="font-family:sans-serif;text-align:center;padding:60px;background:#0d1117;color:#e6edf3;min-height:100vh;">
                <h2>404 — Page not found</h2>
                <a href="' . APP_URL . '" style="color:#4ade80;">Go home</a>
              </div>';
        break;
}
