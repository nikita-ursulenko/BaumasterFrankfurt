<?php
/**
 * Database Initialization Script
 * Run this to initialize empty database on Railway
 */

// Подключаем конфигурацию
require_once __DIR__ . '/config.php';

echo "Initializing database...\n";

// Создаем подключение к БД (это автоматически создаст таблицы)
$db = get_database();

echo "Database initialized successfully!\n";
echo "Database path: " . DB_PATH . "\n";

// Проверяем созданные таблицы
try {
    $tables = ['users', 'services', 'portfolio', 'reviews', 'settings', 'faq'];
    foreach ($tables as $table) {
        $count = $db->select($table, []);
        echo "Table '{$table}': " . count($count) . " records\n";
    }
} catch (Exception $e) {
    echo "Error checking tables: " . $e->getMessage() . "\n";
}

echo "\nDatabase is ready to use!\n";
