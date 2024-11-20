php artisan make:event OrderShipped

php artisan make:listener SendShipmentNotification --event=OrderShipped

php artisan event:list
