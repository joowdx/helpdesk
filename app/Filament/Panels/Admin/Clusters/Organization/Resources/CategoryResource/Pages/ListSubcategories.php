<?php

namespace App\Filament\Panels\Admin\Clusters\Organization\Resources\CategoryResource\Pages;

use App\Filament\Clusters\Management\Resources\CategoryResource\Pages\ListSubcategories as Subcategories;
use App\Filament\Panels\Admin\Clusters\Organization\Resources\CategoryResource;

class ListSubcategories extends Subcategories
{
    protected static string $resource = CategoryResource::class;
}
