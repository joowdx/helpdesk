<?php

namespace App\Filament\Panels\Root\Clusters\Requests\Resources\RequestResource\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListSuggestions;
use App\Filament\Panels\Root\Clusters\Requests\Resources\SuggestionResource;

class Suggestions extends ListSuggestions
{
    protected static string $resource = SuggestionResource::class;
}
