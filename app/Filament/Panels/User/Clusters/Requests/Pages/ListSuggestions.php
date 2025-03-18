<?php

namespace App\Filament\Panels\User\Clusters\Requests\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListSuggestions as Index;
use App\Filament\Panels\User\Clusters\Requests\Resources\SuggestionResource;

class ListSuggestions extends Index
{
    protected static string $resource = SuggestionResource::class;
}
