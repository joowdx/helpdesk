<?php

namespace App\Filament\Clusters\Requests\Resources;

use App\Enums\RequestClass;
use App\Enums\UserRole;
use App\Filament\Actions\Tables\CloseRequestAction;
use App\Filament\Actions\Tables\DeleteRequestAction;
use App\Filament\Actions\Tables\RejectRequestAction;
use App\Filament\Actions\Tables\RespondRequestAction;
use App\Filament\Actions\Tables\RestoreRequestAction;
use App\Filament\Actions\Tables\ShowRequestAction;
use App\Filament\Actions\Tables\ViewRequestHistoryAction;
use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListSuggestions;
use App\Filament\Panels\Moderator\Actions\Tables\AssignRequestAction;
use App\Filament\Resources\RequestResource;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Support\Facades\Auth;

class SuggestionResource extends RequestResource
{
    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    protected static ?string $label = 'Suggestions';

    protected static ?RequestClass $class = RequestClass::SUGGESTION;

    public static function getPages(): array
    {
        return [
            'index' => ListSuggestions::route('/'),
        ];
    }

    public static function tableActions(): array
    {
        return match (Auth::user()->role) {
            UserRole::ROOT => [
                RestoreRequestAction::make(),
                ShowRequestAction::make()
                    ->hidden(false),
                ViewRequestHistoryAction::make()
                    ->hidden(false),
                ActionGroup::make([
                    DeleteRequestAction::make()
                        ->hidden(false),
                ]),
            ],
            UserRole::MODERATOR => [
                RespondRequestAction::make(),
                AssignRequestAction::make(),
                ShowRequestAction::make(),
                ViewRequestHistoryAction::make(),
                ActionGroup::make([
                    RejectRequestAction::make(),
                    CloseRequestAction::make()
                        ->requireRemarks(false),
                ]),
            ],
            UserRole::AGENT => [
                RespondRequestAction::make(),
                ShowRequestAction::make(),
                ViewRequestHistoryAction::make(),
                ActionGroup::make([
                    RejectRequestAction::make(),
                    CloseRequestAction::make()
                        ->requireRemarks(false),
                ]),
            ],
            default => parent::tableActions(),
        };
    }
}
