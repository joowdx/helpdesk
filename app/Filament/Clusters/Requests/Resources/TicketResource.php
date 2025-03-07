<?php

namespace App\Filament\Clusters\Requests\Resources;

use App\Enums\RequestClass;
use App\Filament\Actions\Tables\CloseRequestAction;
use App\Filament\Actions\Tables\RecategorizeRequestAction;
use App\Filament\Actions\Tables\ReclassifyRequestAction;
use App\Filament\Actions\Tables\RejectRequestAction;
use App\Filament\Actions\Tables\ShowRequestAction;
use App\Filament\Actions\Tables\SuspendRequestAction;
use App\Filament\Actions\Tables\TagRequestAction;
use App\Filament\Actions\Tables\UnsuspendRequestAction;
use App\Filament\Actions\Tables\ViewRequestHistoryAction;
use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListTickets;
use App\Filament\Panels\Agent\Actions\Tables\RequeueRequestAction;
use App\Filament\Panels\Agent\Actions\Tables\StartRequestAction;
use App\Filament\Panels\Moderator\Actions\Tables\AssignRequestAction;
use App\Filament\Panels\Moderator\Actions\Tables\QueueRequestAction;
use App\Filament\Resources\RequestResource;
use Filament\Facades\Filament;
use Filament\Tables\Actions\ActionGroup;

class TicketResource extends RequestResource
{
    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $label = 'Tickets';

    protected static ?RequestClass $class = RequestClass::TICKET;

    public static function getPages(): array
    {
        return [
            'index' => ListTickets::route('/'),
        ];
    }

    public static function tableActions(): array
    {
        return match (Filament::getCurrentPanel()->getId()) {
            'admin' => static::$inbound ? [
                StartRequestAction::make(),
                QueueRequestAction::make(),
                SuspendRequestAction::make(),
                UnsuspendRequestAction::make(),
                ShowRequestAction::make(),
                ViewRequestHistoryAction::make(),
                ActionGroup::make([
                    TagRequestAction::make(),
                    AssignRequestAction::make(),
                    RequeueRequestAction::make(),
                    RejectRequestAction::make(),
                    RecategorizeRequestAction::make(),
                    ReclassifyRequestAction::make(),
                    CloseRequestAction::make()
                        ->requireRemarks(false),
                ]),
            ] : [
                ShowRequestAction::make(),
                ViewRequestHistoryAction::make(),
            ],
            'moderator' => [
                StartRequestAction::make(),
                QueueRequestAction::make(),
                SuspendRequestAction::make(),
                UnsuspendRequestAction::make(),
                ShowRequestAction::make(),
                ViewRequestHistoryAction::make(),
                ActionGroup::make([
                    TagRequestAction::make(),
                    AssignRequestAction::make(),
                    RequeueRequestAction::make(),
                    RejectRequestAction::make(),
                    RecategorizeRequestAction::make(),
                    ReclassifyRequestAction::make(),
                    CloseRequestAction::make()
                        ->allowResolved(false)
                        ->requireRemarks(false),
                ]),
            ],
            'agent' => [
                StartRequestAction::make(),
                SuspendRequestAction::make(),
                UnsuspendRequestAction::make(),
                ShowRequestAction::make(),
                ViewRequestHistoryAction::make(),
                ActionGroup::make([
                    TagRequestAction::make(),
                    RequeueRequestAction::make(),
                    RejectRequestAction::make(),
                    RecategorizeRequestAction::make(),
                    ReclassifyRequestAction::make(),
                    CloseRequestAction::make()
                        ->allowResolved(false),
                ]),
            ],
            default => parent::tableActions(),
        };
    }
}
