<?php

namespace App\Filament\Clusters\Requests\Resources;

use App\Enums\ActionStatus;
use App\Enums\UserRole;
use App\Filament\Actions\Tables\ViewRequestAction;
use App\Filament\Clusters\Requests;
use App\Filament\Clusters\Requests\Resources\ResponseResource\Pages;
use App\Models\Request;
use App\Models\Response;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ResponseResource extends Resource
{
    protected static ?int $navigationSort = -PHP_INT_MAX;

    protected static ?string $model = Response::class;

    protected static ?string $navigationIcon = 'gmdi-history-edu-o';

    protected static ?string $navigationGroup = 'Issuances';

    protected static ?string $cluster = Requests::class;

    public static function form(Form $form): Form
    {
        return DocumentResource::form($form);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema(fn (Response $response) => [
                TextEntry::make('user.name')
                    ->label('Responder'),
                TextEntry::make('submitted_at')
                    ->label('Submitted')
                    ->dateTime(),
                TextEntry::make('users.name')
                    ->label('Signers')
                    ->listWithLineBreaks(),
                ViewEntry::make('document')
                    ->label('Document')
                    ->columnSpanFull()
                    ->alignCenter()
                    ->view('filament.responses.document', [
                        'response' => $response,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('action.request.action.status')
                    ->label('Request')
                    ->badge()
                    ->description(fn (Response $response) => "#{$response->action->request->code}")
                    ->state(function (Response $response) {
                        return match ($response->action->request?->action?->status) {
                            ActionStatus::CLOSED => $response->action->request->action?->resolution,
                            ActionStatus::REPLIED,
                            ActionStatus::STARTED => ActionStatus::IN_PROGRESS,
                            ActionStatus::SUSPENDED => ActionStatus::ON_HOLD,
                            default => $response->action->request?->action?->status,
                        };
                    }),
                Tables\Columns\TextColumn::make('document.name')
                    ->searchable(['name', 'description'])
                    ->label('Document'),
                Tables\Columns\TextColumn::make('users.name')
                    ->label('Signers')
                    ->bulleted()
                    ->limitList(3),
                Tables\Columns\TextColumn::make('status')
                    ->state(fn (Response $record) => $record->issued_at ? 'Issued' : 'Draft')
                    ->color(fn (Response $record) => $record->issued_at ? 'success' : 'primary')
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ViewRequestAction::make()
                    ->model(Request::class)
                    ->record(fn (Model $record) => $record->action->request)
                    ->url(null)
                    ->label('Request'),
            ])
            ->recordAction('view')
            ->recordUrl(null);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResponses::route('/'),
            'create' => Pages\CreateResponse::route('/create'),
            'edit' => Pages\EditResponse::route('/{record}/edit'),
            'view' => Pages\ShowResponse::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $scope = function ($query) {
            return $query->whereHas('action', fn ($query) =>
                $query->whereHas('request', fn (Builder $query) =>
                    $query->where('organization_id', Auth::user()->organization_id)
                )
            );
        };

        return match (Auth::user()->role) {
            UserRole::ROOT => $query,
            UserRole::ADMIN, UserRole::MODERATOR => $scope($query),
            UserRole::AGENT => $scope($query)->whereHas('signers', fn ($query) => $query->where('user_id', Auth::id())),
            default => $query->whereRaw('1 = 0'),
        };
    }
}
