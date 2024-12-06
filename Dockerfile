# Imagen base de PHP con Apache
FROM php:8.2.12-apache

# Instalar dependencias necesarias para Laravel
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libicu-dev \
    libxml2-dev \
    libpq-dev \
    vim \
    libzip-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo pdo_mysql zip intl soap opcache \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd

# Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# Cambiar el DocumentRoot para que apunte al directorio public de Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Instalar Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar Node.js (solo si es necesario para Laravel Mix)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && apt-get autoremove -y

# Copiar archivos del proyecto Laravel al contenedor
COPY . /var/www/html

# Establecer permisos para Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Ejecutar instalación de dependencias y configuración de Laravel
RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run build \
    && php artisan optimize \
    && php artisan storage:link

# Exponer el puerto 83 para acceder a la aplicación
EXPOSE 80

# Comando por defecto para iniciar Apache
CMD ["apache2-foreground"]