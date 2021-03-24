# Very Lightweighted Lumen Skeleton for old PHP >=5.6.4 to 7.0.x

Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](http://lumen.laravel.com/docs).

## Security Vulnerabilities

If you discover a security vulnerability within Lumen, please send an e-mail to Fajar Firmansyah at mail.firmansyah93@gmail.com. All security vulnerabilities will be promptly addressed.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)


## Customized Files

- routes/web.php
- bootstrap/app.php
- Http/Controllers/CrudController.php
- Http/Controllers/UserController.php
- Http/Controllers/MailController.php
- app/Http/Middleware/Authenticate.php
- app/Providers/AuthServiceProvider.php
- database/migrations/users
- .htaccess

## Default Migrations
- oauth_user
- oauth_user_token
- oauth_sent_mail

## Routes
### Unauthorized Routes
- GET : /
- POST : /login

### Authorized Routes
- GET : /logout
- GET : /user
- GET : /v1
- GET,POST : /v1/{table_name}
- GET,PUT,PATCH,DELETE : /v1/{table_name}/{id}

## Deploying Steps and Usage

- clone this repo or use ```composer create-project as usual```
- php composer.phar install
- php artisan migrate --path=database/migrations/users
- Create your own tables by using artisan migration tools or DDL Queries directly and ensure you add three these columns: id, created_at and updated_at and try to make some CRUD operations
- use api client such as POSTMAN and enjoy your restful-api server!


## On Going Next Steps

- Table Relationships Auto-Detection
- Collaborating between persistent layer (DAL) and Domain Layer (Business Logic)