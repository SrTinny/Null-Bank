FROM php:8.1-apache

RUN apt-get update && apt-get install -y libzip-dev unzip git zip && \
    docker-php-ext-install mysqli pdo pdo_mysql && \
    a2enmod rewrite

WORKDIR /var/www/html

# Copy . (mounted as volume in compose) and set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
