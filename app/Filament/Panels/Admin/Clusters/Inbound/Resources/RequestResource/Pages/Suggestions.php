<?php

namespace App\Filament\Panels\Admin\Clusters\Inbound\Resources\RequestResource\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListSuggestions;
use App\Filament\Panels\Admin\Clusters\Inbound\Resources\SuggestionResource;

class Suggestions extends ListSuggestions
{
    protected static string $resource = SuggestionResource::class;
}
