<?php
/**
 * Database Upload Script - Restores local database to Railway
 */

$base64_data = file_get_contents(__DIR__ . '/db_data.txt');

$db_path = '/data/baumaster.db';

// Ensure /data directory exists
if (!is_dir('/data')) {
    mkdir('/data', 0755, true);
    echo "Created /data directory\n";
}

// Decode and save
echo "Decoding database...\n";
$binary_data = base64_decode($base64_data);

if ($binary_data === false) {
    die("Error: Failed to decode base64 data\n");
}

echo "Writing to {$db_path}...\n";
file_put_contents($db_path, $binary_data);

echo "Database uploaded successfully!\n";
echo "File size: " . filesize($db_path) . " bytes\n";
echo "Database is ready to use.\n";
