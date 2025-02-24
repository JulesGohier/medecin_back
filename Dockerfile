FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
git \
zip \
unzip \
libpq-dev \
netcat-openbsd

RUN docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://get.symfony.com/cli/installer | bash \
&& mv ~/.symfony5/bin/symfony /usr/local/bin/symfony

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/symfony/

COPY ./symfony/ /var/www/symfony/

RUN chmod +x /var/www/symfony/entrypoint.sh
RUN composer install

RUN chown -R www-data:www-data var/ \
&& chmod -R 777 var/

EXPOSE 9000

ENTRYPOINT ["/var/www/symfony/entrypoint.sh"]
CMD ["symfony", "serve", "--port=9000", "--allow-http", "--listen-ip=0.0.0.0"]
