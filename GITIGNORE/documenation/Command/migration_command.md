php artisan migrate

php artisan make:migration create_flights_table

php artisan make:migration add_role_to_users_table --table=users

php artisan migrate:status

`php artisan migrate --pretend` - see the SQL statements without actually running them

php artisan migrate --force

`php artisan migrate:rollback` - roll back all migrations and then execute the migrate command

php artisan migrate:rollback --step=5

`php artisan migrate:reset` roll back all of your application's migrations

php artisan migrate:refresh

`php artisan migrate:refresh --seed` - Refresh the database and run all database seeds

####  drop all tables from the database and then execute the migrate command
php artisan migrate:fresh
php artisan migrate:fresh --seed
php artisan migrate:fresh --database=admin

php artisan make:seeder UserSeeder
php artisan db:seed
php artisan db:seed --class=UserSeeder
