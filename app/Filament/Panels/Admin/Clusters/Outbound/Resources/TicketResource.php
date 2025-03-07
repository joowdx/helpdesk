<?php

namespace App\Filament\Panels\Admin\Clusters\Outbound\Resources;

use App\Filament\Clusters\Requests\Resources\TicketResource as Resource;
use App\Filament\Panels\Admin\Clusters\Outbound;
use App\Filament\Panels\Admin\Clusters\Outbound\Resources\RequestResource\Pages\Tickets;

class TicketResource extends Resource
{
    protected static ?string $cluster = Outbound::class;

    protected static bool $inbound = false;

    public static function getPages(): array
    {
        return [
            'index' => Tickets::route('/'),
        ];
    }
}
