#!/bin/sh

echo "⏳ En attente de PostgreSQL..."
while ! nc -z postgres 5432; do
  echo "❌ PostgreSQL n'est pas encore prêt..."
  sleep 1
done
echo "✅ PostgreSQL est prêt !"

composer install
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console lexik:jwt:generate-keypair

echo "Europe/Paris" > /etc/timezone
ln -sf /usr/share/zoneinfo/Europe/Paris /etc/localtime

service cron start

echo "1,31 8-19 * * * /usr/local/bin/php /var/www/symfony/bin/console app:update-past-appointments >> /var/log/cron.log 2>&1" | crontab

exec "$@"