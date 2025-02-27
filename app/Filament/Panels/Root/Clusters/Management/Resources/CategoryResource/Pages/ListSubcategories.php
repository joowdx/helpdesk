<?php

namespace App\Filament\Panels\Root\Clusters\Management\Resources\CategoryResource\Pages;

use App\Filament\Clusters\Management\Resources\CategoryResource\Pages\ListSubcategories as Subcategories;
use App\Filament\Panels\Root\Clusters\Management\Resources\CategoryResource;

class ListSubcategories extends Subcategories
{
    protected static string $resource = CategoryResource::class;
}
