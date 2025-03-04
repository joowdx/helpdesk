<?php

namespace App\Filament\Panels\Admin\Clusters\Organization\Resources;

use App\Filament\Clusters\Management\Resources\CategoryResource as Resource;
use App\Filament\Panels\Admin\Clusters\Organization;
use App\Filament\Panels\Admin\Clusters\Organization\Resources\CategoryResource\Pages;

class CategoryResource extends Resource
{
    protected static ?string $cluster = Organization::class;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'subcategories' => Pages\ListSubcategories::route('/{record}/subcategories'),
        ];
    }
}
