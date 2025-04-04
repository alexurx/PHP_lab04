<?php
require_once __DIR__ . '/../../src/helpers.php'; // Подключение вспомогательных функций

// Чтение рецептов из источника данных
$recipes = readRecipes();
$recipes = array_reverse($recipes); // Новые рецепты отображаются первыми

// Пагинация
$perPage = 5; // Количество рецептов на одной странице
$totalRecipes = count($recipes); // Общее количество рецептов
$totalPages = ceil($totalRecipes / $perPage); // Общее количество страниц

// Определение текущей страницы
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($currentPage < 1 || $currentPage > $totalPages) {
    $currentPage = 1; // Если страница некорректна, устанавливаем первую страницу
}

$offset = ($currentPage - 1) * $perPage; // Смещение для выборки рецептов
$paginatedRecipes = array_slice($recipes, $offset, $perPage); // Рецепты для текущей страницы
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Все рецепты</title>
    <link rel="stylesheet" href="/public/css/main.css"> <!-- Основной стиль -->
    <link rel="stylesheet" href="/public/css/recipes.css"> <!-- Стиль для рецептов -->
</head>
<body>
    <div class="container">
        <h1>Все рецепты</h1>
        
        <!-- Ссылки на главную страницу и добавление рецепта -->
        <a href="/public/index.php">На главную</a>
        <a href="/public/recipe/create.php">Добавить рецепт</a>
        
        <?php if (empty($paginatedRecipes)): ?>
            <!-- Сообщение, если рецептов нет -->
            <p>Рецептов пока нет. Будьте первым, кто добавит рецепт!</p>
        <?php else: ?>
            <!-- Вывод списка рецептов -->
            <?php foreach ($paginatedRecipes as $recipe): ?>
                <div class="recipe">
                    <h2><?= htmlspecialchars($recipe->title, ENT_QUOTES, 'UTF-8', false) ?></h2>
                    <p><strong>Категория:</strong> <?= htmlspecialchars($recipe->title, ENT_QUOTES, 'UTF-8', false) ?></p>
                    <p><strong>Ингредиенты:</strong></p>
                    <pre><?= htmlspecialchars($recipe->title, ENT_QUOTES, 'UTF-8', false) ?></pre>
                    <p><strong>Описание:</strong></p>
                    <p><?= nl2br(htmlspecialchars($recipe->description, ENT_QUOTES, 'UTF-8', false)) ?></p>
                    
                    <?php if (!empty($recipe->tags)): ?>
                        <!-- Вывод тегов рецепта -->
                        <div class="tags">
                            <?php foreach ($recipe->tags as $tag): ?>
                                <span class="tag"><?= htmlspecialchars($tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <p><strong>Шаги приготовления:</strong></p>
                    <ol>
                        <!-- Вывод шагов приготовления -->
                        <?php foreach ($recipe->steps as $step): ?>
                            <li><?= htmlspecialchars($step) ?></li>
                        <?php endforeach; ?>
                    </ol>
                    
                    <p><small>Добавлено: <?= htmlspecialchars($recipe->title, ENT_QUOTES, 'UTF-8', false) ?></small></p>
                </div>
            <?php endforeach; ?>
            
            <!-- Пагинация -->
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <!-- Ссылка на предыдущую страницу -->
                    <a href="?page=<?= $currentPage - 1 ?>">Назад</a>
                <?php endif; ?>
                
                <!-- Ссылки на все страницы -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i ?>" <?= $i === $currentPage ? 'style="font-weight:bold;"' : '' ?>>
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
                
                <?php if ($currentPage < $totalPages): ?>
                    <!-- Ссылка на следующую страницу -->
                    <a href="?page=<?= $currentPage + 1 ?>">Вперед</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>