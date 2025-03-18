<?php

namespace App\Filament\Panels\User\Clusters\Requests\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListTickets as Index;
use App\Filament\Panels\User\Clusters\Requests\Resources\TicketResource;

class ListTickets extends Index
{
    protected static string $resource = TicketResource::class;
}
