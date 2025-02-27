<?php

namespace App\Filament\Panels\User\Actions;

use App\Enums\RequestClass;
use App\Filament\Panels\User\Resources\OrganizationResource;
use App\Models\Organization;
use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;

class NewRequestPromptAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('new-request-prompt');

        $this->label('New request');

        $this->slideOver();

        $this->modal();

        $this->modalIcon('heroicon-o-plus-circle');

        $this->modalSubmitActionLabel('Proceed');

        $this->modalWidth(MaxWidth::ExtraLarge);

        $this->modalFooterActionsAlignment(Alignment::End);

        $this->action(fn (array $data) => $this->redirect(OrganizationResource::getUrl('new.'.$data['classification'], [$data['organization']])));

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
                    ->options(RequestClass::class)
                    ->required(),
            ];
        });
    }
}
