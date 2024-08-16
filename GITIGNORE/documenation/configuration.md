php artisan about

php artisan about --only=environment

#### apply config cache
php artisan config:cache

#### Remove config cache
php artisan config:clear

#### Configuration Publishing
php artisan config:publish

php artisan config:publish --all

#### Maintenance Mode
`php artisan down`

`php artisan up`

#### Bypassing Maintenance Mode
`php artisan down --secret="1630542a-246b-4b66-afa1-abc"`

http://localhost:8000/1630542a-246b-4b66-afa1-abc
