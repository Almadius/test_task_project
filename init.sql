-- Создание основной базы данных
CREATE DATABASE IF NOT EXISTS task_lara
    DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Настройка пользователя и прав доступа
GRANT ALL ON task_lara.* TO 'tasker'@'%' IDENTIFIED BY 'password';

FLUSH PRIVILEGES;
