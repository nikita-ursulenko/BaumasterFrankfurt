<?php
/**
 * Базовый layout для frontend сайта
 * Baumaster Frontend Layout
 */

// Предотвращение прямого доступа
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__DIR__) . '/');
}

// Подключение функций
require_once ABSPATH . 'functions.php';

/**
 * Получение SEO настроек для страницы
 */
function get_page_seo_settings($page_key = '') {
    require_once __DIR__ . '/../config.php';
    require_once __DIR__ . '/../database.php';
    
    try {
        $db = get_database();
        $seo_settings = $db->select('settings', ['category' => 'seo']);
        
        $settings = [];
        foreach ($seo_settings as $setting) {
            $settings[$setting['setting_key']] = $setting['setting_value'];
        }
        
        // Если указана конкретная страница, получаем её настройки
        if ($page_key) {
            $page_settings = [];
            $page_keys = [
                'title', 'h1', 'description', 'keywords', 
                'og_title', 'og_description', 'og_image'
            ];
            
            foreach ($page_keys as $key) {
                $setting_key = 'page_' . $page_key . '_page_' . $key;
                if (isset($settings[$setting_key]) && !empty($settings[$setting_key])) {
                    $page_settings[$key] = $settings[$setting_key];
                }
            }
            
            return array_merge($settings, $page_settings);
        }
        
        return $settings;
    } catch (Exception $e) {
        error_log("Ошибка загрузки SEO настроек: " . $e->getMessage());
        return [];
    }
}

/**
 * Получение H1 заголовка для страницы
 */
function get_page_h1($page_key = '') {
    $seo_settings = get_page_seo_settings($page_key);
    
    if (!empty($seo_settings['h1'])) {
        return $seo_settings['h1'];
    }
    
    // Дефолтные заголовки для страниц
    $default_h1 = [
        'home' => 'Профессиональные внутренние работы во Франкфурте',
        'services' => 'Наши услуги',
        'portfolio' => 'Наши проекты',
        'about' => 'О компании',
        'reviews' => 'Отзывы клиентов',
        'blog' => 'Блог и FAQ',
        'contact' => 'Контакты'
    ];
    
    return $default_h1[$page_key] ?? 'Baumaster Frankfurt';
}

/**
 * Рендеринг HTML head
 */
function render_frontend_head($title = '', $meta_description = '', $active_page = '') {
    // Определяем ключ страницы
    $page_key = '';
    $current_script = basename($_SERVER['PHP_SELF'], '.php');
    
    $page_mapping = [
        'index' => 'home',
        'services' => 'services',
        'portfolio' => 'portfolio',
        'about' => 'about',
        'review' => 'reviews',
        'blog' => 'blog',
        'contact' => 'contact'
    ];
    
    if (isset($page_mapping[$current_script])) {
        $page_key = $page_mapping[$current_script];
    }
    
    // Получаем SEO настройки
    $seo_settings = get_page_seo_settings($page_key);
    
    // Формируем заголовок
    $site_title = '';
    if (!empty($seo_settings['title'])) {
        $site_title = $seo_settings['title'];
    } elseif ($title) {
        $site_title = $title . ' | ' . ($seo_settings['site_title'] ?? 'Innenausbau & Renovierung Frankfurt');
    } else {
        $site_title = $seo_settings['site_title'] ?? 'Innenausbau & Renovierung Frankfurt | Premium Bauunternehmen';
    }
    
    // Формируем описание
    $description = '';
    if (!empty($seo_settings['description'])) {
        $description = $seo_settings['description'];
    } elseif ($meta_description) {
        $description = $meta_description;
    } else {
        $description = $seo_settings['site_description'] ?? 'Премиальные внутренние работы во Франкфурте. Полный спектр услуг от профессионалов.';
    }
    
    // Формируем ключевые слова
    $keywords = '';
    if (!empty($seo_settings['keywords'])) {
        $keywords = $seo_settings['keywords'];
    } else {
        $keywords = $seo_settings['site_keywords'] ?? 'Innenausbau Frankfurt, Renovierung Frankfurt, Malerei Frankfurt, Bodenverlegung Frankfurt, Badezimmer Renovierung Frankfurt';
    }
    
    // Open Graph настройки
    $og_title = $seo_settings['og_title'] ?? $site_title;
    $og_description = $seo_settings['og_description'] ?? $description;
    $og_image = $seo_settings['og_image'] ?? $seo_settings['og_image'] ?? '/assets/images/og-image.jpg';
    
    // Текущий URL
    $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($site_title); ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?php echo htmlspecialchars($description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($keywords); ?>">
    <meta name="author" content="<?php echo htmlspecialchars($seo_settings['site_author'] ?? 'Frankfurt Innenausbau'); ?>">
    <meta name="robots" content="index, follow">
    
    <?php if (!empty($seo_settings['site_copyright'])): ?>
    <meta name="copyright" content="<?php echo htmlspecialchars($seo_settings['site_copyright']); ?>">
    <?php endif; ?>
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo htmlspecialchars($og_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($og_description); ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo htmlspecialchars($current_url); ?>">
    <meta property="og:image" content="<?php echo htmlspecialchars($og_image); ?>">
    <meta property="og:site_name" content="<?php echo htmlspecialchars($seo_settings['site_title'] ?? 'Frankfurt Innenausbau'); ?>">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($og_title); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($og_description); ?>">
    <meta name="twitter:image" content="<?php echo htmlspecialchars($og_image); ?>">
    
    <?php if (!empty($seo_settings['twitter_handle'])): ?>
    <meta name="twitter:site" content="<?php echo htmlspecialchars($seo_settings['twitter_handle']); ?>">
    <?php endif; ?>
    
    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo htmlspecialchars($current_url); ?>">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
    
    <!-- Google Analytics -->
    <?php if (!empty($seo_settings['google_analytics'])): ?>
    <?php echo $seo_settings['google_analytics']; ?>
    <?php endif; ?>
    
    <!-- Google Tag Manager -->
    <?php if (!empty($seo_settings['google_tag_manager'])): ?>
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','<?php echo htmlspecialchars($seo_settings['google_tag_manager']); ?>');</script>
    <?php endif; ?>
    
    <!-- Facebook Pixel -->
    <?php if (!empty($seo_settings['facebook_pixel'])): ?>
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '<?php echo htmlspecialchars($seo_settings['facebook_pixel']); ?>');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=<?php echo htmlspecialchars($seo_settings['facebook_pixel']); ?>&ev=PageView&noscript=1"
    /></noscript>
    <?php endif; ?>
    
    <!-- Custom Head Code -->
    <?php if (!empty($seo_settings['custom_head_code'])): ?>
    <?php echo $seo_settings['custom_head_code']; ?>
    <?php endif; ?>
    
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'premium-gray': '#F4F4F4',
                        'text-primary': '#1C1C1E',
                        'text-secondary': '#4A5568',
                        'accent-blue': '#2C3E50',
                        'steel-gray': '#5A5A5A'
                    },
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'roboto': ['Roboto', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <!-- Tailwind Typography CDN -->
    <script src="https://unpkg.com/@tailwindcss/typography@0.5.10/dist/index.js"></script>
    
    <!-- Custom styles for blog content -->
    <style>
        .prose {
            color: #374151;
            max-width: none;
        }
        .prose h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #1f2937;
        }
        .prose h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            color: #374151;
        }
        .prose p {
            margin-bottom: 1rem;
            line-height: 1.7;
        }
        .prose ul {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }
        .prose li {
            margin-bottom: 0.5rem;
            list-style-type: disc;
        }
        .prose strong {
            font-weight: 600;
        }
        .prose em {
            font-style: italic;
        }
    </style>
    <?php
}

/**
 * Рендеринг основного layout
 */
function render_frontend_layout($options = []) {
    $defaults = [
        'title' => '',
        'meta_description' => '',
        'active_page' => '',
        'content' => '',
        'body_class' => 'bg-premium-gray font-roboto text-text-primary',
        'show_navigation' => true,
        'show_footer' => true
    ];
    
    $opts = array_merge($defaults, $options);
    ?>
    <!DOCTYPE html>
    <html lang="de">
    <head>
        <?php render_frontend_head($opts['title'], $opts['meta_description'], $opts['active_page']); ?>
    </head>
    <body class="<?php echo $opts['body_class']; ?>">
        
        <?php if ($opts['show_navigation']): ?>
            <?php render_frontend_navigation($opts['active_page']); ?>
        <?php endif; ?>
        
        <!-- Main Content -->
        <?php echo $opts['content']; ?>
        
        <?php if ($opts['show_footer']): ?>
            <?php render_frontend_footer(); ?>
        <?php endif; ?>
        
        <!-- JavaScript -->
        <?php render_frontend_scripts(); ?>
        
    </body>
    </html>
    <?php
}

/**
 * Рендеринг навигации
 */
function render_frontend_navigation($active_page = '') {
    // Определяем язык для навигации
    $is_german = defined('CURRENT_LANG') && CURRENT_LANG === 'de';
    
    // Получаем контактные данные
    require_once __DIR__ . '/data.php';
    $contact_info = get_contact_info();
    
    $menu_items = [
        'home' => ['url' => 'index.php', 'title' => $is_german ? 'Startseite' : 'Главная', 'anchor' => '#hero'],
        'services' => ['url' => 'services.php', 'title' => $is_german ? 'Dienstleistungen' : 'Услуги', 'anchor' => '#services'],
        'portfolio' => ['url' => 'portfolio.php', 'title' => $is_german ? 'Portfolio' : 'Портфолио', 'anchor' => '#portfolio'],
        'about' => ['url' => 'about.php', 'title' => $is_german ? 'Über uns' : 'О компании', 'anchor' => '#about'],
        'reviews' => ['url' => 'review.php', 'title' => $is_german ? 'Bewertungen' : 'Отзывы', 'anchor' => '#reviews'],
        'blog' => ['url' => 'blog.php', 'title' => $is_german ? 'FAQ' : 'FAQ', 'anchor' => '#faq'],
        'contact' => ['url' => 'contact.php', 'title' => $is_german ? 'Kontakt' : 'Контакты', 'anchor' => '#contact']
    ];
    ?>
    <!-- Navigation -->
    <nav class="bg-white shadow-sm fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="font-montserrat font-semibold text-xl text-text-primary">
                    Frankfurt Innenausbau
                </div>
                
                <!-- Desktop Navigation -->
                <div class="hidden lg:flex space-x-8">
                    <?php foreach ($menu_items as $page => $item): ?>
                        <?php $is_active = $active_page === $page; ?>
                        <a href="<?php echo $item['url']; ?>" class="<?php echo $is_active ? 'text-accent-blue font-medium' : 'text-text-secondary hover:text-accent-blue'; ?> transition-colors">
                            <?php echo htmlspecialchars($item['title']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- Language Switcher -->
                <div class="hidden lg:flex items-center space-x-2 mr-4">
                    <a href="<?php echo get_language_switch_url('ru'); ?>" class="px-3 py-1 text-sm rounded <?php echo !defined('CURRENT_LANG') || CURRENT_LANG !== 'de' ? 'bg-accent-blue text-white' : 'text-text-secondary hover:text-accent-blue'; ?> transition-colors">
                        RU
                    </a>
                    <a href="<?php echo get_language_switch_url('de'); ?>" class="px-3 py-1 text-sm rounded <?php echo defined('CURRENT_LANG') && CURRENT_LANG === 'de' ? 'bg-accent-blue text-white' : 'text-text-secondary hover:text-accent-blue'; ?> transition-colors">
                        DE
                    </a>
                </div>

                <!-- Desktop Call Button -->
                <a href="tel:<?php echo str_replace([' ', '(', ')', '-'], '', $contact_info['phone']); ?>" 
                   class="hidden lg:block bg-accent-blue text-white px-4 py-2 rounded hover:bg-opacity-90 transition-colors text-center">
                    <?php echo defined('CURRENT_LANG') && CURRENT_LANG === 'de' ? 'Anrufen' : 'Позвонить'; ?>
                </a>

                <!-- Mobile Language Switcher -->
                <div class="lg:hidden flex items-center space-x-2 mr-2">
                    <a href="<?php echo get_language_switch_url('ru'); ?>" class="px-2 py-1 text-xs rounded <?php echo !defined('CURRENT_LANG') || CURRENT_LANG !== 'de' ? 'bg-accent-blue text-white' : 'text-text-secondary'; ?> transition-colors">
                        RU
                    </a>
                    <a href="<?php echo get_language_switch_url('de'); ?>" class="px-2 py-1 text-xs rounded <?php echo defined('CURRENT_LANG') && CURRENT_LANG === 'de' ? 'bg-accent-blue text-white' : 'text-text-secondary'; ?> transition-colors">
                        DE
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="lg:hidden p-2 rounded-md text-text-secondary hover:text-accent-blue focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="lg:hidden hidden bg-white border-t border-gray-200 shadow-lg">
            <div class="px-4 py-2 space-y-1">
                <?php foreach ($menu_items as $page => $item): ?>
                    <a href="<?php echo $item['url']; ?>" class="block px-3 py-2 text-text-secondary hover:text-accent-blue hover:bg-gray-50 rounded-md transition-colors mobile-menu-link">
                        <?php echo htmlspecialchars($item['title']); ?>
                    </a>
                <?php endforeach; ?>
                <div class="pt-2 pb-1">
                    <a href="tel:<?php echo str_replace([' ', '(', ')', '-'], '', $contact_info['phone']); ?>" 
                       class="block w-full bg-accent-blue text-white px-4 py-2 rounded hover:bg-opacity-90 transition-colors text-center">
                        <?php echo defined('CURRENT_LANG') && CURRENT_LANG === 'de' ? 'Anrufen' : 'Позвонить'; ?>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <?php
}

/**
 * Рендеринг footer
 */
function render_frontend_footer() {
    // Определяем язык для футера
    $is_german = defined('CURRENT_LANG') && CURRENT_LANG === 'de';
    
    // Получаем контактные данные
    require_once __DIR__ . '/data.php';
    $contact_info = get_contact_info();
    ?>
    <!-- Footer -->
    <footer class="bg-text-primary text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="md:col-span-2">
                    <div class="font-montserrat font-semibold text-2xl mb-4">
                        Frankfurt Innenausbau
                    </div>
                      <p class="text-gray-300 mb-6 leading-relaxed">
                         <?php echo $is_german ? 'Professionelle Innenarbeiten in Frankfurt. Wir verwandeln Ihre Ideen mit Premium-Qualität und Aufmerksamkeit für Details in die Realität.' : 'Профессиональные внутренние работы во Франкфурте. Превращаем ваши идеи в реальность с премиальным качеством и вниманием к деталям.'; ?>
                      </p>
                    <div class="flex space-x-4">
                        <?php if (!empty($contact_info['social']['facebook'])): ?>
                        <a href="<?php echo htmlspecialchars($contact_info['social']['facebook']); ?>" target="_blank" class="bg-accent-blue text-white p-3 rounded-full hover:bg-opacity-80 transition-colors">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($contact_info['social']['instagram'])): ?>
                        <a href="<?php echo htmlspecialchars($contact_info['social']['instagram']); ?>" target="_blank" class="bg-accent-blue text-white p-3 rounded-full hover:bg-opacity-80 transition-colors">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987s11.987-5.367 11.987-11.987C24.014 5.367 18.647.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.418-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.928.875 1.418 2.026 1.418 3.323s-.49 2.448-1.418 3.244c-.875.807-2.026 1.297-3.323 1.297zm7.83-9.281c-.49 0-.928-.175-1.297-.49-.368-.315-.49-.753-.49-1.243 0-.49.122-.928.49-1.243.369-.315.807-.49 1.297-.49s.928.175 1.297.49c.368.315.49.753.49 1.243 0 .49-.122.928-.49 1.243-.369.315-.807.49-1.297.49z"/>
                            </svg>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($contact_info['social']['linkedin'])): ?>
                        <a href="<?php echo htmlspecialchars($contact_info['social']['linkedin']); ?>" target="_blank" class="bg-accent-blue text-white p-3 rounded-full hover:bg-opacity-80 transition-colors">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($contact_info['social']['whatsapp'])): ?>
                        <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $contact_info['social']['whatsapp']); ?>" target="_blank" class="bg-accent-blue text-white p-3 rounded-full hover:bg-opacity-80 transition-colors">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.688z"/>
                            </svg>
                        </a>
                        <?php endif; ?>
                        
                        <?php if (!empty($contact_info['social']['telegram'])): ?>
                        <a href="https://t.me/<?php echo ltrim($contact_info['social']['telegram'], '@'); ?>" target="_blank" class="bg-accent-blue text-white p-3 rounded-full hover:bg-opacity-80 transition-colors">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                            </svg>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Services -->
                <div>
                    <h3 class="font-semibold text-lg mb-4"><?php echo $is_german ? 'Dienstleistungen' : 'Услуги'; ?></h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="services.php" class="hover:text-white transition-colors"><?php echo $is_german ? 'Malerarbeiten' : 'Малярные работы'; ?></a></li>
                        <li><a href="services.php" class="hover:text-white transition-colors"><?php echo $is_german ? 'Bodenverlegung' : 'Укладка полов'; ?></a></li>
                        <li><a href="services.php" class="hover:text-white transition-colors"><?php echo $is_german ? 'Badezimmerrenovierung' : 'Ремонт ванных'; ?></a></li>
                        <li><a href="services.php" class="hover:text-white transition-colors"><?php echo $is_german ? 'Trockenbau' : 'Гипсокартон'; ?></a></li>
                        <li><a href="services.php" class="hover:text-white transition-colors"><?php echo $is_german ? 'Fliesenverlegung' : 'Плитка'; ?></a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h3 class="font-semibold text-lg mb-4"><?php echo $is_german ? 'Kontakt' : 'Контакты'; ?></h3>
                    <div class="space-y-2 text-gray-300">
                        <div class="flex items-center space-x-2">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <a href="tel:<?php echo str_replace([' ', '(', ')', '-'], '', $contact_info['phone']); ?>" 
                               class="text-gray-300 hover:text-white transition-colors cursor-pointer">
                                <?php echo htmlspecialchars($contact_info['phone']); ?>
                            </a>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <a href="mailto:<?php echo htmlspecialchars($contact_info['email']); ?>" 
                               class="text-gray-300 hover:text-white transition-colors cursor-pointer">
                                <?php echo htmlspecialchars($contact_info['email']); ?>
                            </a>
                        </div>
                        <div class="flex items-start space-x-2">
                            <svg class="h-5 w-5 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span><?php echo htmlspecialchars($contact_info['address']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">
                        © 2024 Frankfurt Innenausbau. <?php echo $is_german ? 'Alle Rechte vorbehalten.' : 'Все права защищены.'; ?>
                    </p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors"><?php echo $is_german ? 'Datenschutz' : 'Политика конфиденциальности'; ?></a>
                        <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors"><?php echo $is_german ? 'Nutzungsbedingungen' : 'Условия использования'; ?></a>
                        <a href="admin/login.php" class="text-gray-400 hover:text-white text-sm transition-colors"><?php echo $is_german ? 'Anmelden' : 'Вход'; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?php
}

/**
 * Рендеринг JavaScript
 */
function render_frontend_scripts() {
    ?>
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Mobile menu links
        document.querySelectorAll('.mobile-menu-link').forEach(link => {
            link.addEventListener('click', function() {
                document.getElementById('mobile-menu').classList.add('hidden');
            });
        });


        // Form validation
        function validateForm(form) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500');
                }
            });

            return isValid;
        }

        // Add form submission handlers
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!validateForm(this)) {
                    e.preventDefault();
                    alert('Пожалуйста, заполните все обязательные поля');
                }
            });
        });

        // Language switching with page preservation
        function switchLanguage(targetLanguage) {
            const currentUrl = window.location.pathname;
            const currentPage = currentUrl.split('/').pop() || 'index.php';
            
            // Определяем, находимся ли мы в немецкой версии
            const isGerman = currentUrl.startsWith('/de/');
            
            let targetUrl;
            if (targetLanguage === 'de') {
                // Переключаемся на немецкий
                if (isGerman) {
                    return; // Уже на немецком
                } else {
                    targetUrl = '/de/' + currentPage;
                }
            } else {
                // Переключаемся на русский
                if (isGerman) {
                    targetUrl = '/' + currentPage;
                } else {
                    return; // Уже на русском
                }
            }
            
            // Переходим на новую страницу
            window.location.href = targetUrl;
        }

        // Добавляем обработчики для переключателей языков
        document.querySelectorAll('a[href*="get_language_switch_url"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                if (href.includes('ru')) {
                    switchLanguage('ru');
                } else if (href.includes('de')) {
                    switchLanguage('de');
                }
            });
        });
    </script>
    <?php
}
?>

