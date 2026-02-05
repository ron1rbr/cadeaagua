### STAGE 1 - Build assets
FROM node:20-alpine AS node_build

WORKDIR /app
COPY package*.json .
RUN npm install
COPY resources ./resources
COPY vite.config.* .
RUN npm run build


### STAGE 2 - Build APP
FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    zip unzip git \
    && docker-php-ext-install pdo_pgsql pgsql mbstring zip exif pcntl gd bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

COPY --from=node_build /app/public/build /var/www/public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

RUN chmod +x docker/prod/entrypoint.sh

RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

ENTRYPOINT ["docker/prod/entrypoint.sh"]