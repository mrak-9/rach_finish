FROM php:8.2-fpm-alpine

# Установка системных зависимостей
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    zip \
    unzip \
    nodejs \
    npm \
    nginx \
    supervisor

# Установка PHP расширений
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd intl zip

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Создание пользователя www
RUN addgroup -g 1000 www && adduser -u 1000 -G www -s /bin/sh -D www

# Установка рабочей директории
WORKDIR /var/www/html

# Копирование файлов приложения
COPY . /var/www/html

# Установка зависимостей
RUN  git config --global --add safe.directory /var/www/html
RUN composer update
RUN composer install --no-dev -o
RUN npm install && npm run build

# Настройка прав доступа
RUN chown -R www:www /var/www/html
RUN chmod -R 755 /var/www/html/storage
RUN chmod -R 755 /var/www/html/bootstrap/cache
RUN chown -R www:www /var/lib/nginx/

# Копирование конфигурации Nginx
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Копирование конфигурации Supervisor
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Создание директорий для логов
RUN mkdir -p /var/log/supervisor
RUN mkdir -p /var/log/nginx

# Открытие порта
EXPOSE 8000

# Запуск Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
