<?php

namespace App\Filament\Panels\Auth\Pages;

use App\Enums\UserRole;
use App\Filament\Panels\Auth\Concerns\BaseAuthPage;
use App\Http\Middleware\Active;
use App\Http\Middleware\Approve;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\Verify;
use App\Models\Organization;
use App\Models\User;
use Exception;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\SimplePage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Url;
use ValueError;

class Invitation extends SimplePage implements HasMiddleware
{
    use BaseAuthPage;

    #[Locked,Url]
    public string $as;

    #[Locked,Url]
    public string $at;

    #[Locked,Url]
    public string $recipient;

    #[Locked,Url]
    public string $referrer;

    #[Locked,Url]
    public string $to;

    protected static bool $shouldRegisterNavigation = false;

    protected static string $layout = 'filament-panels::components.layout.base';

    protected static string $view = 'filament.panels.auth.pages.invitation';

    protected ?string $maxWidth = 'xl';

    public static function getSlug(): string
    {
        return 'invitation-request/prompt';
    }

    public static function getRelativeRouteName(): string
    {
        return 'auth.invitation-request.prompt';
    }

    public static function middleware(): array
    {
        return [
            Authenticate::class,
            Verify::class,
            Approve::class,
            Active::class,
        ];
    }

    #[Computed]
    public function as(): UserRole
    {
        try {
            return UserRole::from($this->as);
        } catch (ValueError) {
            abort(404);
        }
    }

    #[Computed]
    public function at(?string $format = null): Carbon|string
    {
        $time = Carbon::parse((int) $this->at);

        return match ($format) {
            null => $time,
            default => $time->format($format),
        };
    }

    #[Computed]
    public function recipient(): ?User
    {
        return User::firstWhere('email', $this->recipient);
    }

    #[Computed]
    public function referrer(): ?User
    {
        return User::firstWhere('email', $this->recipient);
    }

    #[Computed]
    public function to(): ?Organization
    {
        return Organization::findOrFail($this->to);
    }

    public function acceptAction(): Action
    {
        return Action::make('accept')
            ->icon('heroicon-o-check')
            ->requiresConfirmation()
            ->modalIcon('heroicon-o-check-badge')
            ->modalHeading('Accept Invitation')
            ->modalDescription('You are about to accept the invitation. If you are in under different organization, you will be removed from it.')
            ->action(function () {
                try {
                    DB::transaction(function () {
                        /** @var User $user */
                        $user = Auth::user();

                        $user->approvedBy()->associate($this->referrer);
                        $user->organization()->associate($this->to);
                        $user->approved_at = now();
                        $user->role = $this->as;
                        $user->save();
                    });

                    Notification::make()
                        ->title('Invitation Accepted')
                        ->success()
                        ->send();

                    return redirect()->route("filament.{$this->as}.pages.dashboard");
                } catch (Exception $ex) {
                    Notification::make()
                        ->title('Invitation Failed')
                        ->danger()
                        ->send();
                }
            });
    }

    public static function registerNavigationItems(): null
    {
        return null;
    }
}
