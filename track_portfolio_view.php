<?php
/**
 * AJAX endpoint для отслеживания просмотров портфолио
 */

// Устанавливаем заголовок для JSON ответа
header('Content-Type: application/json');

// Проверяем, что это POST запрос
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

// Получаем ID проекта из POST данных
$portfolio_id = $_POST['portfolio_id'] ?? null;

if (!$portfolio_id || !is_numeric($portfolio_id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid portfolio ID']);
    exit;
}

try {
    // Подключаем необходимые файлы
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/database.php';
    require_once __DIR__ . '/functions/views_counter.php';
    
    // Отслеживаем просмотр
    $result = track_portfolio_view((int)$portfolio_id);
    
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'View tracked successfully']);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Portfolio not found']);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Internal server error']);
    error_log("Portfolio view tracking error: " . $e->getMessage());
}
?>
