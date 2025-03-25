<?php

namespace App\Filament\Panels\Auth\Pages;

use App\Filament\Actions\ChangePasswordAction;
use App\Filament\Concerns\FormatsName;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\EditProfile;
use Filament\Support\Enums\Alignment;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use LSNepomuceno\LaravelA1PdfSign\Exceptions\ProcessRunTimeException;
use LSNepomuceno\LaravelA1PdfSign\Sign\ManageCert;
use SensitiveParameter;

class Profile extends EditProfile
{
    use FormatsName;

    protected $listeners = [
        'signature-deleted' => '$refresh',
    ];

    public static function isSimple(): bool
    {
        return false;
    }

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            ChangePasswordAction::make(),
        ];
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        Section::make('Information')
                            ->description('Update your profile information.')
                            ->aside()
                            // ->footerActionsAlignment(Alignment::Right)
                            ->footerActions([
                                Action::make('save')
                                    ->label(__('filament-panels::pages/auth/edit-profile.form.actions.save.label'))
                                    ->submit('save')
                                    ->keyBindings(['mod+s']),
                            ])
                            ->schema([
                                // FileUpload::make('avatar')
                                //     ->avatar()
                                //     ->alignCenter()
                                //     ->directory('avatars')
                                //     ->helperText('Upload a new profile picture.')
                                //     ->extraAttributes(['x-cloak']),
                                $this->getEmailFormComponent()
                                    ->prefixIcon('heroicon-o-at-symbol')
                                    ->readOnly()
                                    ->dehydrated(false)
                                    ->helperText('You cannot change your email address.'),
                                $this->getNameFormComponent()
                                    ->prefixIcon('heroicon-o-tag')
                                    ->helperText('Enter your full legal name with proper capitalization.')
                                    ->dehydrateStateUsing(fn ($state) => $this->formatName($state)),
                                TextInput::make('designation')
                                    ->prefixIcon('heroicon-o-briefcase')
                                    ->helperText('Enter your current designation.')
                                    ->rule('required')
                                    ->markAsRequired()
                                    ->dehydrateStateUsing(fn ($state) => mb_ucfirst(mb_strtolower($state))),
                                TextInput::make('number')
                                    ->label('Mobile number')
                                    ->placeholder('9xx xxx xxxx')
                                    ->mask('999 999 9999')
                                    ->prefixIcon('heroicon-o-phone')
                                    ->autofocus()
                                    ->helperText('(Optional) Enter your mobile number in the format 9xx-xxx-')
                                    ->rule(fn () => function ($a, $v, $f) {
                                        if (! preg_match('/^9.*/', $v)) {
                                            $f('The mobile number field must follow a format of 9xx-xxx-xxxx.');
                                        }
                                    }),
                            ]),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data')
                    ->inlineLabel(),
            ),
        ];
    }
}
