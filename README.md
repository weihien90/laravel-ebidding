Sample Bidding application built with Laravel 6, including following packages:
- Laravel Websockets
- Laravel VueJS & Bootstrap presets

## Quickstart (local)

1. Setup
```
$ composer install
$ npm install
$ php artisan key:generate
```
2. Copy .env.example to .env and update the database credentials
3. Run Database migration
```
$ php artisan migration
```
4. Generate test dataset
```
$ php artisan db:seed
```
5. Compile frontend assets
```
$ npm run dev
```
5. Start Websocket server
```
$ php artisan websocket:serve
```
6. Start Laravel server
```
$ php artisan serve
```
7. Access on http://127.0.0.1:8000/
