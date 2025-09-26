<?php
/**
 * Главная страница сайта
 * Baumaster Frontend - Home Page
 */

// Подключение компонентов
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/ux/layout.php';
require_once __DIR__ . '/ux/components.php';
require_once __DIR__ . '/ux/data.php';

// Установка языка
define('CURRENT_LANG', 'ru');

// Получение данных
$seo = get_seo_data()['home'];
$services = get_services_data();
$portfolio = array_slice(get_portfolio_data(), 0, 3); // Показываем только первые 3
$reviews = array_slice(get_reviews_data(), 0, 4); // Показываем только первые 4
$statistics = get_statistics();

// Начало контента
ob_start();
?>

<!-- Hero Section -->
<section id="hero" class="pt-16 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="font-montserrat font-semibold text-4xl lg:text-6xl text-text-primary mb-6 leading-tight">
                Innenausbau & Renovierung<br>
                <span class="text-accent-blue">in Frankfurt am Main</span>
            </h1>
            <p class="text-xl lg:text-2xl text-text-secondary mb-8 leading-relaxed max-w-4xl mx-auto">
                Полный спектр внутренних работ — от малярки до укладки полов. 
                Премиальное качество и надёжность для вашего дома.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php render_frontend_button([
                    'text' => 'Бесплатный расчёт',
                    'variant' => 'primary',
                    'size' => 'lg',
                    'href' => 'contact.php'
                ]); ?>
                <?php render_frontend_button([
                    'text' => 'Наши услуги',
                    'variant' => 'outline',
                    'size' => 'lg',
                    'onclick' => "document.getElementById('services').scrollIntoView({behavior: 'smooth'})"
                ]); ?>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="font-montserrat font-semibold text-3xl lg:text-4xl text-text-primary mb-4">
                Наши услуги
            </h2>
            <p class="text-xl text-text-secondary max-w-3xl mx-auto">
                Выполняем все виды внутренних работ с гарантией качества и в договорные сроки
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach (array_slice($services, 0, 6) as $service): ?>
                <?php render_service_card($service); ?>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12">
            <?php render_frontend_button([
                'text' => 'Все услуги',
                'variant' => 'outline',
                'size' => 'lg',
                'href' => 'services.php'
            ]); ?>
        </div>
    </div>
</section>

<!-- Portfolio Section -->
<section id="portfolio" class="py-20 bg-premium-gray">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="font-montserrat font-semibold text-3xl lg:text-4xl text-text-primary mb-4">
                Наши работы
            </h2>
            <p class="text-xl text-text-secondary max-w-3xl mx-auto">
                Посмотрите примеры наших проектов — от небольших ремонтов до комплексной реконструкции
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($portfolio as $project): ?>
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                    <div class="relative h-48 bg-gray-200">
                        <img src="<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" 
                             class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <span class="inline-block px-3 py-1 bg-accent-blue text-white text-sm rounded-full mb-3">
                            <?php echo htmlspecialchars($project['category']); ?>
                        </span>
                        <h3 class="font-semibold text-xl text-text-primary mb-2">
                            <?php echo htmlspecialchars($project['title']); ?>
                        </h3>
                        <p class="text-text-secondary mb-4">
                            <?php echo htmlspecialchars($project['description']); ?>
                        </p>
                        <div class="flex justify-between items-center text-sm text-text-secondary">
                            <span><?php echo htmlspecialchars($project['area']); ?></span>
                            <span><?php echo htmlspecialchars($project['duration']); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12">
            <?php render_frontend_button([
                'text' => 'Смотреть все проекты',
                'variant' => 'primary',
                'size' => 'lg',
                'href' => 'portfolio.php'
            ]); ?>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <h2 class="font-montserrat font-semibold text-3xl lg:text-4xl text-text-primary mb-6">
                    О компании Frankfurt Innenausbau
                </h2>
                <p class="text-lg text-text-secondary mb-6 leading-relaxed">
                    Мы команда опытных мастеров, работающих во Франкфурте более 10 лет. 
                    Специализируемся на внутренних работах и знаем все тонкости качественного ремонта.
                </p>
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <?php if (!empty($statistics)): ?>
                        <?php foreach (array_slice($statistics, 0, 4) as $stat): ?>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-accent-blue mb-2"><?php echo htmlspecialchars($stat['number']); ?></div>
                                <div class="text-text-secondary"><?php echo htmlspecialchars($stat['label']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-accent-blue mb-2">500+</div>
                            <div class="text-text-secondary">Довольных клиентов</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-accent-blue mb-2">10+</div>
                            <div class="text-text-secondary">Лет опыта</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-accent-blue mb-2">100%</div>
                            <div class="text-text-secondary">Качество работ</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-accent-blue mb-2">24/7</div>
                            <div class="text-text-secondary">Поддержка клиентов</div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php render_frontend_button([
                    'text' => 'Подробнее о нас',
                    'variant' => 'outline',
                    'size' => 'lg',
                    'href' => 'about.php'
                ]); ?>
            </div>
            <div class="relative">
                <div class="bg-gradient-to-br from-accent-blue to-gray-700 rounded-lg p-8 text-white">
                    <h3 class="font-semibold text-2xl mb-4">Почему выбирают нас?</h3>
                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Гарантия качества на все работы
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Соблюдение договорных сроков
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Качественные материалы
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Профессиональная команда
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section id="reviews" class="py-20 bg-premium-gray">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="font-montserrat font-semibold text-3xl lg:text-4xl text-text-primary mb-4">
                Отзывы наших клиентов
            </h2>
            <p class="text-xl text-text-secondary max-w-3xl mx-auto">
                Читайте, что говорят о нашей работе те, кто уже доверил нам свой ремонт
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($reviews as $review): ?>
                <?php render_review_card($review); ?>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12">
            <?php render_frontend_button([
                'text' => 'Все отзывы',
                'variant' => 'outline',
                'size' => 'lg',
                'href' => 'review.php'
            ]); ?>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean();

// Рендеринг страницы
render_frontend_layout([
    'title' => $seo['title'],
    'meta_description' => $seo['description'],
    'active_page' => 'home',
    'content' => $content,
    'language' => 'ru'
]);
?>

