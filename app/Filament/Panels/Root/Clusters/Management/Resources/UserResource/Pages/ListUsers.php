<?php

namespace App\Filament\Panels\Root\Clusters\Management\Resources\UserResource\Pages;

use App\Filament\Clusters\Management\Resources\UserResource\Pages\ListUsers as ListAccounts;
use App\Filament\Panels\Root\Clusters\Management\Resources\UserResource;

class ListUsers extends ListAccounts
{
    protected static string $resource = UserResource::class;
}
