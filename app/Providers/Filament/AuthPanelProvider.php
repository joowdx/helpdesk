<?php

namespace App\Providers\Filament;

use App\Filament\Panels\Auth\Pages\Login;
use App\Filament\Panels\Auth\Pages\Redirect;
use App\Filament\Panels\Auth\Pages\Registration;
use App\Http\Middleware\Approve;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\Verify;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AuthPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('auth')
            ->path('auth')
            ->homeUrl('/')
            ->brandLogo(fn () => view('banner'))
            ->font('Urbanist')
            ->login(Login::class)
            ->registration(Registration::class)
            ->revealablePasswords(false)
            ->colors([...Color::all(), 'gray' => Color::Neutral])
            ->discoverPages(in: app_path('Filament/Panels/Auth/Pages'), for: 'App\\Filament\\Panels\\Auth\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([Redirect::class])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
                Verify::class,
                Approve::class,
            ])
            ->maxContentWidth(MaxWidth::ScreenTwoExtraLarge)
            ->databaseTransactions()
            ->topNavigation()
            ->spa();
    }
}
