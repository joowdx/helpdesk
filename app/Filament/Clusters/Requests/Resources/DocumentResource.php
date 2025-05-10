<?php

namespace App\Filament\Clusters\Requests\Resources;

use App\Enums\FontFamilies;
use App\Enums\PaperSize;
use App\Filament\Clusters\Requests;
use App\Filament\Clusters\Requests\Resources\DocumentResource\Pages;
use App\Models\Document;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'gmdi-article-o';

    protected static ?string $navigationGroup = 'Issuances';

    protected static ?string $cluster = Requests::class;

    public static function form(Form $form): Form
    {
        $caller = debug_backtrace(limit: 2)[1]['object'] ?? null;

        $same = in_array($caller ? $caller::class : null, [
            Pages\CreateDocument::class,
            Pages\EditDocument::class,
        ]);

        return $form
            ->columns(5)
            ->schema([
                Forms\Components\Group::make(),
                Forms\Components\Tabs::make()
                    ->columnSpan(3)
                    ->contained(false)
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Information')
                            ->visible($same)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->markAsRequired()
                                    ->rule('required')
                                    ->columnSpanFull()
                                    ->helperText('Document name like "Endorsement", "Certification", etc.'),
                                Forms\Components\Textarea::make('description')
                                    ->columnSpanFull()
                                    ->rows(3)
                                    ->maxLength(1024)
                                    ->helperText('For your reference only'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Content')
                            ->schema([
                                Forms\Components\Builder::make('content')
                                    ->hiddenLabel()
                                    ->collapsible()
                                    ->minItems(1)
                                    ->required()
                                    ->blockNumbers(false)
                                    ->addActionLabel('Add content')
                                    ->rule(fn () => function ($attribute, $value, $fail) {
                                        if (collect($value)->some(fn ($content) => $content['type'] === 'signatories')) {
                                            return;
                                        }

                                        $fail('You must add at least one signatory.');
                                    })
                                    ->blocks([
                                        Forms\Components\Builder\Block::make('heading')
                                            ->columns(3)
                                            ->schema([
                                                Forms\Components\Select::make('font')
                                                    ->default('Crimson Pro')
                                                    ->required()
                                                    ->searchable()
                                                    ->options(FontFamilies::class),
                                                Forms\Components\Select::make('level')
                                                    ->default('h1')
                                                    ->required()
                                                    ->options([
                                                        'h1' => 'H1',
                                                        'h2' => 'H2',
                                                        'h3' => 'H3',
                                                        'h4' => 'H4',
                                                    ]),
                                                Forms\Components\Select::make('alignment')
                                                    ->default('left')
                                                    ->required()
                                                    ->options([
                                                        'left' => 'Left',
                                                        'center' => 'Center',
                                                        'right' => 'Right',
                                                        'justify' => 'Justify',
                                                    ]),
                                                Forms\Components\Repeater::make('content')
                                                    ->required()
                                                    ->columnSpanFull()
                                                    ->helperText('For document title e.g. "Endorsement", "Certification", "Subject: ABC"')
                                                    ->defaultItems(1)
                                                    ->simple(
                                                        Forms\Components\TextInput::make('line')
                                                            ->rule('required')
                                                            ->markAsRequired()
                                                            ->columnSpanFull(),
                                                    ),
                                            ]),
                                        Forms\Components\Builder\Block::make('addressee')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\Select::make('font')
                                                    ->default('Crimson Pro')
                                                    ->columnSpanFull()
                                                    ->searchable()
                                                    ->required()
                                                    ->options(FontFamilies::class),
                                                Forms\Components\TextInput::make('recipient')
                                                    ->label('Recipient name')
                                                    ->rule('required')
                                                    ->markAsRequired()
                                                    ->live(onBlur: true),
                                                Forms\Components\TextInput::make('position')
                                                    ->label('Position title')
                                                    ->rule('required')
                                                    ->markAsRequired(),
                                                Forms\Components\TextInput::make('organization')
                                                    ->label('Organization name')
                                                    ->rule('required')
                                                    ->markAsRequired(),
                                                Forms\Components\TextInput::make('address-1')
                                                    ->label('Address line 1'),
                                                Forms\Components\TextInput::make('address-2')
                                                    ->label('Address line 2'),
                                                Forms\Components\TextInput::make('address-3')
                                                    ->label('Address line 3'),
                                            ]),
                                        Forms\Components\Builder\Block::make('greeting')
                                            ->schema([
                                                Forms\Components\Select::make('font')
                                                    ->default('Crimson Pro')
                                                    ->columnSpanFull()
                                                    ->searchable()
                                                    ->required()
                                                    ->options(FontFamilies::class),
                                                Forms\Components\TextInput::make('content')
                                                    ->rule('required')
                                                    ->markAsRequired()
                                                    ->helperText('For salutation or valediction e.g. Dear Sir/Madam, Sincerely, etc.'),
                                            ]),
                                        Forms\Components\Builder\Block::make('paragraph')
                                            ->schema([
                                                Forms\Components\Select::make('font')
                                                    ->default('Crimson Pro')
                                                    ->searchable()
                                                    ->options(FontFamilies::class),
                                                Forms\Components\Textarea::make('content')
                                                    ->required()
                                                    ->helperText('For the main body of the response.')
                                                    ->rows(10),
                                            ]),
                                        Forms\Components\Builder\Block::make('markdown')
                                            ->schema([
                                                Forms\Components\Select::make('font')
                                                    ->default('Crimson Pro')
                                                    ->columnSpanFull()
                                                    ->searchable()
                                                    ->required()
                                                    ->options(FontFamilies::class),
                                                Forms\Components\MarkdownEditor::make('content')
                                                    ->hiddenLabel()
                                                    ->required()
                                                    ->helperText('For complex formatting.'),
                                            ]),
                                        Forms\Components\Builder\Block::make('signatories')
                                            ->columns(2)
                                            ->schema([
                                                Forms\Components\Select::make('font')
                                                    ->default('Crimson Pro')
                                                    ->searchable()
                                                    ->required()
                                                    ->options(FontFamilies::class),
                                                Forms\Components\Select::make('alignment')
                                                    ->default('left')
                                                    ->options([
                                                        'left' => 'Left',
                                                        'center' => 'Center',
                                                        'right' => 'Right',
                                                        'justify' => 'Justify',
                                                    ]),
                                                Forms\Components\Repeater::make('signers')
                                                    ->addActionLabel('Add signer')
                                                    ->columnSpanFull()
                                                    ->maxItems(3)
                                                    ->required()
                                                    ->columns(2)
                                                    ->schema([
                                                        Forms\Components\Select::make('user')
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
                                                        Forms\Components\TextInput::make('name')
                                                            ->helperText('If you want to use a different name'),
                                                        Forms\Components\TextInput::make('designation')
                                                            ->helperText('If you want to use a different designation'),
                                                    ]),
                                            ]),
                                    ])
                                    ->default($same ? [
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
                                    ] : null),
                            ]),
                        Forms\Components\Tabs\Tab::make('Options')
                            ->columns(2)
                            ->schema([
                                Forms\Components\Select::make('options.size')
                                    ->options(PaperSize::class)
                                    ->default(PaperSize::A4)
                                    ->placeholder('Select paper size')
                                    ->helperText('Select the paper size for the document')
                                    ->required(),
                                Forms\Components\TextInput::make('options.margins')
                                    ->helperText('Set margins for the document in inches (in format "top right bottom left")')
                                    ->dehydrateStateUsing(fn (?string $state) => (string) str($state)->squish())
                                    ->mutateStateForValidationUsing(fn (?string $state) => (string) str($state)->squish())
                                    ->rule('regex:/^(0\.75|1|1\.25|1\.5|1\.75|2)\s+(0\.75|1|1\.25|1\.5|1\.75|2)\s+(0\.75|1|1\.25|1\.5|1\.75|2)\s+(0\.75|1|1\.25|1\.5|1\.75|2)$/')
                                    ->default('1 1 1 1'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->sortable()
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn ($column) => strlen($column->getState()) > $column->getCharacterLimit() ? $column->getState() : null),
                Tables\Columns\TextColumn::make('responses_count')
                    ->counts('responses')
                    ->label('Responses')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
