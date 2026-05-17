# Menggunakan image PHP 8.2 dengan Apache
FROM php:8.2-apache

# Menginstal ekstensi server yang dibutuhkan Laravel dan PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_pgsql pgsql zip

# Mengaktifkan mod_rewrite pada Apache agar routing Laravel berjalan lancar
RUN a2enmod rewrite

# Mengubah document root Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Menyalin seluruh file proyek Laravel ke dalam server Render
COPY . /var/www/html

# Menginstal Composer dan dependencies Laravel
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Memberikan akses tulis (permission) pada folder cache dan storage Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
