FROM php:8.2-apache

# Instala a extensão mysqli
RUN docker-php-ext-install mysqli

# Instalar pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql

COPY . /var/www/html/
EXPOSE 80