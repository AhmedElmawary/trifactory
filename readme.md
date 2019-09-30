##### The Trifactory

The TriFactory LLC is an Egyptian sports management company specialising in triathlon, endurance sports, and mass participation sports events.

# installation
### Note
Note that this guide assumes that you installed the following in your computer:-
1. PHP and mysql
2. composer
3. git

### Cloning
1. type `git clone https://gitlab.com/breadcrumbsegypt/thetrifactory.com.git`
2. navigate to the project directory and type `composer install`

### Confuguring .env file
1. type `cp .env.example .env`
2. then type `php artisan key:generate` 

### API Notes
1. application/json is needed in the accept header to return json

### Implementation and Testing of Authentication APIs
https://www.toptal.com/laravel/restful-laravel-api-tutorial

### JWT API Authentication
https://blog.pusher.com/build-rest-api-laravel-api-resources/

### Nova install and optional publish
php artisan nova:install
php artisan nova:publish

### Nova Docs
https://nova.laravel.com/docs/1.0/installation.html#installing-nova

### Production changes
run `composer install --no-dev`
or add `laravel/dusk` in composer.json extra/laravel/dont-discover

### Video Explaination for Laravel Nova
https://laracasts.com/series/laravel-nova-mastery/

### Using Maatwebsite for Nova Excel Export
https://github.com/Maatwebsite/Laravel-Nova-Excel 

### Docker Commands
docker run -p 3306:3306 --name thetrifactory -e MYSQL_ROOT_PASSWORD=root -d mysql:latest