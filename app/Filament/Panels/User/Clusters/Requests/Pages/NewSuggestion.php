<?php

namespace App\Filament\Panels\User\Clusters\Requests\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\NewSuggestion as Create;
use App\Filament\Panels\User\Clusters\Requests\Resources\SuggestionResource;

class NewSuggestion extends Create
{
    protected static string $resource = SuggestionResource::class;
}
