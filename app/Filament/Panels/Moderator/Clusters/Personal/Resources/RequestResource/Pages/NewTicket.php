<?php

namespace App\Filament\Panels\Moderator\Clusters\Personal\Resources\RequestResource\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\NewTicket as Create;
use App\Filament\Panels\Moderator\Clusters\Personal\Resources\TicketResource;

class NewTicket extends Create
{
    protected static string $resource = TicketResource::class;
}
