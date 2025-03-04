<?php

namespace App\Filament\Panels\Admin\Clusters\Organization\Resources\TagResource\Pages;

use App\Filament\Clusters\Management\Resources\TagResource\Pages\ListTags as Tags;
use App\Filament\Panels\Admin\Clusters\Organization\Resources\TagResource;

class ListTags extends Tags
{
    protected static string $resource = TagResource::class;
}
