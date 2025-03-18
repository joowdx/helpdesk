<?php

namespace App\Filament\Panels\User\Clusters\Requests\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListInquiries as Index;
use App\Filament\Panels\User\Clusters\Requests\Resources\InquiryResource;

class ListInquiries extends Index
{
    protected static string $resource = InquiryResource::class;
}
