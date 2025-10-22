FROM php:8.3-fpm-alpine

# Set the non-root user ID variable
ARG USER_ID=1000

# 1. INSTALL SYSTEM DEPENDENCIES (CRITICAL for PHP extensions)
# We need libzip-dev, pcre-dev, and $PHPIZE_DEPS to compile extensions like zip and opcache.
RUN apk update && apk add --no-cache \
    git \
    curl \
    libxml2-dev \
    libzip-dev \
    pcre-dev \
    mysql-client \
    $PHPIZE_DEPS \
    && rm -rf /var/cache/apk/*

# 2. INSTALL PHP EXTENSIONS
RUN docker-php-ext-install pdo pdo_mysql opcache zip

# 3. INSTALL COMPOSER
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer 

# 4. SET UP WORKSPACE & COPY COMPOSER FILES
WORKDIR /var/www/html

COPY composer.json composer.lock ./

# 5. INSTALL PHP DEPENDENCIES (AS ROOT for permissions)
RUN composer install --no-dev --optimize-autoloader --no-autoloader

# 6. COPY APPLICATION CODE
COPY . .

# 7. DUMP AUTOLOAD
RUN composer dump-autoload --optimize

# 8. SET UP USER AND PERMISSIONS
RUN adduser -D -u ${USER_ID} appuser
RUN chown -R appuser:appuser /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# 9. SET USER & ENTRYPOINT
USER appuser

EXPOSE 9000

CMD ["php-fpm"]
