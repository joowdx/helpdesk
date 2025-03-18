<?php

namespace App\Filament\Panels\Moderator\Clusters\Outbound\Resources;

use App\Filament\Clusters\Requests\Resources\SuggestionResource as Resource;
use App\Filament\Panels\Moderator\Clusters\Outbound;
use App\Filament\Panels\Moderator\Clusters\Outbound\Resources\RequestResource\Pages\ListSuggestions;
use App\Filament\Panels\Moderator\Clusters\Outbound\Resources\RequestResource\Pages\NewSuggestion;

class SuggestionResource extends Resource
{
    public static ?bool $inbound = false;

    protected static ?string $cluster = Outbound::class;

    public static function getPages(): array
    {
        return [
            'index' => ListSuggestions::route('/'),
            'new' => NewSuggestion::route('new/{record}'),
        ];
    }
}
