<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('savings:run-auto')->daily();
Schedule::command('invitations:cleanup --step=expire')->hourly();
Schedule::command('invitations:cleanup --step=trash')->everyThirtyMinutes();
Schedule::command('invitations:cleanup --step=delete')->everyThirtyMinutes();
Schedule::command('invitations:cleanup --step=retry')->daily();
