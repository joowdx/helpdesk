<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;
use Filament\Facades\Filament;
use Illuminate\Contracts\Support\Htmlable;

class Requests extends Cluster
{
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'gmdi-move-to-inbox-o';

    public static function canAccess(): bool
    {
        return in_array(Filament::getCurrentPanel()->getId(), ['root', 'admin', 'moderator', 'agents']);
    }

    public static function getNavigationLabel(): string
    {
        return Filament::getCurrentPanel()->getId() === 'root' ? 'Requests' : parent::getNavigationLabel();
    }

    public static function getClusterBreadcrumb(): ?string
    {
        return static::getNavigationLabel();
    }

    public static function getNavigationIcon(): string | Htmlable | null
    {
        return Filament::getCurrentPanel()->getId() === 'root' ? 'heroicon-o-lifebuoy' : static::$navigationIcon;
    }
}
