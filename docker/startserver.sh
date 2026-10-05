#!/bin/sh
set -e
export APP_KEY="${APP_KEY:-$(php artisan key:generate --show)}"
php artisan migrate --force --seed
exec php artisan serve --host=0.0.0.0 --port=80
