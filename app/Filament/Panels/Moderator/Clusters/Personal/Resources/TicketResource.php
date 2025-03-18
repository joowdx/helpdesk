<?php

namespace App\Filament\Panels\Moderator\Clusters\Personal\Resources;

use App\Filament\Clusters\Requests\Resources\TicketResource as Resource;
use App\Filament\Panels\Moderator\Clusters\Personal;
use App\Filament\Panels\Moderator\Clusters\Personal\Resources\RequestResource\Pages\ListTickets;
use App\Filament\Panels\Moderator\Clusters\Personal\Resources\RequestResource\Pages\NewTicket;

class TicketResource extends Resource
{
    public static ?bool $inbound = null;

    protected static ?string $cluster = Personal::class;

    public static function getPages(): array
    {
        return [
            'index' => ListTickets::route('/'),
            'new' => NewTicket::route('new/{record}'),
        ];
    }
}
