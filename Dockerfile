FROM composer:2 AS vendor
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

FROM node:20-alpine AS frontend
WORKDIR /app

COPY package.json ./
RUN npm install

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
RUN npm run build

FROM php:8.2-cli-alpine AS app
WORKDIR /var/www/html

RUN apk add --no-cache \
    bash \
    curl \
    icu-dev \
    libzip-dev \
    oniguruma-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        exif \
        gd \
        intl \
        mbstring \
        opcache \
        pcntl \
        pdo_mysql \
        zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps \
    && rm -rf /tmp/pear

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

RUN mkdir -p storage/framework/{cache,sessions,testing,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV PORT=8080

EXPOSE 8080

CMD ["sh", "-c", "php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan event:clear && php artisan optimize && ([ -L public/storage ] || php artisan storage:link) && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
