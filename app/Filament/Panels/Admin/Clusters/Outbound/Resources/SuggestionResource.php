<?php

namespace App\Filament\Panels\Admin\Clusters\Outbound\Resources;

use App\Filament\Clusters\Requests\Resources\SuggestionResource as Resource;
use App\Filament\Panels\Admin\Clusters\Outbound;
use App\Filament\Panels\Admin\Clusters\Outbound\Resources\RequestResource\Pages\Suggestions;

class SuggestionResource extends Resource
{
    protected static ?string $cluster = Outbound::class;

    protected static bool $inbound  = false;

    public static function getPages(): array
    {
        return [
            'index' => Suggestions::route('/'),
        ];
    }
}
