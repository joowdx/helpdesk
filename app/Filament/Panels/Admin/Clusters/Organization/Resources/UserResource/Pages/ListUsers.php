<?php

namespace App\Filament\Panels\Admin\Clusters\Organization\Resources\UserResource\Pages;

use App\Filament\Clusters\Management\Resources\UserResource\Pages\ListUsers as Accounts;
use App\Filament\Panels\Admin\Clusters\Organization\Resources\UserResource;

class ListUsers extends Accounts
{
    protected static string $resource = UserResource::class;
}
