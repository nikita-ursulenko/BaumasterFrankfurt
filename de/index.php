<?php
/**
 * Немецкая версия главной страницы
 * Baumaster Frontend - Home Page (German)
 */

// Подключение компонентов
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../ux/layout.php';
require_once __DIR__ . '/../ux/components.php';
require_once __DIR__ . '/../ux/data.php';

// Установка языка
define('CURRENT_LANG', 'de');

// Получение данных
$seo = get_seo_data()['home'];
$services = get_services_data();
$portfolio = array_slice(get_portfolio_data(), 0, 3); // Показываем только первые 3
$reviews = array_slice(get_reviews_data(), 0, 4); // Показываем только первые 4
$statistics = get_statistics('de');

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
                Vollständige Palette von Innenarbeiten — von Malerarbeiten bis zum Verlegen von Böden. 
                Premium-Qualität und Zuverlässigkeit für Ihr Zuhause.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php render_frontend_button([
                    'text' => 'Kostenlose Berechnung',
                    'variant' => 'primary',
                    'size' => 'lg',
                    'href' => 'contact.php'
                ]); ?>
                <?php render_frontend_button([
                    'text' => 'Unsere Dienstleistungen',
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
                Unsere Dienstleistungen
            </h2>
            <p class="text-xl text-text-secondary max-w-3xl mx-auto">
                Wir führen alle Arten von Innenarbeiten mit Qualitätsgarantie und pünktlich durch
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach (array_slice($services, 0, 6) as $service): ?>
                <?php render_service_card($service); ?>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12">
            <?php render_frontend_button([
                'text' => 'Alle Dienstleistungen',
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
                Unsere Arbeiten
            </h2>
            <p class="text-xl text-text-secondary max-w-3xl mx-auto">
                Sehen Sie sich Beispiele unserer Projekte an — von kleinen Renovierungen bis zur kompletten Rekonstruktion
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
                'text' => 'Alle Projekte ansehen',
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
                    Über das Unternehmen Frankfurt Innenausbau
                </h2>
                <p class="text-lg text-text-secondary mb-6 leading-relaxed">
                    Wir sind ein Team erfahrener Handwerker, die seit über 10 Jahren in Frankfurt arbeiten. 
                    Wir spezialisieren uns auf Innenarbeiten und kennen alle Feinheiten einer qualitativ hochwertigen Renovierung.
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
                            <div class="text-text-secondary">Zufriedene Kunden</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-accent-blue mb-2">10+</div>
                            <div class="text-text-secondary">Jahre Erfahrung</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-accent-blue mb-2">100%</div>
                            <div class="text-text-secondary">Arbeitsqualität</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-accent-blue mb-2">24/7</div>
                            <div class="text-text-secondary">Kundensupport</div>
                        </div>
                    <?php endif; ?>
                </div>
                <?php render_frontend_button([
                    'text' => 'Mehr über uns',
                    'variant' => 'outline',
                    'size' => 'lg',
                    'href' => 'about.php'
                ]); ?>
            </div>
            <div class="relative">
                <div class="bg-gradient-to-br from-accent-blue to-gray-700 rounded-lg p-8 text-white">
                    <h3 class="font-semibold text-2xl mb-4">Warum wählen Sie uns?</h3>
                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Qualitätsgarantie für alle Arbeiten
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Einhaltung der vereinbarten Fristen
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Qualitätsmaterialien
                        </li>
                        <li class="flex items-center">
                            <svg class="h-6 w-6 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Professionelles Team
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
                Bewertungen unserer Kunden
            </h2>
            <p class="text-xl text-text-secondary max-w-3xl mx-auto">
                Lesen Sie, was diejenigen über unsere Arbeit sagen, die uns bereits ihre Renovierung anvertraut haben
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($reviews as $review): ?>
                <?php render_review_card($review); ?>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-12">
            <?php render_frontend_button([
                'text' => 'Alle Bewertungen',
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
    'title' => 'Baumaster Frankfurt - Innenausbau & Renovierung',
    'meta_description' => 'Professionelle Innenausbau- und Renovierungsdienstleistungen in Frankfurt am Main. Malerarbeiten, Bodenverlegung, Badezimmerrenovierung.',
    'active_page' => 'home',
    'content' => $content,
    'language' => 'de'
]);
?>