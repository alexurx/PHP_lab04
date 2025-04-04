<?php
require_once __DIR__ . '/../helpers.php';

// Фильтрация данных
// Считываем данные из POST-запроса, очищаем их с помощью функции sanitize и формируем массив $data
$data = [
    'title' => sanitize($_POST['title'] ?? ''), // Название рецепта
    'category' => sanitize($_POST['category'] ?? ''), // Категория рецепта
    'ingredients' => sanitize($_POST['ingredients'] ?? ''), // Ингредиенты
    'description' => sanitize($_POST['description'] ?? ''), // Описание рецепта
    'tags' => isset($_POST['tags']) ? array_map('sanitize', $_POST['tags']) : [], // Теги рецепта
    'steps' => isset($_POST['steps']) ? array_map('sanitize', $_POST['steps']) : [], // Шаги приготовления
    'created_at' => date('Y-m-d H:i:s') // Дата и время создания
];

// Валидация
// Проверяем данные на корректность и формируем массив ошибок $errors
$errors = [];

if (empty($data['title'])) {
    $errors['title'] = 'Название рецепта обязательно'; // Проверка на пустое название
} elseif (strlen($data['title']) > 255) {
    $errors['title'] = 'Название не должно превышать 255 символов'; // Проверка длины названия
}

if (empty($data['category'])) {
    $errors['category'] = 'Категория обязательна'; // Проверка на пустую категорию
}

if (empty($data['ingredients'])) {
    $errors['ingredients'] = 'Ингредиенты обязательны'; // Проверка на пустые ингредиенты
}

if (empty($data['description'])) {
    $errors['description'] = 'Описание обязательно'; // Проверка на пустое описание
}

// Фильтруем шаги приготовления, удаляя пустые или пробельные значения
$validSteps = array_filter($data['steps'], function($step) {
    return !empty(trim($step));
});

if (empty($validSteps)) {
    $errors['steps'] = 'Добавьте хотя бы один шаг приготовления'; // Проверка на наличие хотя бы одного шага
} else {
    $data['steps'] = $validSteps; // Сохраняем отфильтрованные шаги
}

// Если есть ошибки, возвращаемся на форму
if (!empty($errors)) {
    return; // Завершаем выполнение скрипта, если есть ошибки
}

// Сохранение в файл
// Сохраняем данные рецепта в файл recipes.txt в формате JSON
$filename = __DIR__ . '/../../storage/recipes.txt';
file_put_contents($filename, json_encode($data) . PHP_EOL, FILE_APPEND);

// Перенаправление на главную
// После успешного сохранения перенаправляем пользователя на главную страницу
redirect('/public/index.php');