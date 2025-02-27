<?php

namespace App\Filament\Panels\Admin\Clusters\Organization\Resources\CategoryResource\Pages;

use App\Filament\Clusters\Management\Resources\CategoryResource\Pages\ListCategories as Categories;
use App\Filament\Panels\Admin\Clusters\Organization\Resources\CategoryResource;

class ListCategories extends Categories
{
    protected static string $resource = CategoryResource::class;
}
