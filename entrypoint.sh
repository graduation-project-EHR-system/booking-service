#!/bin/bash

php artisan migrate --force

php artisan db:seed --force

php artisan key:generate

apache2-foreground
