<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Instalition
- composer update
- npm install
- edit .env file
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
- php artisan scribe:generate
- php artisan passport:install
- php artisan scribe:generate
## Api docs
you can show api docs: http://127.0.0.1:8000/docs
## For get Token
- url: http://127.0.0.1:8000/oauth/token
- method: POST
- body: 
 {
     "grant_type": "password",
     "client_id": 2,
     "client_secret": "sbvWnKPdU2PWTXeJkLIwpjljUgCmAXacWroUqLE5",
     "username": "admin123",
     "password": "admin123"
 }
