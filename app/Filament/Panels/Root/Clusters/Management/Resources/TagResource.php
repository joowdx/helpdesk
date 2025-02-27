<?php

namespace App\Filament\Panels\Root\Clusters\Management\Resources;

use App\Filament\Clusters\Management\Resources\TagResource as Resource;
use App\Filament\Panels\Root\Clusters\Management;
use App\Filament\Panels\Root\Clusters\Management\Resources\TagResource\Pages\ListTags;

class TagResource extends Resource
{
    protected static ?string $cluster = Management::class;

    public static function getPages(): array
    {
        return [
            'index' => ListTags::route('/'),
        ];
    }
}
