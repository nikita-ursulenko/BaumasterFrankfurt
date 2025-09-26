<?php
/**
 * Страница блога/FAQ - немецкая версия
 */

// Устанавливаем язык
define('CURRENT_LANG', 'de');

// Подключение компонентов
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../ux/layout.php';
require_once __DIR__ . '/../ux/components.php';
require_once __DIR__ . '/../ux/data.php';

// Мета-данные страницы
$page_title = 'FAQ';
$page_description = 'Häufig gestellte Fragen zu Innenarbeiten und Renovierungen in Frankfurt. Antworten von Experten.';

// Рендеринг страницы
render_frontend_head($page_title, $page_description, 'blog');
render_frontend_navigation('blog');
?>

<main class="pt-16">
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-accent-blue to-blue-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    FAQ - Häufig gestellte Fragen
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto">
                    Antworten auf die häufigsten Fragen zu Innenarbeiten und Renovierungen
                </p>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-8">
                <!-- FAQ Item 1 -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-text-primary mb-4">
                        Wie lange dauert eine typische Renovierung?
                    </h3>
                    <p class="text-text-secondary">
                        Die Dauer hängt von der Größe und Komplexität des Projekts ab. Eine Badezimmerrenovierung dauert 
                        in der Regel 2-3 Wochen, während eine komplette Wohnungsrenovierung 4-8 Wochen in Anspruch nehmen kann. 
                        Wir erstellen für jedes Projekt einen detaillierten Zeitplan.
                    </p>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-text-primary mb-4">
                        Welche Materialien verwenden Sie?
                    </h3>
                    <p class="text-text-secondary">
                        Wir arbeiten ausschließlich mit hochwertigen Materialien von renommierten Herstellern. 
                        Alle Materialien werden nach deutschen Qualitätsstandards ausgewählt und sind umweltfreundlich. 
                        Wir beraten Sie gerne bei der Materialauswahl.
                    </p>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-text-primary mb-4">
                        Bieten Sie eine Garantie auf Ihre Arbeiten?
                    </h3>
                    <p class="text-text-secondary">
                        Ja, wir bieten eine umfassende Garantie auf alle unsere Arbeiten. Die Garantiedauer beträgt 
                        je nach Art der Arbeit 2-5 Jahre. Details zur Garantie besprechen wir gerne persönlich mit Ihnen.
                    </p>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-text-primary mb-4">
                        Wie berechnen Sie Ihre Preise?
                    </h3>
                    <p class="text-text-secondary">
                        Unsere Preise richten sich nach dem tatsächlichen Aufwand, den verwendeten Materialien und 
                        der Komplexität des Projekts. Wir erstellen für jedes Projekt ein detailliertes, 
                        transparentes Angebot ohne versteckte Kosten.
                    </p>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-text-primary mb-4">
                        Arbeiten Sie auch am Wochenende?
                    </h3>
                    <p class="text-text-secondary">
                        Wir arbeiten hauptsächlich von Montag bis Freitag. Wochenendarbeiten sind in Ausnahmefällen 
                        möglich, wenn es dringend ist oder der Kunde es wünscht. Dies wird dann gesondert besprochen 
                        und berechnet.
                    </p>
                </div>

                <!-- FAQ Item 6 -->
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                    <h3 class="text-xl font-semibold text-text-primary mb-4">
                        Was ist im Preis enthalten?
                    </h3>
                    <p class="text-text-secondary">
                        Im Preis enthalten sind: alle Arbeiten, Materialien, Entsorgung von Altmaterial, 
                        Reinigung nach Abschluss der Arbeiten und eine umfassende Garantie. 
                        Nicht enthalten sind: Möbeltransport und -lagerung (falls gewünscht).
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="py-20 bg-premium-gray">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-text-primary mb-6">
                Haben Sie weitere Fragen?
            </h2>
            <p class="text-lg text-text-secondary mb-8 max-w-2xl mx-auto">
                Kontaktieren Sie uns für eine persönliche Beratung. Wir beantworten gerne alle Ihre Fragen.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php render_frontend_button([
                    'text' => 'Kontakt aufnehmen',
                    'href' => 'contact.php',
                    'variant' => 'primary',
                    'size' => 'lg'
                ]); ?>
                <?php render_frontend_button([
                    'text' => 'Anrufen',
                    'href' => 'tel:+496912345678',
                    'variant' => 'outline',
                    'size' => 'lg'
                ]); ?>
            </div>
        </div>
    </section>
</main>

<?php render_frontend_footer(); ?>
