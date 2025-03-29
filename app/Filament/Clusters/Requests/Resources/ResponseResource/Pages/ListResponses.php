<?php

namespace App\Filament\Clusters\Requests\Resources\ResponseResource\Pages;

use App\Filament\Clusters\Requests\Resources\ResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResponses extends ListRecords
{
    protected static string $resource = ResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
