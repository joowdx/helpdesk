<?php

namespace App\Filament\Panels\Moderator\Clusters\Requests\Pages;

use App\Enums\RequestClass;
use App\Filament\Actions\NewRequestPromptAction;
use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListInquiries as Index;
use App\Filament\Panels\Moderator\Clusters\Requests\Resources\InquiryResource;

class ListInquiries extends Index
{
    protected static string $resource = InquiryResource::class;
}
