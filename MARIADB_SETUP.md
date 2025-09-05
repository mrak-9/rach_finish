# Настройка MariaDB для проекта РАЧ

## Установка MariaDB

### Ubuntu/Debian:
```bash
sudo apt update
sudo apt install mariadb-server mariadb-client
sudo mysql_secure_installation
```

### CentOS/RHEL:
```bash
sudo yum install mariadb-server mariadb
sudo systemctl start mariadb
sudo systemctl enable mariadb
sudo mysql_secure_installation
```

### macOS (с Homebrew):
```bash
brew install mariadb
brew services start mariadb
mysql_secure_installation
```

### Windows:
Скачайте и установите MariaDB с официального сайта: https://mariadb.org/download/

## Настройка базы данных

1. **Подключение к MariaDB:**
```bash
mysql -u root -p
```

2. **Создание базы данных:**
```sql
CREATE DATABASE rach_website 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;
```

3. **Создание пользователя (рекомендуется):**
```sql
CREATE USER 'rach_user'@'localhost' IDENTIFIED BY 'secure_password_here';
GRANT ALL PRIVILEGES ON rach_website.* TO 'rach_user'@'localhost';
FLUSH PRIVILEGES;
```

4. **Проверка созданной базы:**
```sql
SHOW DATABASES;
USE rach_website;
SHOW TABLES;
```

5. **Выход из MariaDB:**
```sql
EXIT;
```

## Настройка Laravel

1. **Обновите .env файл:**
```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rach_website
DB_USERNAME=rach_user
DB_PASSWORD=secure_password_here
```

2. **Запустите миграции:**
```bash
php artisan migrate
```

3. **Создайте администратора:**
```bash
php artisan make:filament-user
```

## Оптимизация производительности

### Рекомендуемые настройки my.cnf:

```ini
[mysqld]
# Основные настройки
default-storage-engine = InnoDB
character-set-server = utf8mb4
collation-server = utf8mb4_unicode_ci

# Производительность
innodb_buffer_pool_size = 256M
innodb_log_file_size = 64M
innodb_flush_log_at_trx_commit = 2
innodb_flush_method = O_DIRECT

# Соединения
max_connections = 200
max_connect_errors = 10000

# Кеширование запросов
query_cache_type = 1
query_cache_size = 32M
query_cache_limit = 2M

# Временные таблицы
tmp_table_size = 64M
max_heap_table_size = 64M

# Логирование (для разработки)
slow_query_log = 1
slow_query_log_file = /var/log/mysql/slow.log
long_query_time = 2
```

## Резервное копирование

### Создание резервной копии:
```bash
mysqldump -u rach_user -p rach_website > rach_backup_$(date +%Y%m%d_%H%M%S).sql
```

### Восстановление из резервной копии:
```bash
mysql -u rach_user -p rach_website < rach_backup_20240101_120000.sql
```

## Мониторинг

### Проверка статуса MariaDB:
```bash
sudo systemctl status mariadb
```

### Просмотр процессов:
```sql
SHOW PROCESSLIST;
```

### Проверка размера базы данных:
```sql
SELECT 
    table_schema AS 'Database',
    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS 'Size (MB)'
FROM information_schema.tables 
WHERE table_schema = 'rach_website'
GROUP BY table_schema;
```

## Безопасность

1. **Используйте сильные пароли**
2. **Ограничьте доступ по IP (если необходимо):**
```sql
CREATE USER 'rach_user'@'192.168.1.%' IDENTIFIED BY 'password';
```

3. **Регулярно обновляйте MariaDB**
4. **Настройте файрвол для порта 3306**
5. **Используйте SSL соединения в продакшене**

## Устранение неполадок

### Проблема с подключением:
```bash
# Проверьте статус службы
sudo systemctl status mariadb

# Перезапустите службу
sudo systemctl restart mariadb

# Проверьте логи
sudo tail -f /var/log/mysql/error.log
```

### Проблема с кодировкой:
```sql
-- Проверьте текущие настройки
SHOW VARIABLES LIKE 'character_set%';
SHOW VARIABLES LIKE 'collation%';

-- Измените кодировку базы данных
ALTER DATABASE rach_website CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Проблема с производительностью:
```sql
-- Анализ медленных запросов
SHOW VARIABLES LIKE 'slow_query_log';
SHOW VARIABLES LIKE 'long_query_time';

-- Оптимизация таблиц
OPTIMIZE TABLE table_name;

-- Анализ использования индексов
EXPLAIN SELECT * FROM table_name WHERE condition;
```