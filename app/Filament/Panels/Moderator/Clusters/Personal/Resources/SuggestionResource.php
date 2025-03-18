<?php

namespace App\Filament\Panels\Moderator\Clusters\Personal\Resources;

use App\Filament\Clusters\Requests\Resources\SuggestionResource as Resource;
use App\Filament\Panels\Moderator\Clusters\Personal;
use App\Filament\Panels\Moderator\Clusters\Personal\Resources\RequestResource\Pages\ListSuggestions;
use App\Filament\Panels\Moderator\Clusters\Personal\Resources\RequestResource\Pages\NewSuggestion;

class SuggestionResource extends Resource
{
    public static ?bool $inbound = null;

    protected static ?string $cluster = Personal::class;

    public static function getPages(): array
    {
        return [
            'index' => ListSuggestions::route('/'),
            'new' => NewSuggestion::route('new/{record}'),
        ];
    }
}
