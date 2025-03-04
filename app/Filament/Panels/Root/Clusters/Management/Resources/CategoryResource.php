<?php

namespace App\Filament\Panels\Root\Clusters\Management\Resources;

use App\Filament\Clusters\Management\Resources\CategoryResource as Resource;
use App\Filament\Panels\Root\Clusters\Management;
use App\Filament\Panels\Root\Clusters\Management\Resources\CategoryResource\Pages;

class CategoryResource extends Resource
{
    protected static ?string $cluster = Management::class;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'subcategories' => Pages\ListSubcategories::route('/{record}/subcategories'),
        ];
    }
}
