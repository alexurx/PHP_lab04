<?php
require_once __DIR__ . '/config.php';

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
 * Возвращает старое значение поля или значение по умолчанию
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
 * Получение PDO-соединения с RDS
 */
function getDbConnection(): PDO {
    static $pdo;
    if (!$pdo) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ]);
    }
    return $pdo;
}

/**
 * Чтение всех рецептов из базы данных
 */
function readRecipes(): array {
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT * FROM recipes ORDER BY created_at DESC");
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

    return $recipes;
}

