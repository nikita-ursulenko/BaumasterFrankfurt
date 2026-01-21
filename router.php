<?php
/**
 * Local Router for Baumaster Project
 * Mimics .htaccess rewrite rules for php -S built-in server
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = __DIR__ . $uri;

// 1. Serve static files directly
if (file_exists($path) && !is_dir($path)) {
    return false; // Let PHP serve the file
}

// 2. Trailing slash handling (redirect to non-slash if not a dir, or vice versa depending on pref)
// For now, we just ignore it for matching

// 3. Clean URL mapping: /page -> /page.php
$clean_path = __DIR__ . rtrim($uri, '/') . '.php';
if (file_exists($clean_path)) {
    require $clean_path;
    return;
}

// 4. Directory handling: request to /admin -> /admin/index.php
if (is_dir($path)) {
    if (file_exists($path . '/index.php')) {
        require $path . '/index.php';
        return;
    }
}

// 5. Fallback / 404
// For this project, if no match, we typically show 404 or index
// Let's default to index.php if it's the root, otherwise 404 handling logic or index
// If the request doesn't match a file or a mapped php file, serve index.php (common fallback)
require __DIR__ . '/index.php';
