<?php
/**
 * Страница контактов - немецкая версия
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
$page_title = 'Kontakt';
$page_description = 'Kontaktieren Sie Frankfurt Innenausbau für eine kostenlose Beratung. Telefon, Email und Adresse in Frankfurt am Main.';

// Рендеринг страницы
render_frontend_head($page_title, $page_description, 'contact');
render_frontend_navigation('contact');
?>

<main class="pt-16">
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-accent-blue to-blue-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Kontaktieren Sie uns
                </h1>
                <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto">
                    Bereit, Ihr Projekt zu besprechen? Hinterlassen Sie eine Anfrage oder rufen Sie uns jetzt an
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Form & Info -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div>
                    <h2 class="text-3xl font-bold text-text-primary mb-6">
                        Anfrage senden
                    </h2>
                    <p class="text-lg text-text-secondary mb-8">
                        Füllen Sie das Formular aus und wir melden uns bei Ihnen
                    </p>
                    
                    <?php render_contact_form([
                        'title' => 'Kontaktformular',
                        'subtitle' => 'Senden Sie uns Ihre Anfrage',
                        'action' => '/contact_form.php'
                    ]); ?>
                </div>
                
                <!-- Contact Info -->
                <div>
                    <h2 class="text-3xl font-bold text-text-primary mb-6">
                        Unsere Kontakte
                    </h2>
                    
                    <div class="space-y-8">
                        <!-- Phone -->
                        <div class="flex items-start space-x-4">
                            <div class="bg-accent-blue text-white p-3 rounded-lg">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-text-primary mb-2">Telefon</h3>
                                <p class="text-lg text-text-secondary">+49 (0) 69 123 456 78</p>
                                <p class="text-sm text-text-secondary">Mo-Fr: 8:00-18:00, Sa: 9:00-15:00</p>
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="flex items-start space-x-4">
                            <div class="bg-accent-blue text-white p-3 rounded-lg">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-text-primary mb-2">Email</h3>
                                <p class="text-lg text-text-secondary">info@baumaster-frankfurt.de</p>
                                <p class="text-sm text-text-secondary">Antwort innerhalb von 24 Stunden</p>
                            </div>
                        </div>
                        
                        <!-- Address -->
                        <div class="flex items-start space-x-4">
                            <div class="bg-accent-blue text-white p-3 rounded-lg">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-text-primary mb-2">Adresse</h3>
                                <p class="text-lg text-text-secondary">Frankfurt am Main, Deutschland</p>
                                <p class="text-sm text-text-secondary">Termine nach Vereinbarung</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick Communication -->
                    <div class="mt-12">
                        <h3 class="text-xl font-semibold text-text-primary mb-4">Schnelle Kommunikation</h3>
                        <div class="flex space-x-4">
                            <?php render_frontend_button([
                                'text' => 'WhatsApp',
                                'href' => 'https://wa.me/496912345678',
                                'variant' => 'outline',
                                'size' => 'md'
                            ]); ?>
                            <?php render_frontend_button([
                                'text' => 'Telegram',
                                'href' => 'https://t.me/baumaster_frankfurt',
                                'variant' => 'outline',
                                'size' => 'md'
                            ]); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-20 bg-premium-gray">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-text-primary mb-4">
                    Unser Standort
                </h2>
                <p class="text-lg text-text-secondary">
                    Frankfurt am Main, Deutschland
                </p>
            </div>
            
            <div class="bg-gray-300 h-96 rounded-lg flex items-center justify-center">
                <p class="text-text-secondary text-lg">Karte wird hier angezeigt</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-accent-blue text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Haben Sie Fragen?
            </h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Wir beraten Sie gerne kostenlos und unverbindlich
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php render_frontend_button([
                    'text' => 'Jetzt anrufen',
                    'href' => 'tel:+496912345678',
                    'variant' => 'secondary',
                    'size' => 'lg'
                ]); ?>
                <?php render_frontend_button([
                    'text' => 'WhatsApp',
                    'href' => 'https://wa.me/496912345678',
                    'variant' => 'outline',
                    'size' => 'lg'
                ]); ?>
            </div>
        </div>
    </section>
</main>

<?php render_frontend_footer(); ?>
