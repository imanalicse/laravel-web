php artisan storage:link
 INFO  The [public\storage] link has been connected to [storage\app/public].

php artisan serve --port=8080

php artisan migrate

php artisan make:migration create_flights_table

php artisan make:migration add_role_to_users_table --table=users

php artisan migrate:status

php artisan migrate --pretend 
php artisan migrate --force

php artisan migrate:rollback
php artisan migrate:rollback --step=5
php artisan migrate:reset

php artisan migrate:refresh
# Refresh the database and run all database seeds...
php artisan migrate:refresh --seed

php artisan migrate:fresh
php artisan migrate:fresh --seed

php artisan make:seeder UserSeeder
php artisan db:seed
php artisan db:seed --class=UserSeeder

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
