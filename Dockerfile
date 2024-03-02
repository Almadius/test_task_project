# Используем официальный образ PHP с предустановленным FPM (FastCGI Process Manager)
FROM php:8.2-fpm

# Установка зависимостей для PHP и других инструментов
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Установка расширений PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка рабочей директории в контейнере
WORKDIR /var/www

# Копирование исходного кода приложения в контейнер
COPY . /var/www

# Установка зависимостей Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Очистка кэша apt-get для уменьшения размера образа
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Запуск PHP-FPM
CMD ["php-fpm"]

# Открытие порта 9000 для PHP-FPM
EXPOSE 9000
