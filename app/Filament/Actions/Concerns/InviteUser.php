<?php

namespace App\Filament\Actions\Concerns;

use App\Enums\UserRole;
use App\Filament\Actions\Notifications\AcceptInvitationAction;
use App\Models\Organization;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

trait InviteUser
{
    protected function bootInviteUser(): void
    {
        $this->name('invite-user');

        $this->icon('gmdi-person-add-o');

        $this->modalIcon('gmdi-person-add-o');

        $this->modalWidth(MaxWidth::Large);

        $this->modalFooterActionsAlignment(Alignment::Right);

        $this->modalDescription('Invite a new user to your organization.');

        $this->form([
            Radio::make('role')
                ->required()
                ->options([
                    UserRole::ADMIN->value => UserRole::ADMIN->getLabel(),
                    UserRole::MODERATOR->value => UserRole::MODERATOR->getLabel(),
                    UserRole::AGENT->value => UserRole::AGENT->getLabel(),
                    UserRole::USER->value => UserRole::USER->getLabel(),
                ])
                ->descriptions([
                    UserRole::ADMIN->value => UserRole::ADMIN->getDescription(),
                    UserRole::MODERATOR->value => UserRole::MODERATOR->getDescription(),
                    UserRole::AGENT->value => UserRole::AGENT->getDescription(),
                    UserRole::USER->value => UserRole::USER->getDescription(),
                ]),
            // TagsInput::make('email')
            //     ->placeholder('Email address')
            //     ->splitKeys(['Tab', ' '])
            //     ->nestedRecursiveRules(['email'])
            //     ->required(),
            TextInput::make('email')
                ->markAsRequired()
                ->rules(['required', 'email'])
                ->helperText('User needs to be registered that is not already a member of your organization.')
                ->rule(fn () => function ($attribute, $value, $fail) {
                    $user = User::query()
                        ->withoutGlobalScopes()
                        ->where('email', $value)
                        ->first();

                    // if (is_null($user)) {
                    //     $fail('User cannot be found.');

                    //     return;
                    // }

                    // if ($user->organization_id === Auth::user()->organization_id) {
                    //     $fail('This user is already a member of your organization.');
                    // }
                }),
            Select::make('organization')
                ->options(Organization::pluck('name', 'id'))
                ->required()
                ->searchable()
                ->visible(Filament::getCurrentPanel()->getId() === 'root')
                ->placeholder('Select an organization'),
        ]);

        $this->action(function (array $data) {
            $panel = Filament::getCurrentPanel()->getId();

            $user = User::firstWhere('email', $data['email']);

            /** @var User $authenticated */
            $authenticated = Auth::user();

            $time = now();

            $url = URL::temporarySignedRoute('filament.auth.auth.invitation-request.prompt', $time->clone()->addDay(), [
                'to' => $panel === 'root' ? $data['organization'] : $authenticated->organization_id,
                'as' => $data['role'],
                'at' => $time->timestamp,
                'referrer' => $authenticated->email,
                'recipient' => $data['email'],
            ]);

            dd($url);

            Notification::make()
                ->title('User invited')
                ->body('The user has been invited to your organization.')
                ->success()
                ->actions([AcceptInvitationAction::make()->url($url)])
                ->sendToDatabase($user);
        });
    }
}
