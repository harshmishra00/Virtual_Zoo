FROM php:8.4-apache

# 1. Install development packages and clean up apt cache
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    nodejs \
    npm \
    sqlite3 \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# 2. Enable Apache mod_rewrite
RUN a2enmod rewrite

# 3. Update Apache DocumentRoot to point to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}/!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Set working directory
WORKDIR /var/www/html

# 6. Copy existing application directory contents
COPY . .

# 7. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 8. Install Node dependencies and build frontend assets
RUN npm install && npm run build

# 9. Set up SQLite Database and Permissions
RUN touch database/database.sqlite \
    && php artisan migrate:fresh --seed --force \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache database

# 10. Final configuration
EXPOSE 80
CMD ["apache2-foreground"]
