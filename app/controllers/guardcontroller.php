
<?php
class GuardController {

    public function index() {
        // Guard's "dashboard" IS the verify screen — that's their whole job
        require_once 'views/guard/verify.php';
    }

    public function verify() {
        require_once 'views/guard/verify.php';
    }
}