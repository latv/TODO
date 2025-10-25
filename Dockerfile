FROM php:8.3-fpm-alpine

ARG USER_ID=1000

RUN apk update && apk add --no-cache \
    git \
    curl \
    libxml2-dev \
    libzip-dev \
    pcre-dev \
    mysql-client \
    $PHPIZE_DEPS \
    && rm -rf /var/cache/apk/*

RUN docker-php-ext-install pdo pdo_mysql opcache zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer 

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-autoloader

COPY . .

RUN composer dump-autoload --optimize

RUN adduser -D -u ${USER_ID} appuser
RUN chown -R appuser:appuser /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

USER appuser

EXPOSE 9000

CMD ["php-fpm"]
