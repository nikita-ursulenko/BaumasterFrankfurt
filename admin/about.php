<?php
/**
 * Управление страницей "О компании"
 * Baumaster Admin - About Page Management
 */

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../database.php';
require_once UI_PATH . 'base.php';
require_once COMPONENTS_PATH . 'admin_layout.php';
require_once __DIR__ . '/../integrations/translation/TranslationManager.php';
require_once __DIR__ . '/../ux/data.php';

// Обработка POST запросов
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_history'])) {
        // Сохранение истории компании
        $history_data = [
            'title' => $_POST['history_title'] ?? '',
            'content' => [
                'paragraph1' => $_POST['history_paragraph1'] ?? '',
                'paragraph2' => $_POST['history_paragraph2'] ?? '',
                'paragraph3' => $_POST['history_paragraph3'] ?? ''
            ],
            'sort_order' => 1
        ];
        
        // Обработка загрузки изображения
        if (isset($_FILES['team_photo']) && $_FILES['team_photo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../assets/uploads/about/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file_extension = pathinfo($_FILES['team_photo']['name'], PATHINFO_EXTENSION);
            $filename = 'team_photo_' . time() . '.' . $file_extension;
            $upload_path = $upload_dir . $filename;
            
            if (move_uploaded_file($_FILES['team_photo']['tmp_name'], $upload_path)) {
                $history_data['image'] = 'assets/uploads/about/' . $filename;
            }
        }
        
        $save_result = save_about_content('history', $history_data, 'ru');
        if ($save_result) {
            // Автоматический перевод для немецкой версии через TranslationManager
            $translation_manager = new TranslationManager();
            
            // Получаем ID сохраненной записи
            $db = get_database();
            $existing = $db->select('about_content', ['section' => 'history'], ['limit' => 1]);
            
            if ($existing && !empty($existing)) {
                $record = is_array($existing) && isset($existing[0]) ? $existing[0] : $existing;
                $record_id = $record['id'] ?? null;
                
                // Подготавливаем поля для перевода
                $fields_to_translate = [
                    'title' => $history_data['title'],
                    'content' => json_encode($history_data['content'])
                ];
                
                // Выполняем автоматический перевод
                $translated_fields = $translation_manager->autoTranslateContent(
                    'about_content', 
                    $record_id, 
                    $fields_to_translate, 
                    'ru', 
                    'de'
                );
                
                if (!empty($translated_fields)) {
                    $success_message = 'История компании успешно сохранена и переведена на немецкий язык';
                } else {
                    $success_message = 'История компании сохранена, но перевод не выполнен';
                }
            } else {
                $success_message = 'История компании сохранена, но перевод не выполнен';
            }
        } else {
            $error_message = 'Ошибка при сохранении истории компании';
        }
    }
}

// Загрузка данных для отображения
$history_data = get_about_content('history');
$team_data = get_about_content('team');
$statistics_data = get_about_content('statistics');

// Начало контента
ob_start();
?>

<div class="space-y-6">
    <!-- Сообщения об успехе/ошибке -->
    <?php if ($success_message): ?>
        <div class="bg-green-50 border border-green-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800"><?php echo htmlspecialchars($success_message); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <div class="bg-red-50 border border-red-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800"><?php echo htmlspecialchars($error_message); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Заголовок страницы -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Управление страницей "О компании"</h1>
                <p class="text-gray-600 mt-1">Редактирование контента страницы о компании</p>
            </div>
            <div class="flex space-x-3">
                <a href="../about.php" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    Просмотр страницы
                </a>
            </div>
        </div>
    </div>

    <!-- Вкладки -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button class="tab-button active py-4 px-1 border-b-2 border-primary-500 font-medium text-sm text-primary-600" data-tab="history">
                    Наша история
                </button>
                <button class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="team">
                    Наша команда
                </button>
                <button class="tab-button py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="statistics">
                    Статистика
                </button>
            </nav>
        </div>

        <!-- Содержимое вкладок -->
        <div class="p-6">
            <!-- Вкладка "Наша история" -->
            <div id="tab-history" class="tab-content">
                <form method="POST" enctype="multipart/form-data">
                    <div class="space-y-6">
                        <div>
                            <label for="history_title" class="block text-sm font-medium text-gray-700 mb-2">
                                Заголовок секции
                            </label>
                            <input type="text" id="history_title" name="history_title" 
                                   value="<?php echo htmlspecialchars($history_data['title'] ?? 'Наша история'); ?>" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                        </div>

                        <div>
                            <label for="history_paragraph1" class="block text-sm font-medium text-gray-700 mb-2">
                                Первый абзац
                            </label>
                            <textarea id="history_paragraph1" name="history_paragraph1" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"><?php echo htmlspecialchars($history_data['content']['paragraph1'] ?? 'Компания Frankfurt Innenausbau была основана в 2014 году группой опытных мастеров, которые решили объединить свои знания и навыки для предоставления качественных услуг в сфере внутренних работ.'); ?></textarea>
                        </div>

                        <div>
                            <label for="history_paragraph2" class="block text-sm font-medium text-gray-700 mb-2">
                                Второй абзац
                            </label>
                            <textarea id="history_paragraph2" name="history_paragraph2" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"><?php echo htmlspecialchars($history_data['content']['paragraph2'] ?? 'За 10 лет работы мы выполнили более 500 проектов различной сложности — от небольших косметических ремонтов до полной реконструкции квартир и офисов. Наш опыт охватывает все виды внутренних работ.'); ?></textarea>
                        </div>

                        <div>
                            <label for="history_paragraph3" class="block text-sm font-medium text-gray-700 mb-2">
                                Третий абзац
                            </label>
                            <textarea id="history_paragraph3" name="history_paragraph3" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"><?php echo htmlspecialchars($history_data['content']['paragraph3'] ?? 'Сегодня мы продолжаем развиваться, внедряя новые технологии и материалы, но неизменным остается наш принцип — качество превыше всего.'); ?></textarea>
                        </div>

                        <div>
                            <label for="team_photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Фото команды
                            </label>
                            <div class="flex items-center space-x-4">
                                <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                    <?php if (!empty($history_data['image'])): ?>
                                        <img src="../<?php echo htmlspecialchars($history_data['image']); ?>" 
                                             alt="Фото команды" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <span class="text-gray-500 text-sm">Фото команды</span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <input type="file" id="team_photo" name="team_photo" accept="image/*"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF до 10MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" name="save_history" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Сохранить изменения
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Вкладка "Наша команда" -->
            <div id="tab-team" class="tab-content hidden">
                <div class="space-y-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Сотрудники компании</h3>
                        <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Добавить сотрудника
                        </button>
                    </div>

                    <!-- Список сотрудников -->
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        <!-- Сотрудник 1 -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                                    <span class="text-xl font-bold text-gray-500">AM</span>
                                </div>
                                <h4 class="font-semibold text-lg text-gray-900">Александр Мюллер</h4>
                                <p class="text-primary-600 font-medium mb-2">Руководитель проектов</p>
                                <p class="text-sm text-gray-600 mb-4">15 лет опыта в строительстве. Специализация: планирование и контроль качества работ.</p>
                                <div class="flex space-x-2">
                                    <button class="flex-1 px-3 py-1 text-xs font-medium text-primary-600 bg-primary-50 rounded hover:bg-primary-100">
                                        Редактировать
                                    </button>
                                    <button class="px-3 py-1 text-xs font-medium text-red-600 bg-red-50 rounded hover:bg-red-100">
                                        Удалить
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Сотрудник 2 -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                                    <span class="text-xl font-bold text-gray-500">MS</span>
                                </div>
                                <h4 class="font-semibold text-lg text-gray-900">Михаэль Шмидт</h4>
                                <p class="text-primary-600 font-medium mb-2">Мастер-универсал</p>
                                <p class="text-sm text-gray-600 mb-4">12 лет в профессии. Выполняет все виды отделочных работ на высшем уровне.</p>
                                <div class="flex space-x-2">
                                    <button class="flex-1 px-3 py-1 text-xs font-medium text-primary-600 bg-primary-50 rounded hover:bg-primary-100">
                                        Редактировать
                                    </button>
                                    <button class="px-3 py-1 text-xs font-medium text-red-600 bg-red-50 rounded hover:bg-red-100">
                                        Удалить
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Сотрудник 3 -->
                        <div class="bg-gray-50 rounded-lg p-6">
                            <div class="text-center">
                                <div class="w-20 h-20 bg-gray-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                                    <span class="text-xl font-bold text-gray-500">TW</span>
                                </div>
                                <h4 class="font-semibold text-lg text-gray-900">Томас Вагнер</h4>
                                <p class="text-primary-600 font-medium mb-2">Специалист по полам</p>
                                <p class="text-sm text-gray-600 mb-4">10 лет опыта в укладке всех типов напольных покрытий. Гарантия идеального результата.</p>
                                <div class="flex space-x-2">
                                    <button class="flex-1 px-3 py-1 text-xs font-medium text-primary-600 bg-primary-50 rounded hover:bg-primary-100">
                                        Редактировать
                                    </button>
                                    <button class="px-3 py-1 text-xs font-medium text-red-600 bg-red-50 rounded hover:bg-red-100">
                                        Удалить
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Вкладка "Статистика" -->
            <div id="tab-statistics" class="tab-content hidden">
                <form method="POST">
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Статистика компании</h3>
                        
                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- Статистика 1 -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="font-medium text-gray-900 mb-4">Довольные клиенты</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Число</label>
                                        <input type="text" name="stat1_number" value="500+" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Заголовок</label>
                                        <input type="text" name="stat1_title" value="Довольных клиентов" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
                                        <input type="text" name="stat1_description" value="За все время работы" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Статистика 2 -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="font-medium text-gray-900 mb-4">Опыт работы</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Число</label>
                                        <input type="text" name="stat2_number" value="10" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Заголовок</label>
                                        <input type="text" name="stat2_title" value="Лет опыта" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
                                        <input type="text" name="stat2_description" value="На рынке Frankfurt" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Статистика 3 -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="font-medium text-gray-900 mb-4">Проекты в год</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Число</label>
                                        <input type="text" name="stat3_number" value="50+" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Заголовок</label>
                                        <input type="text" name="stat3_title" value="Проектов в год" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
                                        <input type="text" name="stat3_description" value="Различной сложности" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Статистика 4 -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="font-medium text-gray-900 mb-4">Рекомендации</h4>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Число</label>
                                        <input type="text" name="stat4_number" value="98%" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Заголовок</label>
                                        <input type="text" name="stat4_title" value="Довольных клиентов" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Описание</label>
                                        <input type="text" name="stat4_description" value="Рекомендуют нас друзьям" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" name="save_statistics" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                Сохранить статистику
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Переключение вкладок
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');

            // Убираем активный класс у всех кнопок
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'border-primary-500', 'text-primary-600');
                btn.classList.add('border-transparent', 'text-gray-500');
            });

            // Добавляем активный класс к текущей кнопке
            this.classList.add('active', 'border-primary-500', 'text-primary-600');
            this.classList.remove('border-transparent', 'text-gray-500');

            // Скрываем все содержимое вкладок
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Показываем нужное содержимое
            document.getElementById('tab-' + targetTab).classList.remove('hidden');
        });
    });
});
</script>

<?php
$content = ob_get_clean();

// Рендеринг страницы
render_admin_layout([
    'page_title' => 'О компании',
    'page_description' => 'Управление контентом страницы о компании',
    'active_menu' => 'about',
    'content' => $content
]);
?>
