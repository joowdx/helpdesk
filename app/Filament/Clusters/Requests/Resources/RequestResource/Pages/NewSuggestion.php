<?php

namespace App\Filament\Clusters\Requests\Resources\RequestResource\Pages;

use App\Enums\RequestClass;
use App\Filament\Clusters\Requests\Concerns\NewRequest;
use App\Filament\Panels\User\Resources\OrganizationResource;
use Filament\Resources\Pages\EditRecord;

class NewSuggestion extends EditRecord
{
    use NewRequest;

    public static RequestClass $classification = RequestClass::SUGGESTION;

    protected static string $resource = OrganizationResource::class;

    protected static ?string $breadcrumb = 'New Suggestion';
}
