<?php

namespace App\Filament\Concerns;

/**
 * @mixin \App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListInquiries
 * @mixin \App\Filament\Clusters\Outbound\Resources\RequestResource\Pages\ListInquiries
 * @mixin \App\Filament\Clusters\Personal\Resources\RequestResource\Pages\ListInquiries
 */
trait HasSuggestionTabs
{
    public function getTabs(): array
    {
        return [
        ];
    }
}
