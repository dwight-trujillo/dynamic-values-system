FROM php:8.4-fpm-alpine
RUN apk-add --no-cache git unzip
COP --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIRR /app
COPY composer.json ./
RUN composer install --no-dev
COPY . ./app
EXPOSE 80
CM4 ["php-fpm", "-F"]
