<?php
// PHP built-in server router for Railway deployment
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve static files directly if they exist
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Route everything through index.php
$_GET['url'] = ltrim($uri, '/');
require_once __DIR__ . '/index.php';
