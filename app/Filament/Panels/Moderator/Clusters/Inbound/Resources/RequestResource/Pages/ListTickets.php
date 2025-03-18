<?php

namespace App\Filament\Panels\Moderator\Clusters\Inbound\Resources\RequestResource\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListTickets as Index;
use App\Filament\Panels\Moderator\Clusters\Inbound\Resources\TicketResource;

class ListTickets extends Index
{
    protected static string $resource = TicketResource::class;
}
