<?php

namespace App\Filament\Panels\Admin\Clusters\Outbound\Resources;

use App\Filament\Clusters\Requests\Resources\TicketResource as Resource;
use App\Filament\Panels\Admin\Clusters\Outbound;
use App\Filament\Panels\Admin\Clusters\Outbound\Resources\RequestResource\Pages\ListTickets;

class TicketResource extends Resource
{
    public static ?bool $inbound = false;

    protected static ?string $cluster = Outbound::class;

    public static function getPages(): array
    {
        return [
            'index' => ListTickets::route('/'),
        ];
    }
}
