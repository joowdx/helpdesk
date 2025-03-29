<?php

namespace App\Filament\Clusters\Requests\Resources\ResponseResource\Pages;

use App\Filament\Actions\PreviewResponseAction;
use App\Filament\Clusters\Requests\Resources\ResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResponse extends EditRecord
{
    protected static string $resource = ResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            PreviewResponseAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
