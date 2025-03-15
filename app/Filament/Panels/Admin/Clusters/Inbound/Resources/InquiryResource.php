<?php

namespace App\Filament\Panels\Admin\Clusters\Inbound\Resources;

use App\Filament\Clusters\Requests\Resources\InquiryResource as Resource;
use App\Filament\Panels\Admin\Clusters\Inbound;
use App\Filament\Panels\Admin\Clusters\Inbound\Resources\RequestResource\Pages\Inquiries;
use App\Filament\Panels\User\Resources\OrganizationResource\Pages\NewInquiry;

class InquiryResource extends Resource
{
    protected static ?string $cluster = Inbound::class;

    public static function getPages(): array
    {
        return [
            'index' => Inquiries::route('/'),
            'new' => NewInquiry::route('new/{record}'),
        ];
    }
}
