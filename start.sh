#!/bin/sh

apk add composer

composer install

npm install

npm run dev

php artisan serve

echo "Web application started..."
