#!/bin/sh
set -e

mkdir -p /app/storage/app/public \
        /app/storage/framework/cache/data \
        /app/storage/framework/sessions \
        /app/storage/framework/views \
        /app/storage/logs

chown -R appuser:appgroup /app/storage
chmod -R 775 /app/storage

php artisan storage:link --force

#Run migrations with an isolated lock to prevent multi-container race conditions
php artisan migrate --isolated --no-interaction --force

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

exec "$@"

