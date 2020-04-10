#!/bin/sh

npm update --dev

npm install

composer update

composer install

npm run dev

php artisan serve

echo "Web application started..."
