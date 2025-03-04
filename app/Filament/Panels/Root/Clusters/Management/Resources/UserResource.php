<?php

namespace App\Filament\Panels\Root\Clusters\Management\Resources;

use App\Filament\Clusters\Management\Resources\UserResource as Resource;
use App\Filament\Panels\Root\Clusters\Management;
use App\Filament\Panels\Root\Clusters\Management\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $cluster = Management::class;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
