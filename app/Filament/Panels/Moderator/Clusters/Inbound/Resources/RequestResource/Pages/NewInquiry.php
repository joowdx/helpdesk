<?php

namespace App\Filament\Panels\Moderator\Clusters\Inbound\Resources\RequestResource\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\NewInquiry as Create;
use App\Filament\Panels\Moderator\Clusters\Inbound\Resources\InquiryResource;

class NewInquiry extends Create
{
    protected static string $resource = InquiryResource::class;
}
