<?php
/**
 * Немецкая версия страницы услуг
 * Baumaster Frontend - Services Page (German)
 */

// Подключение компонентов
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../ux/layout.php';
require_once __DIR__ . '/../ux/components.php';
require_once __DIR__ . '/../ux/data.php';
require_once __DIR__ . '/../integrations/translation/TranslationManager.php';

// Установка языка
define('CURRENT_LANG', 'de');

// Получение данных
$seo = get_page_seo_settings('services');
$services = get_services_data();
$translation_manager = new TranslationManager();

// Начало контента
ob_start();
?>

<!-- Hero Section -->
<section class="pt-16 bg-gradient-to-br from-gray-50 to-gray-100 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="font-montserrat font-semibold text-4xl lg:text-5xl text-text-primary mb-6">
                <?php echo htmlspecialchars($seo['h1'] ?? 'Unsere Dienstleistungen'); ?>
            </h1>
            <p class="text-xl text-text-secondary max-w-3xl mx-auto mb-8">
                Professionelle Innenausbau- und Renovierungsdienstleistungen in Frankfurt am Main. 
                Von Malerarbeiten bis zur kompletten Renovierung.
            </p>
            <?php render_frontend_button([
                'text' => 'Kostenlose Beratung',
                'variant' => 'primary',
                'size' => 'lg',
                'href' => 'contact.php'
            ]); ?>
        </div>
    </div>
</section>

<!-- Services Grid -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($services as $service): ?>
                <?php render_service_card($service); ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Service Process -->
<section class="py-20 bg-premium-gray">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="font-montserrat font-semibold text-3xl lg:text-4xl text-text-primary mb-4">
                Wie wir arbeiten
            </h2>
            <p class="text-xl text-text-secondary max-w-3xl mx-auto">
                Einfacher und verständlicher Prozess von der Anfrage bis zur Objektübergabe
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-accent-blue text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">1</div>
                <h3 class="font-semibold text-xl text-text-primary mb-3">Anfrage</h3>
                <p class="text-text-secondary">Hinterlassen Sie eine Anfrage auf der Website oder rufen Sie uns an. Wir antworten innerhalb von 15 Minuten.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-accent-blue text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">2</div>
                <h3 class="font-semibold text-xl text-text-primary mb-3">Aufmaß</h3>
                <p class="text-text-secondary">Wir kommen zum Objekt, nehmen Maß und erstellen eine detaillierte Kostenvoranschlag. Kostenlos.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-accent-blue text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">3</div>
                <h3 class="font-semibold text-xl text-text-primary mb-3">Vertrag</h3>
                <p class="text-text-secondary">Wir schließen einen Vertrag mit festen Preisen und Ausführungsfristen ab.</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-accent-blue text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl font-bold">4</div>
                <h3 class="font-semibold text-xl text-text-primary mb-3">Arbeiten</h3>
                <p class="text-text-secondary">Wir führen die Arbeiten termingerecht aus, räumen auf und übergeben das Objekt schlüsselfertig.</p>
            </div>
        </div>
    </div>
</section>

<!-- Pricing -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="font-montserrat font-semibold text-3xl lg:text-4xl text-text-primary mb-4">
                Transparente Preise
            </h2>
            <p class="text-xl text-text-secondary max-w-3xl mx-auto">
                Alle Preise sind pro Quadratmeter Arbeit angegeben. Der Endpreis wird nach dem Aufmaß berechnet.
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white border-2 border-gray-200 rounded-lg p-8 text-center hover:border-accent-blue transition-colors">
                <h3 class="font-semibold text-2xl text-text-primary mb-4">Malerarbeiten</h3>
                <div class="text-4xl font-bold text-accent-blue mb-2">ab 25€</div>
                <div class="text-text-secondary mb-6">pro m²</div>
                <ul class="text-left space-y-2 text-text-secondary mb-8">
                    <li>• Oberflächenvorbereitung</li>
                    <li>• Grundierung</li>
                    <li>• Anstrich in 2 Schichten</li>
                    <li>• Materialien inklusive</li>
                </ul>
                <?php render_frontend_button([
                    'text' => 'Bestellen',
                    'variant' => 'outline',
                    'class' => 'w-full'
                ]); ?>
            </div>
            
            <div class="bg-white border-2 border-accent-blue rounded-lg p-8 text-center relative">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-accent-blue text-white px-4 py-2 rounded-full text-sm">Beliebt</span>
                </div>
                <h3 class="font-semibold text-2xl text-text-primary mb-4">Bodenverlegung</h3>
                <div class="text-4xl font-bold text-accent-blue mb-2">ab 35€</div>
                <div class="text-text-secondary mb-6">pro m²</div>
                <ul class="text-left space-y-2 text-text-secondary mb-8">
                    <li>• Demontage alter Beläge</li>
                    <li>• Untergrundausgleich</li>
                    <li>• Belagsverlegung</li>
                    <li>• Sockelleisten als Geschenk</li>
                </ul>
                <?php render_frontend_button([
                    'text' => 'Bestellen',
                    'variant' => 'primary',
                    'class' => 'w-full'
                ]); ?>
            </div>
            
            <div class="bg-white border-2 border-gray-200 rounded-lg p-8 text-center hover:border-accent-blue transition-colors">
                <h3 class="font-semibold text-2xl text-text-primary mb-4">Badezimmerrenovierung</h3>
                <div class="text-4xl font-bold text-accent-blue mb-2">ab 150€</div>
                <div class="text-text-secondary mb-6">pro m²</div>
                <ul class="text-left space-y-2 text-text-secondary mb-8">
                    <li>• Demontage und Vorbereitung</li>
                    <li>• Abdichtung</li>
                    <li>• Fliesenverlegung</li>
                    <li>• Sanitärinstallation</li>
                </ul>
                <?php render_frontend_button([
                    'text' => 'Bestellen',
                    'variant' => 'outline',
                    'class' => 'w-full'
                ]); ?>
            </div>
        </div>
        
        <div class="text-center mt-12">
            <p class="text-text-secondary mb-6">Benötigen Sie eine individuelle Kostenvoranschlag? Hinterlassen Sie eine Anfrage und erhalten Sie eine kostenlose Berechnung!</p>
            <?php render_frontend_button([
                'text' => 'Kostenvoranschlag erhalten',
                'variant' => 'primary',
                'size' => 'lg',
                'href' => 'contact.php'
            ]); ?>
        </div>
    </div>
</section>


<?php
$content = ob_get_clean();

// Рендеринг страницы
render_frontend_layout([
    'title' => $seo['title'] ?? 'Unsere Dienstleistungen - Baumaster Frankfurt',
    'meta_description' => $seo['description'] ?? 'Professionelle Innenausbau- und Renovierungsdienstleistungen in Frankfurt. Malerarbeiten, Bodenverlegung, Badezimmerrenovierung und mehr.',
    'active_page' => 'services',
    'content' => $content,
    'language' => 'de'
]);
?>
