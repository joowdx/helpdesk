<?php

namespace App\Filament\Panels\Moderator\Clusters\Inbound\Resources;

use App\Filament\Clusters\Requests\Resources\SuggestionResource as Resource;
use App\Filament\Panels\Moderator\Clusters\Inbound;
use App\Filament\Panels\Moderator\Clusters\Inbound\Resources\RequestResource\Pages\ListSuggestions;
use App\Filament\Panels\Moderator\Clusters\Inbound\Resources\RequestResource\Pages\NewSuggestion;

class SuggestionResource extends Resource
{
    protected static ?string $cluster = Inbound::class;

    public static function getPages(): array
    {
        return [
            'index' => ListSuggestions::route('/'),
            'new' => NewSuggestion::route('new/{record}'),
        ];
    }
}
