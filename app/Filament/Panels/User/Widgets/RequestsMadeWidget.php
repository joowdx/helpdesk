<?php

namespace App\Filament\Panels\User\Widgets;

use App\Enums\RequestClass;
use App\Models\Request;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class RequestsMadeWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $id = Auth::id();

        return [
            Stat::make('Requests', Request::where('user_id', $id)->count()),
            Stat::make('ListInquiries', Request::where('user_id', $id)->where('class', RequestClass::INQUIRY)->count()),
            Stat::make('ListSuggestions', Request::where('user_id', $id)->where('class', RequestClass::SUGGESTION)->count()),
            Stat::make('ListTickets', Request::where('user_id', $id)->where('class', RequestClass::TICKET)->count()),
        ];
    }
}
