<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
/*
Schedule::command(\App\Console\Commands\SendEmailsCommand::class, ['Iman'])
    ->everyTenSeconds()()->withoutOverlapping(5)->runInBackground()->onOneServer()
    ->before(function () {
        // The task is about to execute...
    })
    ->after(function () {
        // The task has executed...
    })
    ->onSuccess(function () {
        // The task succeeded...
    })
    ->onFailure(function () {
        // The task failed...
    })
;
*/
//->evenInMaintenanceMode()
// ->appendOutputTo()->emailOutputOnFailure()
