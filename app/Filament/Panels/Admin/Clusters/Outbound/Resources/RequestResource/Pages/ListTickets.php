<?php

namespace App\Filament\Panels\Admin\Clusters\Outbound\Resources\RequestResource\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListTickets as Index;
use App\Filament\Panels\Admin\Clusters\Outbound\Resources\TicketResource;

class ListTickets extends Index
{
    protected static string $resource = TicketResource::class;
}
