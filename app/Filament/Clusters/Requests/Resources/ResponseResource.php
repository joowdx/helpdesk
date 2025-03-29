<?php

namespace App\Filament\Clusters\Requests\Resources;

use App\Enums\FontFamilies;
use App\Enums\PaperSize;
use App\Filament\Clusters\Requests;
use App\Filament\Clusters\Requests\Resources\ResponseResource\Pages;
use App\Filament\Clusters\Requests\Resources\ResponseResource\RelationManagers;
use App\Models\Request;
use App\Models\Response;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use LSNepomuceno\LaravelA1PdfSign\Exceptions\ProcessRunTimeException;
use LSNepomuceno\LaravelA1PdfSign\Sign\ManageCert;
use SensitiveParameter;

class ResponseResource extends Resource
{
    protected static ?string $model = Response::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $cluster = Requests::class;

    public static function form(Form $form): Form
    {
        $next = <<<'JS'
            $wire.dispatchFormEvent(
                'wizard::nextStep',
                'data',
                getStepIndex(step),
            )
        JS;

        return $form
            ->model(Request::latest()->first())
            ->columns(5)
            ->schema([
                Hidden::make('request_id')
                    ->default(fn (Request $request) => $request->id),
                Group::make(),
                Tabs::make()
                    ->columnSpan(3)
                    ->contained(false)
                    ->tabs([
                        Tab::make('Content')
                            ->schema([
                                Forms\Components\Builder::make('content')
                                    ->hiddenLabel()
                                    ->collapsible()
                                    ->minItems(1)
                                    ->required()
                                    ->blockNumbers(false)
                                    ->addActionLabel('Add content')
                                    ->blocks([
                                        Block::make('heading')
                                            ->columns(3)
                                            ->schema([
                                                Select::make('font')
                                                    ->default('Crimson Pro')
                                                    ->required()
                                                    ->searchable()
                                                    ->options(FontFamilies::class),
                                                Select::make('level')
                                                    ->default('h1')
                                                    ->required()
                                                    ->options([
                                                        'h1' => 'H1',
                                                        'h2' => 'H2',
                                                        'h3' => 'H3',
                                                        'h4' => 'H4',
                                                    ]),
                                                Select::make('alignment')
                                                    ->default('left')
                                                    ->required()
                                                    ->options([
                                                        'left' => 'Left',
                                                        'center' => 'Center',
                                                        'right' => 'Right',
                                                        'justify' => 'Justify',
                                                    ]),
                                                Repeater::make('content')
                                                    ->required()
                                                    ->columnSpanFull()
                                                    ->helperText('For document title e.g. "Endorsement", "Certification", "Subject: ABC"')
                                                    ->defaultItems(1)
                                                    ->simple(
                                                        TextInput::make('line')
                                                            ->rule('required')
                                                            ->markAsRequired()
                                                            ->columnSpanFull(),
                                                    ),
                                            ]),
                                        Block::make('addressee')
                                            ->columns(2)
                                            ->schema([
                                                Select::make('font')
                                                    ->default('Crimson Pro')
                                                    ->columnSpanFull()
                                                    ->searchable()
                                                    ->required()
                                                    ->options(FontFamilies::class),
                                                TextInput::make('recipient')
                                                    ->label('Recipient name')
                                                    ->default(fn (Request $request) => $request->user->name)
                                                    ->rule('required')
                                                    ->markAsRequired()
                                                    ->live(onBlur: true),
                                                TextInput::make('position')
                                                    ->label('Position title')
                                                    ->default(fn (Request $request) => $request->user->designation)
                                                    ->rule('required')
                                                    ->markAsRequired(),
                                                TextInput::make('organization')
                                                    ->label('Organization name')
                                                    ->default(fn (Request $request) => $request->organization->name)
                                                    ->rule('required')
                                                    ->markAsRequired(),
                                                TextInput::make('address-1')
                                                    ->label('Address line 1')
                                                    ->default(function (Request $request) {
                                                        $room = $request->organization->room;

                                                        $building = $request->organization->building;

                                                        return $room ? "$room, $building" : $building;
                                                    }),
                                                TextInput::make('address-2')
                                                    ->label('Address line 2')
                                                    ->default(fn (Request $request) => $request->organization->address),
                                                TextInput::make('address-3')
                                                    ->label('Address line 3'),
                                            ]),
                                        Block::make('greeting')
                                            ->schema([
                                                Select::make('font')
                                                    ->default('Crimson Pro')
                                                    ->columnSpanFull()
                                                    ->searchable()
                                                    ->required()
                                                    ->options(FontFamilies::class),
                                                TextInput::make('content')
                                                    ->rule('required')
                                                    ->markAsRequired()
                                                    ->helperText('For salutation or valediction e.g. Dear Sir/Madam, Sincerely, etc.'),
                                            ]),
                                        Block::make('paragraph')
                                            ->schema([
                                                Select::make('font')
                                                    ->default('Crimson Pro')
                                                    ->searchable()
                                                    ->options(FontFamilies::class),
                                                Textarea::make('content')
                                                    ->required()
                                                    ->helperText('For the main body of the response.')
                                                    ->rows(10),
                                            ]),
                                        Block::make('markdown')
                                            ->schema([
                                                Select::make('font')
                                                    ->default('Crimson Pro')
                                                    ->columnSpanFull()
                                                    ->searchable()
                                                    ->required()
                                                    ->options(FontFamilies::class),
                                                MarkdownEditor::make('content')
                                                    ->hiddenLabel()
                                                    ->required()
                                                    ->helperText('For complex formatting.'),
                                            ]),
                                        Block::make('signatories')
                                            ->columns(2)
                                            ->schema([
                                                Select::make('font')
                                                    ->default('Crimson Pro')
                                                    ->searchable()
                                                    ->required()
                                                    ->options(FontFamilies::class),
                                                Select::make('alignment')
                                                    ->default('left')
                                                    ->options([
                                                        'left' => 'Left',
                                                        'center' => 'Center',
                                                        'right' => 'Right',
                                                        'justify' => 'Justify',
                                                    ]),
                                                Repeater::make('signers')
                                                    ->addActionLabel('Add signer')
                                                    ->columnSpanFull()
                                                    ->maxItems(3)
                                                    ->required()
                                                    ->columns(2)
                                                    ->schema([
                                                        Select::make('user')
                                                            ->columnSpanFull()
                                                            ->default(Auth::id())
                                                            ->options(function () {
                                                                $users = User::query()
                                                                    ->where('organization_id', Auth::user()->organization_id)
                                                                    ->sortByRole()
                                                                    ->orderBy('name')
                                                                    ->get(['id', 'name', 'role', 'designation']);

                                                                return $users->mapWithKeys(function (User $user) {
                                                                    return [$user->id => "{$user->name} ({$user->role?->getLabel()})".($user->designation ? ' ('.$user->designation.')' : '')];
                                                                });
                                                            })
                                                            ->rule(fn () => function ($attribute, $value, $fail) {
                                                                if (User::whereId($value)->has('signature')->doesntExist()) {
                                                                    $fail('The selected user does not have a signature.');
                                                                }
                                                            })
                                                            ->distinct()
                                                            ->searchable()
                                                            ->required()
                                                            ->placeholder(null)
                                                            ->helperText('Signer of the document'),
                                                        TextInput::make('name')
                                                            ->helperText('If you want to use a different name'),
                                                        TextInput::make('designation')
                                                            ->helperText('If you want to use a different designation'),
                                                    ]),
                                            ]),
                                    ])
                                    ->default([
                                        [
                                            'type' => 'heading',
                                            'data' => [
                                                'content' => [],
                                            ],
                                        ],
                                        [
                                            'type' => 'addressee',
                                            'data' => [],
                                        ],
                                        [
                                            'type' => 'greeting',
                                            'data' => [
                                                'content' => 'To whom it may concern,',
                                            ],
                                        ],
                                        [
                                            'type' => 'paragraph',
                                            'data' => [
                                                'content' => 'I hope this message finds you well...',
                                            ],
                                        ],
                                        [
                                            'type' => 'greeting',
                                            'data' => [
                                                'content' => 'Sincerely,',
                                            ],
                                        ],
                                        [
                                            'type' => 'signatory',
                                            'data' => [],
                                        ],
                                    ]),
                            ]),
                        Tab::make('Options')
                            ->schema([
                                Select::make('size')
                                    ->options(PaperSize::class)
                                    ->default(PaperSize::A4)
                                    ->placeholder('Select paper size')
                                    ->helperText('Select the paper size for the document')
                                    ->required(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResponses::route('/'),
            'create' => Pages\CreateResponse::route('/create'),
            'edit' => Pages\EditResponse::route('/{record}/edit'),
        ];
    }
}
