#!/bin/sh
php artisan key:generate
php artisan config:cache
php artisan migrate
php artisan storage:link
php-fpm
