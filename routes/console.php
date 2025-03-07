<?php

use App\Console\Commands\AutoQueueRequestsCommand as QueueRequestsCommand;
use App\Console\Commands\AutoResolveCompletedRequestsCommand as ResolveRequestsCommand;
use Illuminate\Support\Facades\Schedule;
use Laravel\Telescope\Console\PruneCommand as TelescopePruneCommand;

Schedule::command(QueueRequestsCommand::class)->withoutOverlapping()->everyFifteenSeconds();

Schedule::command(ResolveRequestsCommand::class)->withoutOverlapping()->hourly();

Schedule::command(TelescopePruneCommand::class)->everySixHours();
