#!/bin/sh

echo "⏳ En attente de PostgreSQL..."
while ! nc -z postgres 5432; do
  echo "❌ PostgreSQL n'est pas encore prêt..."
  sleep 1
done
echo "✅ PostgreSQL est prêt !"

php bin/console doctrine:migrations:migrate --no-interaction
php bin/console lexik:jwt:generate-keypair

exec "$@"