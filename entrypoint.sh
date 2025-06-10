#!/bin/bash

php artisan migrate --force

php artisan key:generate

php artisan kafka:create-doctor-consumer &
php artisan kafka:update-doctor-consumer &
php artisan kafka:delete-doctor-consumer &

php artisan kafka:create-doctor-availability-consumer &

apache2-foreground
