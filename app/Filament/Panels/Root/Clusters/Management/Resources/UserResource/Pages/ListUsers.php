<?php

namespace App\Filament\Panels\Root\Clusters\Management\Resources\UserResource\Pages;

use App\Filament\Clusters\Management\Resources\UserResource\Pages\ListUsers as Accounts;
use App\Filament\Panels\Root\Clusters\Management\Resources\UserResource;

class ListUsers extends Accounts
{
    protected static string $resource = UserResource::class;
}
