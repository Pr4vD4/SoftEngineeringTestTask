<h1>Installation</h1>


Clone the project

````cmd
git clone https://github.com/Pr4vD4/SoftEngineeringTestTask.git
````


Open the project and install requirements


````cmd
cd SoftEngineeringTestTask
````

````cmd
composer install
````

Generate secret key for laravel

````cmd
php artisan key:generate
````

Setup the .env file

````dotenv
#...
QUEUE_CONNECTION=database
#...

#...
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME= #your data
MAIL_PASSWORD= #your data
MAIL_FROM_ADDRESS= #your data
MAIL_FROM_NAME="${APP_NAME}"
#...
````

Migrate tables and fill them
````
php artisan migrate
php artisan db:seed
````

password for admin by default: *12345678*


