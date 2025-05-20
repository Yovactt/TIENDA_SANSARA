FROM php:8.1-apache

# Copiar los archivos del proyecto al contenedor
COPY . /var/www/html/

# Instalar extensiones necesarias para MariaDB
RUN docker-php-ext-install mysqli

EXPOSE 80