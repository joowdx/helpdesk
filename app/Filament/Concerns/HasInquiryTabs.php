<?php

namespace App\Filament\Concerns;

use App\Enums\ActionStatus;
use Filament\Facades\Filament;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin \App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListInquiries
 * @mixin \App\Filament\Clusters\Outbound\Resources\RequestResource\Pages\ListInquiries
 * @mixin \App\Filament\Clusters\Personal\Resources\RequestResource\Pages\ListInquiries
 */
trait HasInquiryTabs
{
    public function getTabs(): array
    {
        $panel = Filament::getCurrentPanel()->getId();

        $inbound = static::getResource()::$inbound;

        $query = fn () => static::getResource()::getEloquentQuery();

        return [
            'all' => Tab::make('All')
                ->icon('heroicon-o-ticket')
                ->badge(fn () => $query()->count()),
            ...(in_array($panel, ['admin', 'moderator', 'root']) ? [
                $inbound ? 'submitted' : 'received' => Tab::make($inbound ? 'Submitted' : 'Received')
                    ->modifyQueryUsing(fn (Builder $query) => $query->whereRelation('action', 'status', ActionStatus::SUBMITTED))
                    ->icon(! $inbound ? 'gmdi-inbox-o' : ActionStatus::SUBMITTED->getIcon())
                    ->badge(fn () => $query()->whereRelation('action', 'status', ActionStatus::SUBMITTED)->count()),
                'assigned' => Tab::make('Assigned')
                    ->modifyQueryUsing(fn (Builder $query) => $query->whereRelation('action', 'status', ActionStatus::ASSIGNED))
                    ->icon(ActionStatus::ASSIGNED->getIcon())
                    ->badge(fn () => $query()->whereRelation('action', 'status', ActionStatus::ASSIGNED)->count()),
            ] : []),
            ...($panel !== 'root' ? [
                'pending' => Tab::make('Pending')
                    ->modifyQueryUsing(fn (Builder $query) => $query->whereRelation('action', 'status', ActionStatus::ASSIGNED))
                    ->icon('gmdi-hourglass-empty-o')
                    ->badge(fn () => $query()->whereRelation('action', 'status', ActionStatus::ASSIGNED)->count()),
            ] : []),
            'processing' => Tab::make('Processing')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereRelation('action', 'status', ActionStatus::RESPONDED))
                ->icon(ActionStatus::IN_PROGRESS->getIcon())
                ->badge(fn () => $query()->whereRelation('action', 'status', ActionStatus::RESPONDED)->count()),
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
