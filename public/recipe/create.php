<?php
// Добавляем путь к src/ в include_path
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/../../src/');
// Подключаем вспомогательные функции
require_once __DIR__ . '/../../src/helpers.php';

// Инициализация переменных
$errors = []; // Массив для хранения ошибок
$categories = ['Завтрак', 'Обед', 'Ужин', 'Десерт', 'Напитки']; // Категории рецептов
$tags = ['Вегетарианское', 'Острое', 'Быстрое', 'Для детей', 'Праздничное']; // Тэги рецептов

// Обработка POST-запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Подключаем обработчик создания рецепта
    require_once __DIR__ . '/../../src/handlers/recipe_create.php';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавить рецепт</title>
    <!-- Подключение CSS-стилей -->
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="/public/css/recipes.css">
</head>
<body>
    <h1>Добавить новый рецепт</h1>
    
    <!-- Форма для добавления рецепта -->
    <form method="post">
        <!-- Поле для ввода названия рецепта -->
        <div class="form-group">
            <label for="title">Название рецепта:</label>
            <input type="text" id="title" name="title" value="<?= old('title') ?>">
            <?php if (hasError('title')): ?>
                <span class="error"><?= getError('title') ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Выпадающий список для выбора категории -->
        <div class="form-group">
            <label for="category">Категория:</label>
            <select id="category" name="category">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category ?>" <?= old('category') === $category ? 'selected' : '' ?>>
                        <?= $category ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (hasError('category')): ?>
                <span class="error"><?= getError('category') ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Поле для ввода ингредиентов -->
        <div class="form-group">
            <label for="ingredients">Ингредиенты (каждый с новой строки):</label>
            <textarea id="ingredients" name="ingredients" rows="5"><?= old('ingredients') ?></textarea>
            <?php if (hasError('ingredients')): ?>
                <span class="error"><?= getError('ingredients') ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Поле для ввода описания рецепта -->
        <div class="form-group">
            <label for="description">Описание рецепта:</label>
            <textarea id="description" name="description" rows="5"><?= old('description') ?></textarea>
            <?php if (hasError('description')): ?>
                <span class="error"><?= getError('description') ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Выпадающий список для выбора тэгов -->
        <div class="form-group">
            <label for="tags">Тэги (удерживайте Ctrl для выбора нескольких):</label>
            <select id="tags" name="tags[]" multiple>
                <?php foreach ($tags as $tag): ?>
                    <option value="<?= $tag ?>" <?= in_array($tag, old('tags', [])) ? 'selected' : '' ?>>
                        <?= $tag ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (hasError('tags')): ?>
                <span class="error"><?= getError('tags') ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Поле для добавления шагов приготовления -->
        <div class="form-group">
            <label>Шаги приготовления:</label>
            <div id="steps-container">
                <?php 
                // Получаем старые значения шагов или создаем пустой массив
                $steps = old('steps', ['']);
                foreach ($steps as $index => $step): 
                ?>
                    <div class="step">
                        <input type="text" name="steps[]" value="<?= $step ?>">
                        <?php if ($index > 0): ?>
                            <button type="button" class="remove-step">Удалить</button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" id="add-step">Добавить шаг</button>
            <?php if (hasError('steps')): ?>
                <span class="error"><?= getError('steps') ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Кнопка отправки формы -->
        <button type="submit">Отправить</button>
    </form>
    
    <script>
        // Добавление нового шага приготовления
        document.getElementById('add-step').addEventListener('click', function() {
            const container = document.getElementById('steps-container');
            const div = document.createElement('div');
            div.className = 'step';
            div.innerHTML = `
                <input type="text" name="steps[]">
                <button type="button" class="remove-step">Удалить</button>
            `;
            container.appendChild(div);
            
            // Добавление обработчика для кнопки удаления шага
            div.querySelector('.remove-step').addEventListener('click', function() {
                container.removeChild(div);
            });
        });
        
        // Обработчики для существующих кнопок удаления шагов
        document.querySelectorAll('.remove-step').forEach(button => {
            button.addEventListener('click', function() {
                this.parentNode.remove();
            });
        });
    </script>
</body>
</html>