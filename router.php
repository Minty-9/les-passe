<?php
// Serve manifest.json directly
if ($uri === '/manifest.json') {
    header('Content-Type: application/json');
    readfile(__DIR__ . '/manifest.json');
    exit;
}

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

$_GET['url'] = ltrim($uri, '/');

try {
    require_once __DIR__ . '/index.php';
} catch (Throwable $e) {
    http_response_code(500);
    echo '<pre style="background:#1a1a1a;color:#ff6b6b;padding:20px;font-size:13px;">';
    echo '<strong>Error:</strong> ' . $e->getMessage() . "\n";
    echo '<strong>File:</strong> ' . $e->getFile() . "\n";
    echo '<strong>Line:</strong> ' . $e->getLine() . "\n";
    echo '<strong>Trace:</strong>' . "\n" . $e->getTraceAsString();
    echo '</pre>';
}