<?php

namespace App\Filament\Actions\Tables;

use App\Enums\ActionStatus;
use App\Enums\PaperSize;
use App\Models\Request;
use App\Models\User;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Get;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use LSNepomuceno\LaravelA1PdfSign\Exceptions\ProcessRunTimeException;
use LSNepomuceno\LaravelA1PdfSign\Sign\ManageCert;
use SensitiveParameter;

class RespondRequestAction extends Action
{
    protected function setUp(): void
    {
        $next = <<<'JS'
            $wire.dispatchFormEvent(
                'wizard::nextStep',
                'data',
                getStepIndex(step),
            )
        JS;

        parent::setUp();

        $this->name('respond-request');

        $this->label('Respond');

        $this->icon(ActionStatus::RESPONDED->getIcon());

        $this->modalIcon(ActionStatus::RESPONDED->getIcon());

        $this->modalHeading('Make a formal response');

        $this->modalDescription(function () {
            $html = <<<'HTML'
                This response could range from a simple acknowledgment or advisory to a more detailed recommendation of a course of action.
                It may also include more formal communications, such as an official letter, email, or other written correspondence,
                depending on the context and the level of formality required. <br>

                <b>Note:</b> This response will generate a printable document that will be digitally signed by you or your delegate.
            HTML;

            return str($html)->toHtmlString();
        });

        $this->slideOver();

        $this->closeModalByClickingAway(false);

        $this->closeModalByEscaping(false);

        $this->modalWidth(MaxWidth::FourExtraLarge);

        $this->form([
            Wizard::make()
                ->contained(false)
                ->steps([
                    Step::make('Body')
                        ->description('Main content')
                        ->schema([
                            Builder::make('content')
                                ->collapsible()
                                ->minItems(1)
                                ->required()
                                ->blockNumbers(false)
                                ->addActionLabel('Add paragraph')
                                ->blocks([
                                    Block::make('addressee')
                                        ->schema([
                                            TextInput::make('recipient')
                                                ->label('Recipient name')
                                                ->default(fn (Request $request) => $request->user->name)
                                                ->rule('required')
                                                ->markAsRequired()
                                                ->extraAttributes(['onkeydown' => "return event.key != 'Enter';"])
                                                ->extraAlpineAttributes(['@keyup.enter' => $next])
                                                ->live(onBlur: true),
                                            TextInput::make('position')
                                                ->label('Position title')
                                                ->default(fn (Request $request) => $request->user->designation)
                                                ->rule('required')
                                                ->markAsRequired()
                                                ->extraAttributes(['onkeydown' => "return event.key != 'Enter';"])
                                                ->extraAlpineAttributes(['@keyup.enter' => $next]),
                                            TextInput::make('organization')
                                                ->label('Organization name')
                                                ->default(fn (Request $request) => $request->organization->name)
                                                ->rule('required')
                                                ->markAsRequired()
                                                ->extraAttributes(['onkeydown' => "return event.key != 'Enter';"])
                                                ->extraAlpineAttributes(['@keyup.enter' => $next]),
                                            TextInput::make('address-1')
                                                ->label('Address line 1')
                                                ->default(function (Request $request) {
                                                    $room = $request->organization->room;

                                                    $building = $request->organization->building;

                                                    return $room ? "$room, $building" : $building;
                                                })
                                                ->extraAttributes(['onkeydown' => "return event.key != 'Enter';"])
                                                ->extraAlpineAttributes(['@keyup.enter' => $next]),
                                            TextInput::make('address-2')
                                                ->label('Address line 2')
                                                ->default(fn (Request $request) => $request->organization->address)
                                                ->extraAttributes(['onkeydown' => "return event.key != 'Enter';"])
                                                ->extraAlpineAttributes(['@keyup.enter' => $next]),
                                        ]),
                                    Block::make('title')
                                        ->schema([
                                            TextInput::make('title')
                                                ->hiddenLabel()
                                                ->rule('required')
                                                ->markAsRequired()
                                                ->helperText('For document title e.g. "Endorsement", "Certification"')
                                                ->extraAttributes(['onkeydown' => "return event.key != 'Enter';"])
                                                ->extraAlpineAttributes(['@keyup.enter' => $next]),
                                        ]),
                                    Block::make('greeting')
                                        ->schema([
                                            TextInput::make('greeting')
                                                ->hiddenLabel()
                                                ->rule('required')
                                                ->markAsRequired()
                                                ->helperText('For salutation or valediction e.g. Dear Sir/Madam, Sincerely, etc.'),
                                        ]),
                                    Block::make('paragraph')
                                        ->schema([
                                            Textarea::make('paragraph')
                                                ->hiddenLabel()
                                                ->required()
                                                ->helperText('For the main body of the response.'),
                                        ]),
                                    Block::make('markdown')
                                        ->schema([
                                            MarkdownEditor::make('Markdown')
                                                ->hiddenLabel()
                                                ->required()
                                                ->helperText('For complex formatting.'),
                                        ]),
                                    Block::make('signatory')
                                        ->schema([

                                        ]),
                                ])
                                ->default([
                                    [
                                        'type' => 'title',
                                        'data' => [
                                            'greeting' => '',
                                        ],
                                    ],
                                    [
                                        'type' => 'addressee',
                                        'data' => [],
                                    ],
                                    [
                                        'type' => 'greeting',
                                        'data' => [
                                            'greeting' => 'To whom it may concern,',
                                        ],
                                    ],
                                    [
                                        'type' => 'paragraph',
                                        'data' => [
                                            'paragraph' => 'I hope this message finds you well...',
                                        ],
                                    ],
                                    [
                                        'type' => 'greeting',
                                        'data' => [
                                            'greeting' => 'Sincerely,',
                                        ],
                                    ],
                                    [
                                        'type' => 'signatory',
                                        'data' => [
                                            'signatory' => 'Sincerely,',
                                        ],
                                    ],
                                ]),
                        ]),
                    Step::make('Signatory')
                        ->description('Closing remarks')
                        ->schema([
                            Select::make('signer')
                                ->options(function () {
                                    $users = User::query()
                                        ->where('organization_id', Auth::user()->organization_id)
                                        ->where('id', '!=', Auth::user()->id)
                                        ->sortByRole()
                                        ->orderBy('name')
                                        ->get(['id', 'name', 'role', 'designation']);

                                    return $users->mapWithKeys(function (User $user) {
                                        return [$user->id => "{$user->name} ({$user->role?->getLabel()})".($user->designation ? ' ('.$user->designation.')' : '')];
                                    });
                                })
                                ->searchable()
                                ->placeholder(null),
                            TextInput::make('name'),
                            TextInput::make('designation'),
                            FileUpload::make('signature')
                                ->acceptedFileTypes(['image/png', 'image/webp', 'image/x-webp'])
                                ->imageEditorAspectRatios(['4:3', '1:1', '3:4'])
                                ->maxSize(2048),
                            FileUpload::make('certificate')
                                ->acceptedFileTypes(['application/x-pkcs12'])
                                ->reactive(),
                            TextInput::make('password')
                                ->password()
                                ->visible(fn (Get $get) => current($get('certificate')) instanceof TemporaryUploadedFile)
                                ->required(fn (Get $get) => current($get('certificate')) instanceof TemporaryUploadedFile)
                                ->dehydratedWhenHidden()
                                ->rule(fn (Get $get) => function ($attribute, #[SensitiveParameter] $value, $fail) use ($get) {
                                    if (empty($value) || empty($get('certificate'))) {
                                        return;
                                    }

                                    if (! current($get('certificate')) instanceof TemporaryUploadedFile) {
                                        return;
                                    }

                                    try {
                                        (new ManageCert)->setPreservePfx()->fromUpload(current($get('certificate')), $value);
                                    } catch (ProcessRunTimeException $exception) {
                                        if (str($exception->getMessage())->contains('password')) {
                                            $fail('The password is incorrect.');
                                        }
                                    }
                                }),
                        ]),
                    Step::make('Options')
                        ->description('Export options')
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

        $this->action(function (array $data) {
            dd($data);
        });
    }
}
