<?php

namespace App\Filament\Panels\User\Resources;

use App\Filament\Panels\User\Resources\OrganizationResource\Pages;
use App\Models\Organization;
use Filament\Resources\Resource;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;

    protected static ?string $slug = 'requests';

    protected static ?string $breadcrumb = 'Requests';

    protected static bool $shouldRegisterNavigation = false;

    public static function getPages(): array
    {
        return [
            'new.inquiry' => Pages\NewInquiry::route('new/inquiry/{record}'),
            'new.suggestion' => Pages\NewSuggestion::route('new/suggestion/{record}'),
            'new.ticket' => Pages\NewTicket::route('new/ticket/{record}'),
        ];
    }
}
