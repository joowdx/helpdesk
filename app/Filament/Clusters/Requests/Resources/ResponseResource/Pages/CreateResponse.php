<?php

namespace App\Filament\Clusters\Requests\Resources\ResponseResource\Pages;

use App\Filament\Clusters\Requests\Resources\ResponseResource;
use App\Models\Document;
use App\Models\Request;
use Filament\Resources\Pages\CreateRecord;
use Livewire\Attributes\Url;

class CreateResponse extends CreateRecord
{
    #[Url]
    public string $document;

    #[Url]
    public string $request;

    protected static string $resource = ResponseResource::class;

    protected static bool $canCreateAnother = false;

    public function mount(): void
    {
        parent::mount();

        abort_unless($document = Document::find($this->document), 404);

        abort_unless(Request::find($this->request), 404);

        abort_unless(request()->hasValidSignature(), 403);

        $this->form->fill([
            'content' => $document?->content,
            'options' => $document?->options,
        ]);
    }

    public function getSubNavigation(): array
    {
        if (filled($cluster = static::getCluster())) {
            return $this->generateNavigationItems($cluster::getClusteredComponents());
        }

        return [];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return [
            ...$data,
            'document_id' => $this->document,
            'request_id' => $this->request,
        ];
    }

    protected function getRedirectUrl(): string
    {
        $resource = static::getResource();

        if ($resource::hasPage('edit') && $resource::canEdit($this->getRecord())) {
            return $resource::getUrl('edit', ['record' => $this->getRecord(), ...$this->getRedirectUrlParameters()]);
        }

        return $resource::getUrl('index');
    }
}
