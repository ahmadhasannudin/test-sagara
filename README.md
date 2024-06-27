### Requirements
- redis : make sure you have redis for aynchronous process
- php 8.3

## Manual Installation
1. cp .env.example to .env , adjust the setting 
2. install dependencies
    ```bash
    composer install
    ```
3. generate key
    ```bash
    php artisan key:generate
    ```
4. run migration
    ```bash
    php artisan migrate
    ```
5. run database seeder
    ```bash
    php artisan db:seed
    ```
6. run the server 
    ```bash
    php artisan serve
    ```
7. run the queue worker
    ```bash
    php artisan queue:work
    ```
