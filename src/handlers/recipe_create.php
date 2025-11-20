<?php
require_once __DIR__ . '/../helpers.php';

$data = [
    'title' => sanitize($_POST['title'] ?? ''),
    'category' => sanitize($_POST['category'] ?? ''),
    'ingredients' => sanitize($_POST['ingredients'] ?? ''),
    'description' => sanitize($_POST['description'] ?? ''),
    'tags' => isset($_POST['tags']) ? array_map('sanitize', $_POST['tags']) : [],
    'steps' => isset($_POST['steps']) ? array_map('sanitize', $_POST['steps']) : [],
    'created_at' => date('Y-m-d H:i:s')
];

$errors = [];

if (empty($data['title'])) $errors['title'] = 'Название рецепта обязательно';
elseif (strlen($data['title']) > 255) $errors['title'] = 'Название не должно превышать 255 символов';
if (empty($data['category'])) $errors['category'] = 'Категория обязательна';
if (empty($data['ingredients'])) $errors['ingredients'] = 'Ингредиенты обязательны';
if (empty($data['description'])) $errors['description'] = 'Описание обязательно';

$validSteps = array_filter($data['steps'], fn($step) => !empty(trim($step)));
if (empty($validSteps)) $errors['steps'] = 'Добавьте хотя бы один шаг приготовления';
else $data['steps'] = $validSteps;

if (!empty($errors)) return;

// Сохранение в базу данных
global $pdo;

$stmt = $pdo->prepare("INSERT INTO recipes (title, category, ingredients, description, tags, steps, created_at)
                       VALUES (:title, :category, :ingredients, :description, :tags, :steps, :created_at)");

$stmt->execute([
    ':title' => $data['title'],
    ':category' => $data['category'],
    ':ingredients' => $data['ingredients'],
    ':description' => $data['description'],
    ':tags' => json_encode($data['tags'], JSON_UNESCAPED_UNICODE),
    ':steps' => json_encode($data['steps'], JSON_UNESCAPED_UNICODE),
    ':created_at' => $data['created_at']
]);

redirect('/public/index.php');
