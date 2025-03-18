<?php

namespace App\Filament\Panels\Moderator\Clusters;

use Filament\Clusters\Cluster;

class Outbound extends Cluster
{
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'gmdi-outbound-o';
}
