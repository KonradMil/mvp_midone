#DBR77 System - installation guide

##Requirements
System requirements description is not ready yet.

##Run with Docker

1. In the project root directory run following commands:


    $ cp .env.example .env
    $ sudo docker-compose up -d
    $ sudo docker exec -it php_dbr77 bash
    # composer install
    # php artisan key:generate
    # php artisan migrate
    # exit

## Laravel Vue SPA, Auth & CRUD
Using Laravel and Vue.js 3, we are going to create a single page application. We will learn who to create, read, update, delete and auth using Vue 3 and Laravel API backend.

## Tutorial Link
[Laravel SPA with Vue 3, Auth (Sanctum), CRUD Example](https://shouts.dev/laravel-spa-with-vue3-auth-crud-example)

## Output
![laravel-spa-vue3-auth-crud](https://user-images.githubusercontent.com/13184472/106253536-cefcc380-6241-11eb-9b21-ea12a283be27.gif)

## LICENCE
You can download the project, modify the code and use it anywhere you want without re-posting on any blog. Happy Coding :)

Thank you.
