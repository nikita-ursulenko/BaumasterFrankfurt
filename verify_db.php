<?php
/**
 * Database Verification Script
 * Check database contents on Railway
 */

require_once __DIR__ . '/config.php';

header('Content-Type: text/plain');

echo "=== DATABASE VERIFICATION ===\n\n";

echo "Database path: " . DB_PATH . "\n";
echo "Database exists: " . (file_exists(DB_PATH) ? 'YES' : 'NO') . "\n";

if (file_exists(DB_PATH)) {
    echo "Database size: " . filesize(DB_PATH) . " bytes\n\n";
}

try {
    $db = get_database();

    $tables = ['services', 'portfolio', 'reviews', 'users', 'settings', 'faq'];

    foreach ($tables as $table) {
        try {
            $records = $db->select($table, []);
            echo "Table '{$table}': " . count($records) . " records\n";

            if ($table === 'services' && count($records) > 0) {
                echo "  Services:\n";
                foreach ($records as $service) {
                    echo "  - {$service['title']} (status: {$service['status']})\n";
                }
            }
        } catch (Exception $e) {
            echo "Table '{$table}': ERROR - " . $e->getMessage() . "\n";
        }
    }

} catch (Exception $e) {
    echo "\nERROR: " . $e->getMessage() . "\n";
}

echo "\n=== END ===\n";
