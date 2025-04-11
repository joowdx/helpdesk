<?php

namespace App\Filament\Clusters\Requests\Resources\ResponseResource\Pages;

use App\Filament\Actions\PreviewResponseAction;
use App\Filament\Actions\SubmitResponseAction;
use App\Filament\Clusters\Requests\Resources\ResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResponse extends EditRecord
{
    protected static string $resource = ResponseResource::class;

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }

    protected function authorizeAccess(): void
    {
        abort_if($this->record->submitted, 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            PreviewResponseAction::make(),
            SubmitResponseAction::make(),
            Actions\ActionGroup::make([
                Actions\DeleteAction::make(),
            ]),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['hash'] = hash('sha256', json_encode([
            'content' => $data['content'],
            'options' => $data['options'],
        ]));

        return $data;
    }
}
