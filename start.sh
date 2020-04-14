#!/bin/sh

echo "Web application starting..."

composer install

npm install

npm run dev

php artisan serve --host=core.host.redroundrobin.site --port=8000


