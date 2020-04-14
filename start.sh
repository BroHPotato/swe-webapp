#!/bin/sh

composer install

npm install

npm run dev

php artisan serve

echo "Web application started..."
