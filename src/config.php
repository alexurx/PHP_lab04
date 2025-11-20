<?php
// Настройки подключения к базе данных RDS
define('DB_HOST', 'project-rds-mysql-prod.<region>.rds.amazonaws.com'); // замените <region> на ваш регион
define('DB_NAME', 'project_db');
define('DB_USER', 'admin'); // имя пользователя RDS
define('DB_PASS', 'YourPassword123'); // пароль RDS
define('DB_CHARSET', 'utf8mb4'); // кодировка
