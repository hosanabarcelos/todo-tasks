#!/bin/sh
set -eu

if [ ! -f .env ]; then
  cp .env.example .env
fi

if [ ! -f database/database.sqlite ]; then
  touch database/database.sqlite
fi

if [ ! -d vendor ]; then
  composer install --no-interaction --prefer-dist
fi

php artisan key:generate --force
php artisan migrate --seed --force
php artisan serve --host=0.0.0.0 --port=8000
