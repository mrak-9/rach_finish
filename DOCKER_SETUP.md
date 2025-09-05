# Docker развертывание проекта РАЧ

## Быстрый старт с Docker

### Требования
- Docker 20.10+
- Docker Compose 2.0+

### Запуск проекта

1. **Клонирование репозитория:**
```bash
git clone https://github.com/mrak-9/rach_finish.git
cd rach_finish
```

2. **Создание .env файла:**
```bash
cp .env.example .env
```

3. **Запуск контейнеров:**
```bash
docker-compose up -d
```

4. **Установка зависимостей и настройка:**
```bash
# Генерация ключа приложения
docker-compose exec app php artisan key:generate

# Запуск миграций
docker-compose exec app php artisan migrate

# Создание администратора
docker-compose exec app php artisan make:filament-user

# Создание символической ссылки для storage
docker-compose exec app php artisan storage:link
```

### Доступ к приложению

- **Сайт:** http://localhost:12000
- **Админ панель:** http://localhost:12000/admin
- **phpMyAdmin:** http://localhost:8080
- **MariaDB:** localhost:3306

### Учетные данные по умолчанию

**MariaDB:**
- Хост: localhost:3306
- База данных: rach_website
- Пользователь: rach_user
- Пароль: rach_password
- Root пароль: root_password

**phpMyAdmin:**
- Пользователь: root
- Пароль: root_password

## Управление контейнерами

### Основные команды

```bash
# Запуск всех сервисов
docker-compose up -d

# Остановка всех сервисов
docker-compose down

# Просмотр логов
docker-compose logs -f

# Просмотр логов конкретного сервиса
docker-compose logs -f app
docker-compose logs -f mariadb

# Перезапуск сервиса
docker-compose restart app

# Выполнение команд в контейнере
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear

# Подключение к контейнеру
docker-compose exec app sh
docker-compose exec mariadb mysql -u root -p
```

### Обновление приложения

```bash
# Остановка контейнеров
docker-compose down

# Обновление кода
git pull origin main

# Пересборка и запуск
docker-compose up -d --build

# Обновление зависимостей
docker-compose exec app composer install --no-dev --optimize-autoloader
docker-compose exec app npm install && npm run build

# Запуск миграций
docker-compose exec app php artisan migrate

# Очистка кеша
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

## Настройка для продакшена

### 1. Обновите docker-compose.prod.yml:

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    restart: unless-stopped
    ports:
      - "80:8000"
    volumes:
      - ./storage/app/events:/var/www/html/storage/app/events
      - ./storage/logs:/var/www/html/storage/logs
    environment:
      - APP_ENV=production
      - APP_DEBUG=false
      - DB_CONNECTION=mariadb
      - DB_HOST=mariadb
      - DB_PORT=3306
      - DB_DATABASE=rach_website
      - DB_USERNAME=rach_user
      - DB_PASSWORD=${DB_PASSWORD}
    depends_on:
      - mariadb
    networks:
      - rach-network

  mariadb:
    image: mariadb:10.11
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
      MYSQL_DATABASE: rach_website
      MYSQL_USER: rach_user
      MYSQL_PASSWORD: ${DB_PASSWORD}
    volumes:
      - mariadb_data:/var/lib/mysql
      - ./backups:/backups
    networks:
      - rach-network

volumes:
  mariadb_data:
    driver: local

networks:
  rach-network:
    driver: bridge
```

### 2. Создайте .env.production:

```env
APP_NAME="Русская ассоциация чтения"
APP_ENV=production
APP_KEY=base64:your_generated_key_here
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mariadb
DB_HOST=mariadb
DB_PORT=3306
DB_DATABASE=rach_website
DB_USERNAME=rach_user
DB_PASSWORD=your_secure_password

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="Русская ассоциация чтения"
```

### 3. Запуск в продакшене:

```bash
# Копирование конфигурации
cp .env.production .env

# Запуск с продакшн конфигурацией
docker-compose -f docker-compose.prod.yml up -d

# Оптимизация для продакшена
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
docker-compose exec app php artisan optimize
```

## Резервное копирование

### Автоматическое резервное копирование:

```bash
# Создание скрипта резервного копирования
cat > backup.sh << 'EOF'
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups"

# Создание резервной копии базы данных
docker-compose exec -T mariadb mysqldump -u root -p${MYSQL_ROOT_PASSWORD} rach_website > ${BACKUP_DIR}/rach_backup_${DATE}.sql

# Создание архива файлов
tar -czf ${BACKUP_DIR}/rach_files_${DATE}.tar.gz storage/app/events storage/app/public

# Удаление старых резервных копий (старше 30 дней)
find ${BACKUP_DIR} -name "rach_*" -type f -mtime +30 -delete

echo "Backup completed: ${DATE}"
EOF

chmod +x backup.sh
```

### Восстановление из резервной копии:

```bash
# Восстановление базы данных
docker-compose exec -T mariadb mysql -u root -p${MYSQL_ROOT_PASSWORD} rach_website < /backups/rach_backup_20240101_120000.sql

# Восстановление файлов
tar -xzf /backups/rach_files_20240101_120000.tar.gz
```

## Мониторинг

### Проверка состояния контейнеров:

```bash
# Статус всех контейнеров
docker-compose ps

# Использование ресурсов
docker stats

# Проверка логов на ошибки
docker-compose logs app | grep -i error
docker-compose logs mariadb | grep -i error
```

### Настройка логирования:

```bash
# Ротация логов
cat > /etc/logrotate.d/docker-rach << 'EOF'
/var/lib/docker/containers/*/*.log {
    rotate 7
    daily
    compress
    size=1M
    missingok
    delaycompress
    copytruncate
}
EOF
```

## Устранение неполадок

### Проблемы с подключением к базе данных:

```bash
# Проверка подключения к MariaDB
docker-compose exec app php artisan tinker
# В tinker: DB::connection()->getPdo();

# Проверка логов MariaDB
docker-compose logs mariadb

# Перезапуск MariaDB
docker-compose restart mariadb
```

### Проблемы с правами доступа:

```bash
# Исправление прав доступа
docker-compose exec app chown -R www:www /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
```

### Очистка Docker:

```bash
# Удаление неиспользуемых образов
docker system prune -a

# Полная очистка (ОСТОРОЖНО!)
docker-compose down -v
docker system prune -a --volumes
```