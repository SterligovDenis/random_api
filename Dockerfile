FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
curl \
libpng-dev \
libzip-dev

RUN docker-php-ext-install zip
RUN docker-php-ext-install gd
RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN useradd default_user
RUN chown -R default_user:www-data /var/www/html
RUN chmod -R 775 /var/www/html
USER default_user