<?php

namespace App\Filament\Panels\Moderator\Clusters\Requests\Resources;

use App\Filament\Clusters\Requests\Resources\TicketResource as Resource;
use App\Filament\Panels\Moderator\Clusters\Requests;
use App\Filament\Panels\Moderator\Clusters\Requests\Pages\ListTickets;
use App\Filament\Panels\Moderator\Clusters\Requests\Pages\NewTicket;

class TicketResource extends Resource
{
    protected static ?string $cluster = Requests::class;

    public static function getPages(): array
    {
        return [
            'index' => ListTickets::route('/'),
            'new' => NewTicket::route('new/{record}'),
        ];
    }
}
