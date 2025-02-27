<?php

namespace App\Filament\Panels\Root\Clusters\Management\Resources\CategoryResource\Pages;

use App\Filament\Clusters\Management\Resources\CategoryResource\Pages\ListCategories as Categories;
use App\Filament\Panels\Root\Clusters\Management\Resources\CategoryResource;

class ListCategories extends Categories
{
    protected static string $resource = CategoryResource::class;
}
