<?php

namespace App\Filament\Resources;

use App\Enums\ActionStatus;
use App\Enums\RequestClass;
use App\Filament\Actions\Tables\RecategorizeRequestAction;
use App\Filament\Actions\Tables\ReclassifyRequestAction;
use App\Filament\Actions\Tables\ShowRequestAction;
use App\Filament\Actions\Tables\TagRequestAction;
use App\Filament\Actions\Tables\ViewRequestHistoryAction;
use App\Filament\Clusters\Requests;
use App\Filament\Filters\OrganizationFilter;
use App\Filament\Filters\TagFilter;
use App\Models\Request;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RequestResource extends Resource
{
    public static bool $inbound = true;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Requests::class;

    protected static ?RequestClass $class = null;

    public static function table(Table $table): Table
    {
        $panel = Filament::getCurrentPanel()->getId();

        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['user', 'organization', 'action', 'actions', 'tags']))
            ->columns([
                Tables\Columns\TextColumn::make('action.status')
                    ->label('Status')
                    ->badge()
                    ->description(fn (Request $request) => "#{$request->code}")
                    ->state(function (Request $request) {
                        return match ($request->action->status) {
                            ActionStatus::RESPONDED,
                            ActionStatus::STARTED => ActionStatus::IN_PROGRESS,
                            ActionStatus::SUSPENDED => ActionStatus::ON_HOLD,
                            default => $request->action->status,
                        };
                    }),
                Tables\Columns\TextColumn::make('subject')
                    ->sortable()
                    ->searchable()
                    ->limit(36)
                    ->tooltip(fn ($column) => strlen($column->getState()) > $column->getCharacterLimit() ? $column->getState() : null),
                Tables\Columns\TextColumn::make('organization.code')
                    ->sortable()
                    ->searchable()
                    ->limit(36)
                    ->extraCellAttributes(['class' => 'font-mono'])
                    ->tooltip(fn (Request $request) => $request->organization->name)
                    ->hidden(! in_array($panel, ['root'])),
                Tables\Columns\TextColumn::make('category.name')
                    ->description(fn (Request $request) => $request->subcategory->name),
                Tables\Columns\TextColumn::make('class')
                    ->badge()
                    ->alignEnd()
                    ->visible(static::class === self::class),
                Tables\Columns\TextColumn::make('tags.name')
                    ->badge()
                    ->wrap()
                    ->alignEnd()
                    ->color(fn (Request $request, string $state) => $request->tags->first(fn ($tag) => $tag->name === $state)?->color ?? 'gray'),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->dateTimeTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters(static::tableFilters())
            ->actions(static::tableActions())
            ->bulkActions(static::tableBulkActions())
            ->recordAction(null);
    }

    public static function getNavigationBadge(): ?string
    {
        if (Filament::getCurrentPanel()->getId() === 'root') {
            return static::getEloquentQuery()->count() ?: null;
        }

        return static::getEloquentQuery()
            ->whereHas('action', fn ($query) => $query->where('status', ActionStatus::SUBMITTED))
            ->count() ?: null;
    }

    public static function getEloquentQuery(): Builder
    {
        $panel = Filament::getCurrentPanel()->getId();

        $query = parent::getEloquentQuery()
            ->when(static::$class, fn ($query, $class) => $query->where('class', $class))
            ->when($panel !== 'root', fn ($query) => $query->whereHas('action', fn ($query) => $query->where('status', '!=', ActionStatus::RETRACTED)));

        return match ($panel) {
            'root' => $query,
            'admin' => $query->where(static::$inbound ? 'organization_id' : 'from_id', Auth::user()->organization_id),
            'moderator' => $query->where('organization_id', Auth::user()->organization_id),
            'agent' => $query->whereHas('assignees', fn ($query) => $query->where('assigned_id', Auth::id())),
            default => $query->whereRaw('1 = 0'),
        };
    }

    public static function tableFilters(): array
    {
        if (static::class === self::class) {
            return [
                Tables\Filters\SelectFilter::make('class')
                    ->options(RequestClass::class),
            ];
        }

        return match (Filament::getCurrentPanel()->getId()) {
            'root' => [
                OrganizationFilter::make()
                    ->withUnaffiliated(false),
                Tables\Filters\TrashedFilter::make(),
            ],
            default => [
                TagFilter::make(),
            ],
        };
    }

    public static function tableActions(): array
    {
        return [
            ShowRequestAction::make(),
            ViewRequestHistoryAction::make(),
            Tables\Actions\ActionGroup::make([
                TagRequestAction::make(),
                RecategorizeRequestAction::make(),
                ReclassifyRequestAction::make(),
            ]),
        ];
    }

    public static function tableBulkActions(): array
    {
        return [];
    }
}
