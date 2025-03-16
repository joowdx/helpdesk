<?php

namespace App\Filament\Panels\Moderator\Clusters\Requests\Resources;

use App\Filament\Clusters\Requests\Resources\InquiryResource as Resource;
use App\Filament\Panels\Moderator\Clusters\Requests;
use App\Filament\Panels\Moderator\Clusters\Requests\Pages\ListInquiries;
use App\Filament\Panels\Moderator\Clusters\Requests\Pages\NewInquiry;

class InquiryResource extends Resource
{
    protected static ?string $cluster = Requests::class;

    public static function getPages(): array
    {
        return [
            'index' => ListInquiries::route('/'),
            'new' => NewInquiry::route('new/{record}'),
        ];
    }
}
