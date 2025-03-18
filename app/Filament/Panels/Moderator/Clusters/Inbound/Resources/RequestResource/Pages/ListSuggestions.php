<?php

namespace App\Filament\Panels\Moderator\Clusters\Inbound\Resources\RequestResource\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListSuggestions as Index;
use App\Filament\Panels\Moderator\Clusters\Inbound\Resources\SuggestionResource;

class ListSuggestions extends Index
{
    protected static string $resource = SuggestionResource::class;
}
