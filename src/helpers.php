<?php
/**
 * Проверяет, есть ли ошибка для указанного поля
 * 
 * @param string $field Имя поля
 * @return bool
 */
function hasError(string $field): bool
{
    global $errors;
    return isset($errors[$field]);
}

/**
 * Возвращает текст ошибки для указанного поля
 * 
 * @param string $field Имя поля
 * @return string
 */
function getError(string $field): string
{
    global $errors;
    return $errors[$field] ?? '';
}

/**
 * Возвращает старое значение поля или значение по умолчанию
 * 
 * @param string $field Имя поля
 * @param mixed $default Значение по умолчанию
 * @return mixed
 */
function old(string $field, $default = '')
{
    return $_POST[$field] ?? $default;
}

/**
 * Перенаправляет на указанный URL
 * 
 * @param string $url URL для перенаправления
 */
function redirect(string $url)
{
    header("Location: $url");
    exit;
}

/**
 * Фильтрует и очищает входные данные
 * 
 * @param mixed $data Входные данные
 * @return mixed Очищенные данные
 */
function sanitize($data)
{
    if (is_array($data)) {
        return array_map('sanitize', $data);
    }
    
    return htmlspecialchars(trim($data));
}

/**
 * Читает все рецепты из файла
 * 
 * @return array Массив рецептов
 */
function readRecipes(): array
{
    $filename = __DIR__ . '/../storage/recipes.txt';
    if (!file_exists($filename)) {
        return [];
    }
    
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return array_map('json_decode', $lines);
}

