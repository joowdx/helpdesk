<?php

namespace App\Filament\Panels\Agent\Clusters\Requests\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListTickets;
use App\Filament\Panels\Agent\Clusters\Requests\Resources\TicketResource;

class Tickets extends ListTickets
{
    protected static string $resource = TicketResource::class;
}
