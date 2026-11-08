<?php
class AdminController {
    public function index() {
        require_once __DIR__ . '/../../views/admin/dashboard.php';
    }
    public function residents() {
        require_once __DIR__ . '/../../views/admin/residents.php';
    }
    public function logs() {
        require_once __DIR__ . '/../../views/admin/logs.php';
    }
    public function suspend() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(APP_URL . '/admin/residents');
        }
        $userId    = (int) ($_POST['user_id'] ?? 0);
        $newStatus = $_POST['new_status'] ?? 'active';
        $newStatus = in_array($newStatus, ['active', 'suspended'], true) ? $newStatus : 'active';

        $userModel = new User();
        // Scoped to this admin's own estate
        $updated   = $userModel->updateStatus($userId, $newStatus, current_estate_id());

        if ($updated) {
            set_flash('success', $newStatus === 'active' ? 'Account reactivated.' : 'Account suspended.');
        } else {
            set_flash('error', 'Could not update that account.');
        }
        redirect(APP_URL . '/admin/residents');
    }
    public function addResident() {
        redirect(APP_URL . '/admin/residents');
    }
}
