<?php

use App\Console\Commands\AutoQueueRequestsCommand as QueueRequestsCommand;
use Illuminate\Support\Facades\Schedule;
use Laravel\Telescope\Console\PruneCommand as TelescopePruneCommand;

Schedule::command(QueueRequestsCommand::class)->withoutOverlapping()->everyFifteenSeconds();

Schedule::command(TelescopePruneCommand::class)->everySixHours();
