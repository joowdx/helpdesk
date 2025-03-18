<?php

namespace App\Filament\Panels\Moderator\Clusters\Inbound\Resources\RequestResource\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListInquiries as Index;
use App\Filament\Panels\Moderator\Clusters\Inbound\Resources\InquiryResource;

class ListInquiries extends Index
{
    protected static string $resource = InquiryResource::class;
}
