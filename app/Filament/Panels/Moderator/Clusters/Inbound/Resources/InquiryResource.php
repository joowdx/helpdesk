<?php

namespace App\Filament\Panels\Moderator\Clusters\Inbound\Resources;

use App\Filament\Clusters\Requests\Resources\InquiryResource as Resource;
use App\Filament\Panels\Moderator\Clusters\Inbound;
use App\Filament\Panels\Moderator\Clusters\Inbound\Resources\RequestResource\Pages\ListInquiries;
use App\Filament\Panels\Moderator\Clusters\Inbound\Resources\RequestResource\Pages\NewInquiry;

class InquiryResource extends Resource
{
    protected static ?string $cluster = Inbound::class;

    public static function getPages(): array
    {
        return [
            'index' => ListInquiries::route('/'),
            'new' => NewInquiry::route('new/{record}'),
        ];
    }
}
