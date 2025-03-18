<?php

namespace App\Filament\Panels\Moderator\Clusters\Personal\Resources;

use App\Filament\Clusters\Requests\Resources\InquiryResource as Resource;
use App\Filament\Panels\Moderator\Clusters\Personal;
use App\Filament\Panels\Moderator\Clusters\Personal\Resources\RequestResource\Pages\ListInquiries;
use App\Filament\Panels\Moderator\Clusters\Personal\Resources\RequestResource\Pages\NewInquiry;

class InquiryResource extends Resource
{
    public static ?bool $inbound = null;

    protected static ?string $cluster = Personal::class;

    public static function getPages(): array
    {
        return [
            'index' => ListInquiries::route('/'),
            'new' => NewInquiry::route('new/{record}'),
        ];
    }
}
