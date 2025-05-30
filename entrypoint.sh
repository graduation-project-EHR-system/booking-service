#!/bin/bash

php artisan migrate --force

php artisan db:seed --force

php artisan key:generate

php artisan kafka:create-doctor-consumer &

apache2-foreground
