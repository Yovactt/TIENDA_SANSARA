FROM php:8.1-apache

# Copiar los archivos del proyecto al contenedor
COPY . /var/www/html/

# Instalar dependencias necesarias para PostgreSQL y PHP extensions
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql mysqli

EXPOSE 80
