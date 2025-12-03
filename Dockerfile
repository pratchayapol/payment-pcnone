FROM php:8.2-fpm

# ติดตั้ง dependencies ที่จำเป็น
RUN apt-get update && apt-get install -y \
    git curl zip unzip nodejs npm libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring tokenizer dom \
    && rm -rf /var/lib/apt/lists/*

# ติดตั้ง Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# ตั้ง working directory
WORKDIR /var/www

# สร้างโฟลเดอร์ storage และ bootstrap/cache พร้อมสิทธิ์
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache
