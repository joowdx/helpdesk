<?php

namespace App\Filament\Panels\User\Clusters\Requests\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\NewTicket as Create;
use App\Filament\Panels\User\Clusters\Requests\Resources\TicketResource;

class NewTicket extends Create
{
    protected static string $resource = TicketResource::class;
}
