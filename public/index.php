<?php
// Подключаем файл с вспомогательными функциями
require_once __DIR__ . '/../src/helpers.php';

// Получаем список всех рецептов
$recipes = readRecipes();

// Извлекаем два последних рецепта
$latestRecipes = array_slice($recipes, -2);

// Переворачиваем порядок рецептов, чтобы последние были первыми
$latestRecipes = array_reverse($latestRecipes);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог рецептов</title>
    <!-- Подключаем стили -->
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/recipes.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Последние рецепты</h1>
            <!-- Навигация -->
            <nav>
                <a href="/public/recipe/create.php">Добавить рецепт</a>
                <a href="/public/recipe/index.php">Все рецепты</a>
            </nav>
        </header>

        <!-- Проверяем, есть ли рецепты -->
        <?php if (empty($latestRecipes)): ?>
            <p>Рецептов пока нет. Будьте первым, кто добавит рецепт!</p>
        <?php else: ?>
            <div class="recipes-list">
                <!-- Перебираем и отображаем каждый рецепт -->
                <?php foreach ($latestRecipes as $recipe): ?>
                    <div class="recipe">
                        <!-- Заголовок рецепта -->
                        <h2><?= htmlspecialchars($recipe->title, ENT_QUOTES, 'UTF-8', false) ?></h2>
                        <!-- Категория рецепта -->
                        <p><strong>Категория:</strong> <?= htmlspecialchars($recipe->category, ENT_QUOTES, 'UTF-8', false) ?></p>
                        <!-- Ингредиенты -->
                        <p><strong>Ингредиенты:</strong></p>
                        <pre><?= htmlspecialchars($recipe->ingredients, ENT_QUOTES, 'UTF-8', false) ?></pre>
                        <!-- Описание рецепта -->
                        <p><strong>Описание:</strong></p>
                        <p><?= nl2br(htmlspecialchars($recipe->description, ENT_QUOTES, 'UTF-8', false)) ?></p>
                        
                        <!-- Теги рецепта, если они есть -->
                        <?php if (!empty($recipe->tags)): ?>
                            <div class="tags">
                                <?php foreach ($recipe->tags as $tag): ?>
                                    <span class="tag"><?= htmlspecialchars($tag) ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Шаги приготовления -->
                        <p><strong>Шаги приготовления:</strong></p>
                        <ol>
                            <?php foreach ($recipe->steps as $step): ?>
                                <li><?= htmlspecialchars($step) ?></li>
                            <?php endforeach; ?>
                        </ol>
                        
                        <!-- Дата добавления рецепта -->
                        <p class="recipe-date">Добавлено: <?= htmlspecialchars($recipe->created_at) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>