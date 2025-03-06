<?php

namespace App\Filament\Panels\Admin\Clusters\Outbound\Resources\RequestResource\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListTickets;
use App\Filament\Panels\Admin\Clusters\Outbound\Resources\TicketResource;

class Tickets extends ListTickets
{
    protected static string $resource = TicketResource::class;
}
