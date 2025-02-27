<?php

namespace App\Filament\Panels\User\Resources\OrganizationResource\Pages;

use App\Enums\RequestClass;
use App\Filament\Panels\User\Resources\OrganizationResource;
use App\Filament\Panels\User\Resources\OrganizationResource\Concerns\NewRequest;
use Filament\Resources\Pages\EditRecord;

class NewSuggestion extends EditRecord
{
    use NewRequest;

    protected static string $resource = OrganizationResource::class;

    protected static ?string $breadcrumb = 'New Suggestion';

    protected static RequestClass $classification = RequestClass::SUGGESTION;
}
