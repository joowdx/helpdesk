<?php

namespace App\Filament\Panels\User\Resources;

use App\Enums\ActionStatus;
use App\Filament\Actions\Tables\CloseRequestAction;
use App\Filament\Actions\Tables\ComplyRequestAction;
use App\Filament\Actions\Tables\DeleteRequestAction;
use App\Filament\Actions\Tables\ReopenRequestAction;
use App\Filament\Actions\Tables\RespondRequestAction;
use App\Filament\Actions\Tables\RestoreRequestAction;
use App\Filament\Actions\Tables\ResubmitRequestAction;
use App\Filament\Actions\Tables\RetractRequestAction;
use App\Filament\Actions\Tables\ShowRequestAction;
use App\Filament\Actions\Tables\UpdateRequestAction;
use App\Filament\Actions\Tables\ViewRequestHistoryAction;
use App\Filament\Filters\OrganizationFilter;
use App\Filament\Panels\User\Resources\RequestResource\Pages;
use App\Models\Request;
use Filament\Pages\SimplePage;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RequestResource extends SimplePage
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon = 'heroicon-o-lifebuoy';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->extraCellAttributes(['class' => 'font-mono'])
                    ->searchable(),
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
                    ->tooltip(fn (Request $request) => $request->organization->name),
                Tables\Columns\TextColumn::make('class')
                    ->badge()
                    ->alignEnd()
                    ->visible(fn (HasTable $livewire) => $livewire->activeTab === 'requests'),
                Tables\Columns\TextColumn::make('action.status')
                    ->label('Status')
                    ->badge()
                    ->alignEnd()
                    ->state(function (Request $request) {
                        return match ($request->action?->status) {
                            ActionStatus::CLOSED => $request->action?->resolution,
                            ActionStatus::RESPONDED,
                            ActionStatus::STARTED => ActionStatus::IN_PROGRESS,
                            ActionStatus::SUSPENDED => ActionStatus::ON_HOLD,
                            default => $request->action?->status,
                        };
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()
                    ->dateTimeTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                OrganizationFilter::make()
                    ->withUnaffiliated(false),
                Tables\Filters\TrashedFilter::make()
                    ->label('Deleted'),
            ])
            ->actions([
                RespondRequestAction::make(),
                ComplyRequestAction::make(),
                ResubmitRequestAction::make()
                    ->label('Resubmit'),
                CloseRequestAction::make(),
                ShowRequestAction::make()
                    ->label('Show'),
                ViewRequestHistoryAction::make()
                    ->label('History'),
                RestoreRequestAction::make(),
                Tables\Actions\ActionGroup::make([
                    ReopenRequestAction::make(),
                    UpdateRequestAction::make(),
                    RetractRequestAction::make()
                        ->label('Retract'),
                    DeleteRequestAction::make(),
                    Tables\Actions\ForceDeleteAction::make()
                        ->label('Delete'),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequests::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
