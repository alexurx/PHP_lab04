<?php
require_once __DIR__ . '/db.php';

/**
 * Проверяет, есть ли ошибка для указанного поля
 */
function hasError(string $field): bool
{
    global $errors;
    return isset($errors[$field]);
}

/**
 * Возвращает текст ошибки для указанного поля
 */
function getError(string $field): string
{
    global $errors;
    return $errors[$field] ?? '';
}

/**
 * Возвращает старое значение поля
 */
function old(string $field, $default = '')
{
    return $_POST[$field] ?? $default;
}

/**
 * Перенаправляет на указанный URL
 */
function redirect(string $url)
{
    header("Location: $url");
    exit;
}

/**
 * Фильтрует и очищает входные данные
 */
function sanitize($data)
{
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    
    return htmlspecialchars(trim($data));
}

/**
 * Читает все рецепты из базы данных
 */
function readRecipes(): array
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM recipes ORDER BY created_at DESC");
    return $stmt->fetchAll();
}
