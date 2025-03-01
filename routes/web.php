<?php

use App\Enums\ActionStatus;
use App\Filament\Panels\Auth\Controllers\EmailVerificationController;
use App\Filament\Panels\Auth\Pages\Approval;
use App\Filament\Panels\Auth\Pages\Deactivated;
use App\Filament\Panels\Auth\Pages\Setup;
use App\Filament\Panels\Auth\Pages\Verification;
use App\Http\Middleware\Approve;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\Verify;
use Illuminate\Support\Facades\Route;

Route::middleware(Authenticate::class)->group(function () {
    Route::get('/auth/email-verification/prompt', Verification::class)
        ->name('filament.auth.auth.email-verification.prompt');

    Route::get('/auth/account-approval/prompt', Approval::class)
        ->middleware(Verify::class)
        ->name('filament.auth.auth.account-approval.prompt');

    Route::get('/auth/deactivated-access/prompt', Deactivated::class)
        ->middleware([Verify::class, Approve::class])
        ->name('filament.auth.auth.deactivated-access.prompt');

    Route::get('/auth/email-verification/verify/{id}/{hash}', EmailVerificationController::class)
        ->name('filament.auth.auth.email-verification.verify');

    Route::get('/auth/organization-setup/prompt', Setup::class)
        ->middleware([Verify::class, Approve::class])
        ->name('filament.auth.auth.organization-setup.prompt');
});

Route::get('test', function () {
    return 'Hello World';
});
