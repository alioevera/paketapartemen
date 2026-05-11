<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment('Testing');
})->purpose('Display an inspiring quote');

Schedule::command('paket:send-reminder')->dailyAt('08:00');