FROM php:8.1-apache

# Copiar archivos
COPY . /var/www/html/

# Asignar permisos
RUN chown -R www-data:www-data /var/www/html

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql mysqli

# Opcional: evitar advertencias de ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exponer puerto
EXPOSE 80
