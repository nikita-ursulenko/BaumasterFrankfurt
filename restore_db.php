<?php
/**
 * FINAL Database Upload - Loads data directly to volume
 * This script checks if DB is empty and only then uploads data
 */

require_once __DIR__ . '/config.php';

header('Content-Type: text/plain');

echo "=== FINAL DATABASE UPLOAD ===\n\n";

// Check current database
$db = get_database();
$services = $db->select('services', []);

echo "Current services count: " . count($services) . "\n";

if (count($services) > 0) {
    echo "Database already has data. Skipping upload.\n";
    exit;
}

echo "Database is empty. Loading data...\n\n";

// Base64 encoded database
$base64_data = file_get_contents(__DIR__ . '/db_backup.txt');

if (!$base64_data) {
    die("ERROR: Could not read db_backup.txt\n");
}

echo "Decoding database backup...\n";
$binary_data = base64_decode($base64_data);

if ($binary_data === false) {
    die("ERROR: Failed to decode base64 data\n");
}

echo "Backup size: " . strlen($binary_data) . " bytes\n";

// Close current DB connection
unset($db);

// Write to database file
echo "Writing to " . DB_PATH . "...\n";
file_put_contents(DB_PATH, $binary_data);

echo "Database file written: " . filesize(DB_PATH) . " bytes\n\n";

// Verify
$db = get_database();
$services = $db->select('services', []);
$portfolio = $db->select('portfolio', []);
$reviews = $db->select('reviews', []);

echo "=== VERIFICATION ===\n";
echo "Services: " . count($services) . "\n";
echo "Portfolio: " . count($portfolio) . "\n";
echo "Reviews: " . count($reviews) . "\n\n";

if (count($services) > 0) {
    echo "SUCCESS! Database restored.\n";
} else {
    echo "WARNING: Database still empty!\n";
}

echo "\n=== END ===\n";
