<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;
use Filament\Facades\Filament;

class Outgoing extends Cluster
{
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'gmdi-outbound-o';

    public static function canAccess(): bool
    {
        return in_array(Filament::getCurrentPanel()->getId(), ['admin', 'moderator']);
    }
}
