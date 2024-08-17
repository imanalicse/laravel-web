php artisan storage:link
 INFO  The [public\storage] link has been connected to [storage\app/public].

php artisan serve --port=8080

php artisan optimize

php artisan make:middleware EnsureTokenIsValid

php artisan route:list
php artisan make:controller PhotoController --resource
php artisan make:controller PhotoController --model=Photo --resource --requests
php artisan make:controller PhotoController --api

php artisan make:model Flight --seed --controller --resource --requests --policy --pivot

### Shortcut to generate a model, migration, factory, seeder, policy, controller, and form requests...
php artisan make:model Flight --all

### Inspecting Models
php artisan model:show Flight

# classed back component
php artisan make:component Alert
php artisan make:component Forms/Input
## anonymous component 
php artisan make:component forms.input --view
