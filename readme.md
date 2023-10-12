
# GoTask challange

GoTask is a web application for tracking user tasks.
made with laravel and vuejs (vuetify)



## Create database
DB_HOST=127.0.0.1 \
DB_PORT=3306 \
DB_DATABASE=mytask \
DB_USERNAME=root \
DB_PASSWORD= 

## Installation Laravel (backend)

Make sure your have installed 
- Xamp or Wamp (php 8.1=<)
- Composer 

In project folder "laravel" run
```bash
  composer install
  php artisan migrate 
```
For test data run
```bash
  php artisan db:seed 
```
Start the application by run
```bash
  php artisan serve
```
port: localhost:8000
    
## Installation frontend

Make sure your have installed 
- Nodejs (v18) 
- yarn 
```
npm install --global yarn
```

In project folder "mytasks" run
```bash
  yarn install 
```
Start the application by run
```bash
  yarn run dev
```
port: localhost:3000
    