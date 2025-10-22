FROM php:8.3-fpm-alpine


ARG USER_ID=1000

RUN apk update && apk add \
    git \
    curl \
    libxml2-dev \
    libzip-dev \
    oniguruma-dev \
    $PHPIZE_DEPS \
    && rm -rf /var/cache/apk/*


RUN docker-php-ext-install pdo pdo_mysql opcache zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN adduser -D -u ${USER_ID} appuser

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --no-dev --optimize-autoloader

RUN chown -R appuser:appuser /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

USER appuser

EXPOSE 9000

CMD ["php-fpm"]