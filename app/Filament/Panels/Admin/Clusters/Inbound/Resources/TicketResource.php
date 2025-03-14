<?php

namespace App\Filament\Panels\Admin\Clusters\Inbound\Resources;

use App\Filament\Clusters\Requests\Resources\TicketResource as Resource;
use App\Filament\Panels\Admin\Clusters\Inbound;
use App\Filament\Panels\Admin\Clusters\Inbound\Resources\RequestResource\Pages\Tickets;
use App\Filament\Panels\User\Resources\OrganizationResource\Pages\NewTicket;

class TicketResource extends Resource
{
    protected static ?string $cluster = Inbound::class;

    public static function getPages(): array
    {
        return [
            'index' => Tickets::route('/'),
            'new' => NewTicket::route('new/{record}'),
        ];
    }
}
