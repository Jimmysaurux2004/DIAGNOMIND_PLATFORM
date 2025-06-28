FROM php:8.2-apache

# Instala extensiones de PHP necesarias para MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Instala SWI-Prolog
RUN apt-get update && apt-get install -y swi-prolog && rm -rf /var/lib/apt/lists/*

# Habilita mod_rewrite
RUN a2enmod rewrite

# Copia configuración de Apache ya modificada para puerto 90
COPY .docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Copia el código fuente
COPY . /var/www/html/

# Permisos correctos
RUN mkdir -p /var/www/html/logs && \
    chown -R www-data:www-data /var/www/html && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \;

# Expone el puerto 90
EXPOSE 90
