<?php

namespace App\Filament\Panels\Admin\Clusters\Organization\Resources;

use App\Filament\Clusters\Management\Resources\TagResource as Resource;
use App\Filament\Panels\Admin\Clusters\Organization;
use App\Filament\Panels\Admin\Clusters\Organization\Resources\TagResource\Pages;

class TagResource extends Resource
{
    protected static ?string $cluster = Organization::class;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTags::route('/'),
        ];
    }
}
