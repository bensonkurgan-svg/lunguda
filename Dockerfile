# syntax=docker/dockerfile:1

# ---------- Stage 1: build front-end assets with Vite ----------
FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json vite.config.js tailwind.config.js postcss.config.js ./
RUN npm ci
# Tailwind scans views + Livewire PHP for class names, so copy those too.
COPY resources ./resources
COPY app ./app
RUN npm run build

# ---------- Stage 2: PHP runtime (nginx + php-fpm) ----------
# serversideup/php is purpose-built for Laravel on platforms like Railway:
# it bundles nginx + php-fpm, runs as a non-root user, and honours $PORT.
FROM serversideup/php:8.3-fpm-nginx

USER root
WORKDIR /var/www/html

# App source
COPY --chown=www-data:www-data . .
# Built assets from stage 1
COPY --chown=www-data:www-data --from=assets /app/public/build ./public/build

# PHP dependencies (production only)
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts \
    && composer dump-autoload --optimize

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

USER www-data

# Let the image run Laravel housekeeping automatically on boot:
# storage:link, run migrations, and cache config/routes/views.
ENV AUTORUN_ENABLED=true \
    AUTORUN_LARAVEL_STORAGE_LINK=true \
    AUTORUN_LARAVEL_MIGRATION=true \
    AUTORUN_LARAVEL_CONFIG_CACHE=true \
    AUTORUN_LARAVEL_ROUTE_CACHE=true \
    AUTORUN_LARAVEL_VIEW_CACHE=true \
    PHP_OPCACHE_ENABLE=1 \
    SSL_MODE=off
