# GamersPortal

## Install
- git clone
- create database
- copy .env.example .env
- edit .env and fill database information
- composer install
- php artisan key:generate
- php artisan db:migrate

## Changes
illuminate/html needed to be replaced by laravelcollective/html
needed to add doctrine/dbal to rename columns / tables