<?php
/**
 * Немецкая версия страницы портфолио
 * Baumaster Frontend - Portfolio Page (German)
 */

// Подключение компонентов
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../ux/layout.php';
require_once __DIR__ . '/../ux/components.php';
require_once __DIR__ . '/../ux/data.php';
require_once __DIR__ . '/../integrations/translation/FastTranslationManager.php';

// Установка языка
define('CURRENT_LANG', 'de');

// Получение данных
$seo = get_seo_data()['portfolio'];
$portfolio = get_portfolio_data();
$translation_manager = new FastTranslationManager();

// Начало контента
ob_start();
?>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<!-- Hero Section -->
<section class="pt-16 bg-gradient-to-br from-gray-50 to-gray-100 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="font-montserrat font-semibold text-4xl lg:text-5xl text-text-primary mb-6">
                Unser Portfolio
            </h1>
            <p class="text-xl text-text-secondary max-w-4xl mx-auto">
                Sehen Sie sich Beispiele unserer Arbeiten an — von kleinen kosmetischen Renovierungen bis zur 
                kompletten Rekonstruktion von Wohnungen und Büros in Frankfurt.
            </p>
        </div>
    </div>
</section>

<!-- Filter Tabs -->
<section class="py-8 bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-4">
            <button class="filter-btn active px-6 py-2 rounded-full border-2 border-accent-blue text-accent-blue font-medium hover:bg-accent-blue hover:text-white transition-colors" data-filter="all">
                Alle Projekte
            </button>
            <button class="filter-btn px-6 py-2 rounded-full border-2 border-gray-300 text-text-secondary hover:border-accent-blue hover:text-accent-blue transition-colors" data-filter="apartment">
                Wohnungen
            </button>
            <button class="filter-btn px-6 py-2 rounded-full border-2 border-gray-300 text-text-secondary hover:border-accent-blue hover:text-accent-blue transition-colors" data-filter="bathroom">
                Badezimmer
            </button>
            <button class="filter-btn px-6 py-2 rounded-full border-2 border-gray-300 text-text-secondary hover:border-accent-blue hover:text-accent-blue transition-colors" data-filter="office">
                Büros
            </button>
        </div>
    </div>
</section>

<!-- Portfolio Grid -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($portfolio as $project): ?>
                <?php 
                // Получаем переводы для проекта
                $translated_project = $translation_manager->getTranslatedContent('portfolio', $project['id'], 'de');
                if ($translated_project) {
                    $project = array_merge($project, $translated_project);
                }
                ?>
                <div class="portfolio-item bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden" 
                     data-category="<?php echo strtolower(str_replace(' ', '-', $project['category'])); ?>">
                    
                    <!-- Featured Image -->
                    <div class="relative h-64 bg-gray-200 overflow-hidden group">
                        <img src="<?php echo htmlspecialchars($project['image']); ?>" 
                             alt="<?php echo htmlspecialchars($project['title']); ?>" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                            <button class="opacity-0 group-hover:opacity-100 bg-white text-accent-blue px-4 py-2 rounded font-medium transition-opacity" 
                                    onclick="openProjectModal(<?php echo $project['id']; ?>)">
                                Mehr erfahren
                            </button>
                        </div>
                        <div class="absolute top-4 left-4">
                            <span class="inline-block px-3 py-1 bg-accent-blue text-white text-sm rounded-full">
                                <?php echo htmlspecialchars($project['category']); ?>
                            </span>
                        </div>
                        <?php if ($project['featured']): ?>
                        <div class="absolute top-4 right-4">
                            <span class="inline-block px-2 py-1 bg-yellow-500 text-white text-xs rounded-full">
                                ⭐ Empfohlen
                            </span>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Project Info -->
                    <div class="p-6">
                        <h3 class="font-semibold text-xl text-text-primary mb-3">
                            <?php echo htmlspecialchars($project['title']); ?>
                        </h3>
                        <p class="text-text-secondary mb-4 line-clamp-3">
                            <?php echo htmlspecialchars($project['description']); ?>
                        </p>
                        
                        <!-- Project Stats -->
                        <div class="grid grid-cols-2 gap-4 mb-4 text-sm text-text-secondary">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 mr-2 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                </svg>
                                <?php echo htmlspecialchars($project['area']); ?>
                            </div>
                            <div class="flex items-center">
                                <svg class="h-4 w-4 mr-2 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <?php echo htmlspecialchars($project['duration']); ?>
                            </div>
                            <?php if ($project['budget']): ?>
                            <div class="flex items-center col-span-2">
                                <svg class="h-4 w-4 mr-2 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                €<?php echo number_format($project['budget'], 0, ',', ' '); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Tags -->
                        <?php if (!empty($project['tags'])): ?>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <?php foreach (array_slice($project['tags'], 0, 3) as $tag): ?>
                                <span class="inline-block px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded">
                                    <?php echo htmlspecialchars($tag); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <button onclick="openProjectModal(<?php echo $project['id']; ?>)" 
                                    class="flex-1 bg-accent-blue text-white px-4 py-2 rounded font-medium hover:bg-blue-600 transition-colors">
                                Mehr erfahren
                            </button>
                            <?php if (!empty($project['gallery'])): ?>
                            <button onclick="openGallery(<?php echo $project['id']; ?>)" 
                                    class="px-4 py-2 border border-accent-blue text-accent-blue rounded font-medium hover:bg-accent-blue hover:text-white transition-colors">
                                Galerie
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="py-20 bg-premium-gray">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="font-montserrat font-semibold text-3xl lg:text-4xl text-text-primary mb-4">
                Projektphasen
            </h2>
            <p class="text-xl text-text-secondary max-w-3xl mx-auto">
                Jedes unserer Projekte durchläuft sorgfältig durchdachte Phasen für ein perfektes Ergebnis
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-accent-blue text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-xl text-text-primary mb-3">Planung</h3>
                <p class="text-text-secondary">Wir besprechen Details, erstellen einen Arbeitsplan, wählen Materialien aus und vereinbaren Termine.</p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-accent-blue text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-xl text-text-primary mb-3">Vorbereitung</h3>
                <p class="text-text-secondary">Abbruch alter Beschichtungen, Oberflächenvorbereitung, Schutz von Möbeln und Interieur.</p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-accent-blue text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-xl text-text-primary mb-3">Ausführung</h3>
                <p class="text-text-secondary">Hauptarbeiten: Montage, Veredelung, Malerei. Regelmäßige Qualitätskontrolle in jeder Phase.</p>
            </div>
            
            <div class="text-center">
                <div class="w-20 h-20 bg-accent-blue text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-xl text-text-primary mb-3">Übergabe</h3>
                <p class="text-text-secondary">Endreinigung, Qualitätsprüfung, Beseitigung kleiner Mängel und feierliche Objektübergabe.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-montserrat font-semibold text-3xl lg:text-4xl text-text-primary mb-6">
            Möchten Sie ein ähnliches Ergebnis?
        </h2>
        <p class="text-xl text-text-secondary mb-8 max-w-2xl mx-auto">
            Lassen Sie uns Ihr Projekt besprechen und ein einzigartiges Raumkonzept unter Berücksichtigung aller Wünsche und Besonderheiten erstellen.
        </p>
        
        <?php render_frontend_button([
            'text' => 'Projekt besprechen',
            'variant' => 'primary',
            'size' => 'lg',
            'href' => 'contact.php'
        ]); ?>
    </div>
</section>

<!-- Modals -->
<!-- Project Detail Modal -->
<div id="projectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div id="projectModalContent" class="w-full max-w-4xl"></div>
</div>

<!-- Gallery Modal -->
<div id="galleryModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div id="galleryModalContent" class="w-full max-w-4xl"></div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div id="imageModalContent" class="w-full max-w-4xl"></div>
</div>

<script>
// Portfolio data for JavaScript
const portfolioData = <?php echo json_encode($portfolio, JSON_UNESCAPED_UNICODE); ?>;
// Portfolio filtering
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Update active state
        document.querySelectorAll('.filter-btn').forEach(b => {
            b.classList.remove('active');
            b.classList.add('border-gray-300', 'text-text-secondary');
            b.classList.remove('border-accent-blue', 'text-accent-blue');
        });
        
        this.classList.add('active');
        this.classList.remove('border-gray-300', 'text-text-secondary');
        this.classList.add('border-accent-blue', 'text-accent-blue');
        
        // Filter items
        const filter = this.dataset.filter;
        document.querySelectorAll('.portfolio-item').forEach(item => {
            if (filter === 'all' || item.dataset.category === filter) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
});

// Project modal
function openProjectModal(projectId) {
    const project = portfolioData.find(p => p.id == projectId);
    if (!project) return;
    
    const modal = document.getElementById('projectModal');
    const modalContent = document.getElementById('projectModalContent');
    
    modalContent.innerHTML = `
        <div class="bg-white rounded-lg max-w-4xl mx-auto max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-900">${project.title}</h2>
                <button onclick="closeProjectModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                <!-- Featured Image -->
                <div class="mb-6">
                    <img src="${project.image}" alt="${project.title}" class="w-full h-64 object-cover rounded-lg">
                </div>
                
                <!-- Project Info -->
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Projektinformationen</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Fläche:</span>
                                <span class="font-medium">${project.area}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Dauer:</span>
                                <span class="font-medium">${project.duration}</span>
                            </div>
                            ${project.budget ? `
                            <div class="flex justify-between">
                                <span class="text-gray-600">Budget:</span>
                                <span class="font-medium">€${new Intl.NumberFormat('de-DE').format(project.budget)}</span>
                            </div>
                            ` : ''}
                            ${project.completion_date ? `
                            <div class="flex justify-between">
                                <span class="text-gray-600">Fertigstellung:</span>
                                <span class="font-medium">${new Date(project.completion_date).toLocaleDateString('de-DE')}</span>
                            </div>
                            ` : ''}
                            ${project.client_name ? `
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kunde:</span>
                                <span class="font-medium">${project.client_name}</span>
                            </div>
                            ` : ''}
                            ${project.location ? `
                            <div class="flex justify-between">
                                <span class="text-gray-600">Standort:</span>
                                <span class="font-medium">${project.location}</span>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Beschreibung</h3>
                        <p class="text-gray-700 leading-relaxed">${project.description}</p>
                    </div>
                </div>
                
                <!-- Tags -->
                ${project.tags && project.tags.length > 0 ? `
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        ${project.tags.map(tag => `
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">${tag}</span>
                        `).join('')}
                    </div>
                </div>
                ` : ''}
            </div>
        </div>
    `;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeProjectModal() {
    const modal = document.getElementById('projectModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Gallery modal
function openGallery(projectId) {
    const project = portfolioData.find(p => p.id == projectId);
    if (!project || !project.gallery || project.gallery.length === 0) return;
    
    const modal = document.getElementById('galleryModal');
    const modalContent = document.getElementById('galleryModalContent');
    
    modalContent.innerHTML = `
        <div class="bg-white rounded-lg max-w-4xl mx-auto max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="sticky top-0 bg-white border-b px-6 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-900">Galerie: ${project.title}</h2>
                <button onclick="closeGalleryModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Gallery Grid -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    ${project.gallery.map(image => `
                        <img src="${image}" alt="Galerie" class="w-full h-48 object-cover rounded-lg cursor-pointer hover:opacity-75 transition-opacity" onclick="openImageModal('${image}')">
                    `).join('')}
                </div>
            </div>
        </div>
    `;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeGalleryModal() {
    const modal = document.getElementById('galleryModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Image modal
function openImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalContent = document.getElementById('imageModalContent');
    
    modalContent.innerHTML = `
        <div class="bg-white rounded-lg max-w-4xl mx-auto">
            <div class="relative">
                <img src="${imageSrc}" alt="Bild" class="w-full h-auto max-h-[80vh] object-contain">
                <button onclick="closeImageModal()" class="absolute top-4 right-4 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    `;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}
</script>

<?php
$content = ob_get_clean();

// Рендер страницы
render_frontend_layout([
    'title' => $seo['title'] ?? 'Unsere Arbeiten - Baumaster Frankfurt',
    'description' => $seo['description'] ?? 'Sehen Sie sich unsere Portfolio-Projekte an - von kleinen Renovierungen bis zur kompletten Rekonstruktion in Frankfurt.',
    'content' => $content
]);
?>