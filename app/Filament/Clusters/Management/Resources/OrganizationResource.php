<?php

namespace App\Filament\Clusters\Management\Resources;

use App\Filament\Clusters\Management;
use App\Filament\Clusters\Management\Resources\OrganizationResource\Pages;
use App\Models\Organization;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrganizationResource extends Resource
{
    protected static ?int $navigationSort = -2;

    protected static ?string $model = Organization::class;

    protected static ?string $navigationIcon = 'gmdi-domain-o';

    protected static ?string $cluster = Management::class;

    protected static ?string $recordTitleAttribute = 'code';

    public static function canAccess(): bool
    {
        return Filament::getCurrentPanel()->getId() === 'root';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Tabs::make()
                    ->contained(false)
                    ->columns(3)
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Organization')
                            ->icon('gmdi-domain-o')
                            ->schema([
                                Forms\Components\FileUpload::make('logo')
                                    ->avatar()
                                    ->alignCenter()
                                    ->directory('logos'),
                                Forms\Components\Group::make()
                                    ->columnSpan([
                                        'md' => 2,
                                    ])
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->unique(ignoreRecord: true)
                                            ->markAsRequired()
                                            ->rule('required'),
                                        Forms\Components\TextInput::make('code')
                                            ->markAsRequired()
                                            ->rule('required')
                                            ->unique(ignoreRecord: true),
                                    ]),
                                Forms\Components\TextInput::make('address')
                                    ->maxLength(255)
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 3,
                                    ]),
                                Forms\Components\TextInput::make('building')
                                    ->maxLength(255)
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 2,
                                    ]),
                                Forms\Components\TextInput::make('room')
                                    ->columnSpan(1),
                            ]),
                        Forms\Components\Tabs\Tab::make('Configuration')
                            ->icon('gmdi-build-circle-o')
                            ->schema([
                                Forms\Components\TextInput::make('settings.auto_queue')
                                    ->label('Request auto queue')
                                    ->placeholder('Number of minutes')
                                    ->helperText('Number of minutes to auto queue a request')
                                    ->rules(['numeric']),
                                Forms\Components\TextInput::make('settings.auto_resolve')
                                    ->label('Request auto resolve')
                                    ->placeholder('Number of hours')
                                    ->helperText('Number of hours to auto resolve a completed request')
                                    ->minValue(48)
                                    ->rules(['numeric']),
                                // Forms\Components\TextInput::make('settings.auto_assign')
                                //     ->label('Request auto assign')
                                //     ->placeholder('Number of minutes')
                                //     ->helperText('Number of minutes to auto assign a request')
                                //     ->rules(['numeric']),
                            ]),
                        Forms\Components\Tabs\Tab::make('Documents')
                            ->icon('gmdi-attach-file-o')
                            ->schema([
                                Forms\Components\Section::make('Header')
                                    ->description('Header image for the official response documents')
                                    ->schema([
                                        Forms\Components\FileUpload::make('settings.header')
                                            ->acceptedFileTypes(['image/*'])
                                            ->directory('headers'),
                                    ]),
                                Forms\Components\Section::make('Footer')
                                    ->description('Footer image for the official response documents')
                                    ->schema([
                                        Forms\Components\FileUpload::make('settings.footer')
                                            ->acceptedFileTypes(['image/*'])
                                            ->directory('footers'),
                                        Forms\Components\Select::make('settings.footer_alignment')
                                            ->label('Alignment')
                                            ->options([
                                                'left' => 'Left',
                                                'center' => 'Center',
                                                'right' => 'Right',
                                            ]),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo_url')
                    ->label('')
                    ->circular()
                    ->extraImgAttributes(['loading' => 'lazy'])
                    ->grow(0),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(isIndividual: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('users_count')
                    ->label('Users')
                    ->counts('users')
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\DeleteAction::make()
                        ->modalDescription('Deleting this office will affect all related records associated with it e.g. categories and subcategories under this office.'),
                    Tables\Actions\ForceDeleteAction::make()
                        ->modalDescription(function () {
                            $description = <<<'HTML'
                                <p class="mt-2 text-sm text-gray-500 fi-modal-description dark:text-gray-400">
                                    Deleting this office will affect all related records associated with it e.g. categories and subcategories under this office.
                                </p>

                                <p class="mt-2 text-sm fi-modal-description text-custom-600 dark:text-custom-400" style="--c-400:var(--danger-400);--c-600:var(--danger-600);">
                                    Proceeding will permanently delete the office and all related records associated with it.
                                </p>
                            HTML;

                            return str($description)->toHtmlString();
                        }),
                ]),
            ])
            ->recordAction(null)
            ->recordUrl(null);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->withoutTrashed()->count();
    }
}
