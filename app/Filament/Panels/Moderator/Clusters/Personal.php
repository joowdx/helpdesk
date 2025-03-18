<?php

namespace App\Filament\Panels\Moderator\Clusters;

use Filament\Clusters\Cluster;

class Personal extends Cluster
{
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'gmdi-support-agent-o';
}
