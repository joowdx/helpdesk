<?php

namespace App\Filament\Clusters\Requests\Resources\ResponseResource\Pages;

use App\Filament\Actions\SubmitResponseAction;
use App\Filament\Clusters\Requests\Resources\ResponseResource;
use App\Models\Response;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;

class ShowResponse extends ViewRecord
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
        abort_unless($this->record->submitted, 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('download')
                ->keyBindings(['ctrl+space'])
                ->action(fn (Response $response) => Storage::download($response->attachment->files->first())),
            SubmitResponseAction::make(),
        ];
    }
}
