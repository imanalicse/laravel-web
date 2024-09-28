<?php
namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


trait DatabaseConfigurationTrait
{

    public function getOrganizationsDBConnection($database_and_table_prefix) {
        try {
            $this->customLog("database_and_table_prefix: ". $database_and_table_prefix,  'db_connection', 'db_connection');

            $database_and_table_prefix_arr = explode('.', $database_and_table_prefix);
            $database_name = $database_and_table_prefix_arr[0];
            $table_prefix = $database_and_table_prefix_arr[1];

            $config = [
                'driver' => 'mysql',
                'host' => env('UNIVERSITY_DB_HOST'),
                'port' => env('UNIVERSITY_DB_PORT', '3306'),
                'database' => $database_name,
                'username' => env('UNIVERSITY_DB_USERNAME'),
                'password' => env('UNIVERSITY_DB_PASSWORD'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => $table_prefix,
                'strict' => true,
                'engine' => null,
            ];

            $this->customLog("db_connection_config:",  'db_connection', 'db_connection');
            $this->customLog($config, 'db_connection', 'db_connection');

            // Purge any existing connection with the same name
            DB::purge('organizations');

            // Set up the new dynamic connection configuration
            config(['database.connections.organizations' => $config]);

            // Reconnect using the new dynamic connection
            DB::reconnect('organizations');

            // DB::connection('organizations');
        }
        catch (\Exception $exception) {
            $exception_line = $exception->getLine();
            $this->customLog("university_db_connection_error:$exception_line: ". $exception->getMessage(),  'db_connection_error', 'db_connection');
        }
    }
}
