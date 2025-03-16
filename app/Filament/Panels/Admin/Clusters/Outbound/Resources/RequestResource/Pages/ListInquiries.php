<?php

namespace App\Filament\Panels\Admin\Clusters\Outbound\Resources\RequestResource\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListInquiries as Index;
use App\Filament\Panels\Admin\Clusters\Outbound\Resources\InquiryResource;

class ListInquiries extends Index
{
    protected static string $resource = InquiryResource::class;
}
