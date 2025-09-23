import { test, expect } from '@playwright/test';

test.describe('Admin Blog Post Preview', () => {
    test.beforeEach(async ({ page }) => {
        // Навигация на страницу логина админки
        await page.goto('/admin/login.php');

        // Заполняем форму логина
        await page.fill('input[name="username"]', 'admin');
        await page.fill('input[name="password"]', 'adminpass');
        await page.click('button[type="submit"]');

        // Ожидаем редиректа на дашборд админки
        await page.waitForURL('/admin/index.php');
        
        // Переходим на страницу создания/редактирования блога
        await page.goto('/admin/blog.php?action=create');
    });

    test('should open a new window with a preview of the blog post', async ({ page, context }) => {
        // Заполняем поля формы
        await page.fill('input[name="title"]', 'Тестовая статья для предварительного просмотра');
        await page.fill('textarea[name="excerpt"]', 'Краткое описание тестовой статьи.');
        await page.fill('textarea[name="content"]', '<h2>Заголовок H2</h2><p>Это содержание тестовой статьи с <strong>HTML</strong> разметкой.</p><ul><li>Пункт 1</li><li>Пункт 2</li></ul>');
        await page.selectOption('select[name="category"]', 'news');
        await page.fill('input[name="tags"]', 'тест, превью, блог');
        await page.fill('input[name="featured_image"]', '/assets/images/placeholder-1.jpg');
        await page.fill('input[name="meta_title"]', 'SEO заголовок тестовой статьи');
        await page.fill('textarea[name="meta_description"]', 'SEO описание для тестовой статьи, которое должно быть длиннее 50 символов.');
        await page.fill('input[name="keywords"]', 'тестовая, статья, превью, блог');

        // Нажимаем кнопку предварительного просмотра
        const [previewPage] = await Promise.all([
            context.waitForEvent('page'), // Ожидаем открытия новой страницы
            page.click('button:has-text("Предварительный просмотр")'),
        ]);

        // Ожидаем загрузки новой страницы
        await previewPage.waitForLoadState();
        
        // Проверяем URL и заголовок новой страницы
        expect(previewPage.url()).toContain('/admin/blog_preview.php');
        await expect(previewPage).toHaveTitle(/Тестовая статья для предварительного просмотра \(Предпросмотр\) | Baumaster Frankfurt/);

        // Проверяем содержимое новой страницы
        await expect(previewPage.locator('h1')).toHaveText('Тестовая статья для предварительного просмотра');
        await expect(previewPage.locator('p.text-xl')).toHaveText('Краткое описание тестовой статьи.');
        await expect(previewPage.locator('article.prose')).toContainText('Это содержание тестовой статьи с HTML разметкой.');
        await expect(previewPage.locator('span:has-text("Новости")')).toBeVisible();
        await expect(previewPage.locator('span:has-text("#тест")')).toBeVisible();
        await expect(previewPage.locator('span:has-text("#превью")')).toBeVisible();
        await expect(previewPage.locator('span:has-text("#блог")')).toBeVisible();
        await expect(previewPage.locator('img[alt="Тестовая статья для предварительного просмотра"]')).toBeVisible();

        // Закрываем окно предварительного просмотра
        await previewPage.close();
    });

    test('should display validation errors if form is invalid before preview', async ({ page }) => {
        // Попытка предварительного просмотра с пустыми полями
        await page.click('button:has-text("Предварительный просмотр")');

        // Ожидаем появления alert с ошибками валидации
        page.on('dialog', async dialog => {
            expect(dialog.type()).toBe('alert');
            expect(dialog.message()).toContain('Ошибки валидации:');
            expect(dialog.message()).toContain('Заголовок должен содержать минимум 5 символов');
            expect(dialog.message()).toContain('Содержание должно содержать минимум 50 символов');
            expect(dialog.message()).toContain('Необходимо выбрать категорию');
            await dialog.accept();
        });

        // Убедимся, что alert был вызван
        await page.waitForEvent('dialog');
    });
});
