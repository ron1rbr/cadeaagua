FROM php:8.3-fpm

ARG UID=1000
ARG GID=1000

RUN groupadd -g ${GID} roni \
    && useradd -u ${UID} -g roni -m roni

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev gnupg ca-certificates \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN docker-php-ext-install pdo_mysql pdo_pgsql pgsql mbstring zip exif pcntl gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

USER roni

CMD ["php-fpm"]
