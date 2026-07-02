<?php
class ResidentController {

    public function index() {
        require_once 'views/resident/dashboard.php';
    }

    public function generate() {
        require_once 'views/resident/generate.php';
    }

    public function pass(?string $id) {
        global $segments;
        require_once 'views/resident/pass-card.php';
    }

    public function cancel() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect(APP_URL . '/resident');
        }
        $passId    = (int) ($_POST['pass_id'] ?? 0);
        $passModel = new Pass();
        $cancelled = $passModel->cancel($passId, current_user_id());
        if ($cancelled) {
            set_flash('success', 'Pass cancelled successfully.');
        } else {
            set_flash('error', 'Could not cancel that pass.');
        }
        redirect(APP_URL . '/resident');
    }
}