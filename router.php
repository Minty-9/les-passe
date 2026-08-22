<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve manifest.json directly
if ($uri === '/manifest.json') {
    header('Content-Type: application/json');
    readfile(__DIR__ . '/manifest.json');
    exit;
}

// Serve static files directly if they exist
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

$_GET['url'] = ltrim($uri, '/');
require_once __DIR__ . '/index.php';