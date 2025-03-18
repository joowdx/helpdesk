<?php

namespace App\Filament\Panels\Moderator\Clusters\Inbound\Resources;

use App\Filament\Clusters\Requests\Resources\TicketResource as Resource;
use App\Filament\Panels\Moderator\Clusters\Inbound;
use App\Filament\Panels\Moderator\Clusters\Inbound\Resources\RequestResource\Pages\ListTickets;
use App\Filament\Panels\Moderator\Clusters\Inbound\Resources\RequestResource\Pages\NewTicket;

class TicketResource extends Resource
{
    protected static ?string $cluster = Inbound::class;

    public static function getPages(): array
    {
        return [
            'index' => ListTickets::route('/'),
            'new' => NewTicket::route('new/{record}'),
        ];
    }
}
