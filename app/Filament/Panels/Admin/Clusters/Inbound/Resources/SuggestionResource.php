<?php

namespace App\Filament\Panels\Admin\Clusters\Inbound\Resources;

use App\Filament\Clusters\Requests\Resources\SuggestionResource as Resource;
use App\Filament\Panels\Admin\Clusters\Inbound;
use App\Filament\Panels\Admin\Clusters\Inbound\Resources\RequestResource\Pages\Suggestions;
use App\Filament\Panels\User\Resources\OrganizationResource\Pages\NewSuggestion;

class SuggestionResource extends Resource
{
    protected static ?string $cluster = Inbound::class;

    public static function getPages(): array
    {
        return [
            'index' => Suggestions::route('/'),
            'new' => NewSuggestion::route('new/{record}'),
        ];
    }
}
