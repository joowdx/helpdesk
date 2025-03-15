<?php

namespace App\Filament\Panels\User\Actions;

use App\Enums\RequestClass;
use App\Filament\Panels\User\Resources\OrganizationResource;
use App\Models\Organization;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Livewire\Component;

class NewRequestPromptAction extends Action
{
    protected ?RequestClass $class = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->name('new-request-prompt');

        $this->label(fn () => 'New ' .($this->class?->value ?? 'request'));

        $this->slideOver();

        $this->modal();

        $this->modalIcon('heroicon-o-plus-circle');

        $this->modalSubmitActionLabel('Proceed');

        $this->modalWidth(MaxWidth::ExtraLarge);

        $this->modalFooterActionsAlignment(Alignment::End);

        $this->action(function (Component $livewire, array $data) {
            if (Filament::getCurrentPanel()->getId() === 'user') {
                return $this->redirect(OrganizationResource::getUrl('new.'.($data['classification'] ?? $this->class->value), [$data['organization']]));
            }

            return $this->redirect($livewire->getResource()::getUrl('new', [$data['organization']]));
        });

        $this->form(function () {
            $organizations = Organization::query()
                ->get(['name', 'code', 'id'])
                ->mapWithKeys(fn ($organization) => [$organization->id => "{$organization->code} — {$organization->name}"])
                ->toArray();

            return [
                Select::make('organization')
                    ->options($organizations)
                    ->default(count($organizations) === 1 ? key($organizations) : null)
                    ->required(),
                Radio::make('classification')
                    ->visible($this->class === null)
                    ->options(RequestClass::class)
                    ->required(),
            ];
        });
    }

    public function class(?RequestClass $class): static
    {
        $this->class = $class;

        return $this;
    }
}
