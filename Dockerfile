FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpq-dev \
    netcat-openbsd \
    cron

RUN docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/symfony/

COPY ./symfony/ /var/www/symfony/

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install
RUN chmod +x /var/www/symfony/entrypoint.sh

RUN chown -R www-data:www-data var/ \
    && chmod -R 777 var/

EXPOSE 9000

ENTRYPOINT ["/var/www/symfony/entrypoint.sh"]
CMD ["php-fpm"]