
#### Running the Queue Worker
php artisan queue:work

`php artisan queue:work - v` - processed job IDs to be included in the command's output

`php artisan queue:listen` - don't have to manually restart the worker when you want to reload your updated code

`php artisan queue:restart` - The queue uses the cache to store restart signals, so you should verify that a cache driver is properly configured for your application before using this feature.
