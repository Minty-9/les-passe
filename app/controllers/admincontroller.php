<?php
class AdminController {

    public function index() {
        require_once 'views/admin/dashboard.php';
    }

    public function residents() {
        require_once 'views/admin/residents.php';
    }

    public function logs() {
        require_once 'views/admin/logs.php';
    }

    public function suspend() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(APP_URL . '/admin/residents');
        }
        $userId    = (int) ($_POST['user_id'] ?? 0);
        $newStatus = $_POST['new_status'] ?? 'active';
        $newStatus = in_array($newStatus, ['active','suspended']) ? $newStatus : 'active';

        $userModel = new User();
        $updated   = $userModel->updateStatus($userId, $newStatus);

        if ($updated) {
            set_flash('success', $newStatus === 'active' ? 'Resident reactivated.' : 'Resident suspended.');
        } else {
            set_flash('error', 'Could not update resident status.');
        }
        redirect(APP_URL . '/admin/residents');
    }

    public function addResident() {
        // Handled inline in views/admin/residents.php via POST action=add
        redirect(APP_URL . '/admin/residents');
    }
}