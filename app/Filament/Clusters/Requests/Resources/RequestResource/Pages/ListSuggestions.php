<?php

namespace App\Filament\Clusters\Requests\Resources\RequestResource\Pages;

use App\Filament\Clusters\Requests\Resources\SuggestionResource;
use App\Filament\Panels\User\Actions\NewRequestPromptAction;
use Filament\Resources\Pages\ListRecords;

class ListSuggestions extends ListRecords
{
    protected static string $resource = SuggestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            NewRequestPromptAction::make()
                ->class(static::getResource()::$class),
        ];
    }
}
