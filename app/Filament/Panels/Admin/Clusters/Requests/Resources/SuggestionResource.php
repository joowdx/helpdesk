<?php

namespace App\Filament\Panels\Admin\Clusters\Requests\Resources;

use App\Filament\Clusters\Requests\Resources\SuggestionResource as Resource;
use App\Filament\Panels\Admin\Clusters\Requests;
use App\Filament\Panels\Admin\Clusters\Requests\Resources\RequestResource\Pages\Suggestions;

class SuggestionResource extends Resource
{
    protected static ?string $cluster = Requests::class;

    public static function getPages(): array
    {
        return [
            'index' => Suggestions::route('/'),
        ];
    }
}
