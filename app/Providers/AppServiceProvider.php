<?php

namespace App\Providers;

use Illuminate\Database\Connection;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       //  Route::pattern('id', '[0-9]+'); // this is global pattern - global validation

        Vite::macro('image', fn (string $asset) => $this->asset("resources/images/{$asset}"));
       //  Model::preventSilentlyDiscardingAttributes($this->app->isLocal()); // Mass Assignment Exceptions - local

        // Listening for Query Events
        DB::listen(function (QueryExecuted $query) {
            // $query->sql;
            // $query->bindings;
            // $query->time;
            // $query->toRawSql();
        });

        // Monitoring Cumulative Query Time
        DB::whenQueryingForLongerThan(500, function (Connection $connection, QueryExecuted $event) {
            // Notify development team...
            Log::info("Occurred_whenQueryingForLongerThan");
        });

        Paginator::useBootstrapFive();

        Blade::directive('datetime', function (string $expression) {
            return "<?php echo ($expression)->format('Y-m-d H:i:s'); ?>";
        });
    }
}
