FROM php:8.2.35-apache

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

ENV APACHE_DOCUMENT_ROOT=/var/www/html/webroot \
    DEBUG=false
WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        libcurl4-openssl-dev \
        libicu-dev \
        libonig-dev \
        unzip \
    && docker-php-ext-install -j"$(nproc)" curl intl mbstring opcache pdo_mysql \
    && a2enmod headers rewrite \
    && sed -ri "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf \
    && sed -ri '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf \
    && rm -rf /var/lib/apt/lists/*

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --no-scripts \
    --no-autoloader

COPY . .

RUN composer dump-autoload --no-dev --no-interaction --no-scripts --classmap-authoritative \
    && cp config/app.default.php config/app.php \
    && mkdir -p logs tmp/cache tmp/sessions \
    && chown -R www-data:www-data logs tmp

EXPOSE 80

HEALTHCHECK --interval=10s --timeout=5s --start-period=20s --retries=6 \
    CMD curl --fail --silent http://127.0.0.1/ || exit 1
