<?php

namespace App\Filament\Panels\Moderator\Clusters\Outbound\Resources;

use App\Filament\Clusters\Requests\Resources\InquiryResource as Resource;
use App\Filament\Panels\Moderator\Clusters\Outbound;
use App\Filament\Panels\Moderator\Clusters\Outbound\Resources\RequestResource\Pages\ListInquiries;
use App\Filament\Panels\Moderator\Clusters\Outbound\Resources\RequestResource\Pages\NewInquiry;

class InquiryResource extends Resource
{
    public static ?bool $inbound = false;

    protected static ?string $cluster = Outbound::class;

    public static function getPages(): array
    {
        return [
            'index' => ListInquiries::route('/'),
            'new' => NewInquiry::route('new/{record}'),
        ];
    }
}
