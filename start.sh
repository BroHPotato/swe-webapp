#!/bin/sh

echo "Web application starting..."

if [ ! -d "vendor/" ]; then
	composer install
fi

if [ ! -d "node_modules/" ]; then
	npm install
fi

npm run dev

php artisan serve --host=0.0.0.0 --port=8000
