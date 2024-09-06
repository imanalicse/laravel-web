php artisan storage:link
 INFO  The [public\storage] link has been connected to [storage\app/public].

php artisan serve --port=8080

php artisan optimize

php artisan make:middleware EnsureTokenIsValid

php artisan make:controller PhotoController --resource
php artisan make:controller PhotoController --model=Photo --resource --requests
php artisan make:controller PhotoController --api
