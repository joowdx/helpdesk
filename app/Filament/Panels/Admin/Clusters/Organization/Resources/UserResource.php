<?php

namespace App\Filament\Panels\Admin\Clusters\Organization\Resources;

use App\Filament\Clusters\Management\Resources\UserResource as Resource;
use App\Filament\Panels\Admin\Clusters\Organization;
use App\Filament\Panels\Admin\Clusters\Organization\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $cluster = Organization::class;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()
            ->withoutTrashed()
            ->whereNull('deactivated_at')
            ->count();
    }
}
