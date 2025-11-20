<?php
require_once 'config.php';

function getDbConnection() {
    try {
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8";
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}
