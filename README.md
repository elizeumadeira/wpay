# WPay back
To start this project, first the DataBase should be initialized. 
Copy ".end.example" and rename to ".env";

Fill the variables DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD with the values of your database
There are two ways to run this project locally: using artisan (php built-in server) or using docker (docker-compose.yml addedd to ease the process).

## IMPORTANT NOTE!
The Cron task will only work using docker deploy option.

Init vendor

    composer i

## Running using artisan


    php artisan serve

Project will start in http://localhost:8000

## Running using docker compose


    docker-compose build
    docker-compose up

Project will start in http://localhost:8096
