<?php

namespace App\Filament\Clusters\Requests\Resources\RequestResource\Pages;

use App\Enums\ActionStatus;
use App\Filament\Clusters\Requests\Resources\TicketResource;
use Filament\Facades\Filament;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    public function getTabs(): array
    {
        $panel = Filament::getCurrentPanel()->getId();

        $outbound = $panel === 'root' || $panel === 'admin' && static::getResource()::$inbound === false;

        $query = fn () => static::$resource::getEloquentQuery();

        return [
            'all' => Tab::make('All')
                ->icon('heroicon-o-ticket')
                ->badge(fn () => $query()->count()),
            ...(in_array($panel, ['admin', 'moderator', 'root']) ? [
                $outbound ? 'submitted' : 'received' => Tab::make($outbound ? 'Submitted' : 'Received')
                    ->modifyQueryUsing(fn (Builder $query) => $query->whereRelation('action', 'status', ActionStatus::SUBMITTED))
                    ->icon(! $outbound ? 'gmdi-inbox-o' : ActionStatus::SUBMITTED->getIcon())
                    ->badge(fn () => $query()->whereRelation('action', 'status', ActionStatus::SUBMITTED)->count()),
                'assigned' => Tab::make('Assigned')
                    ->modifyQueryUsing(fn (Builder $query) => $query->whereRelation('action', 'status', ActionStatus::ASSIGNED))
                    ->icon(ActionStatus::ASSIGNED->getIcon())
                    ->badge(fn () => $query()->whereRelation('action', 'status', ActionStatus::ASSIGNED)->count()),
            ] : []),
            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereRelation('action', 'status', ActionStatus::ASSIGNED))
                ->icon('gmdi-hourglass-empty-o')
                ->badge(fn () => $query()->whereRelation('action', 'status', ActionStatus::ASSIGNED)->count()),
            'processing' => Tab::make('Processing')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereRelation('action', 'status', ActionStatus::STARTED))
                ->icon(ActionStatus::IN_PROGRESS->getIcon())
                ->badge(fn () => $query()->whereRelation('action', 'status', ActionStatus::STARTED)->count()),
            'suspended' => Tab::make('Suspended')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('action', fn ($query) => $query->whereIn('status', [
                    ActionStatus::SUSPENDED,
                    ActionStatus::COMPLIED,
                ])))
                ->icon(ActionStatus::SUSPENDED->getIcon())
                ->badge(fn () => $query()->whereHas('action', fn ($query) => $query->whereIn('status', [
                    ActionStatus::SUSPENDED,
                    ActionStatus::COMPLIED,
                ]))->count()),
            'completed' => Tab::make('Completed')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('action', fn ($query) => $query->whereIn('status', [
                    ActionStatus::COMPLETED,
                    ActionStatus::REOPENED,
                ])))
                ->icon(ActionStatus::COMPLETED->getIcon())
                ->badge(fn () => $query()->whereHas('action', fn ($query) => $query->whereIn('status', [
                    ActionStatus::COMPLETED,
                    ActionStatus::REOPENED,
                ]))->count()),
            'closed' => Tab::make('Closed')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereRelation('action', 'status', ActionStatus::CLOSED))
                ->icon(ActionStatus::CLOSED->getIcon())
                ->badge(fn () => $query()->whereRelation('action', 'status', ActionStatus::CLOSED)->count()),
        ];
    }
}
