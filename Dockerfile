FROM php:8.2-fpm

RUN apt-get update \
 && apt-get install -y git unzip libicu-dev libzip-dev zip \
 && docker-php-ext-install intl pdo_mysql mysqli zip \
 && pecl install xdebug \
 && docker-php-ext-enable xdebug

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000
CMD ["php-fpm"]
