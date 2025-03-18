<?php

namespace App\Filament\Panels\User\Clusters\Requests\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\NewInquiry as Create;
use App\Filament\Panels\User\Clusters\Requests\Resources\InquiryResource;

class NewInquiry extends Create
{
    protected static string $resource = InquiryResource::class;
}
