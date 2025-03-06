<?php

namespace App\Filament\Panels\Admin\Clusters\Inbound\Resources\RequestResource\Pages;

use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListInquiries;
use App\Filament\Panels\Admin\Clusters\Inbound\Resources\InquiryResource;

class Inquiries extends ListInquiries
{
    protected static string $resource = InquiryResource::class;
}
