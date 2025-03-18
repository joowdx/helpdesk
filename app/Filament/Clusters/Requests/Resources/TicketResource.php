<?php

namespace App\Filament\Clusters\Requests\Resources;

use App\Enums\RequestClass;
use App\Filament\Actions\Tables\AssignRequestAction;
use App\Filament\Actions\Tables\CloseRequestAction;
use App\Filament\Actions\Tables\CompleteRequestAction;
use App\Filament\Actions\Tables\QueueRequestAction;
use App\Filament\Actions\Tables\RecategorizeRequestAction;
use App\Filament\Actions\Tables\ReclassifyRequestAction;
use App\Filament\Actions\Tables\RejectRequestAction;
use App\Filament\Actions\Tables\RequeueRequestAction;
use App\Filament\Actions\Tables\ShowRequestAction;
use App\Filament\Actions\Tables\StartRequestAction;
use App\Filament\Actions\Tables\SuspendRequestAction;
use App\Filament\Actions\Tables\TagRequestAction;
use App\Filament\Actions\Tables\UndoRecentAction;
use App\Filament\Actions\Tables\ViewRequestHistoryAction;
use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListTickets;
use App\Filament\Resources\RequestResource;
use Filament\Facades\Filament;
use Filament\Tables\Actions\ActionGroup;

class TicketResource extends RequestResource
{
    public static ?RequestClass $class = RequestClass::TICKET;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?int $navigationSort = -2;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    protected static ?string $label = 'Tickets';

    public static function getPages(): array
    {
        return [
            'index' => ListTickets::route('/'),
        ];
    }

    public static function tableActions(): array
    {
        $panel = Filament::getCurrentPanel()->getId();

        return match (static::$inbound) {
            true => match ($panel) {
                'admin', 'moderator' => [
                    StartRequestAction::make(),
                    CompleteRequestAction::make(),
                    QueueRequestAction::make(),
                    UndoRecentAction::make(),
                    ShowRequestAction::make(),
                    ViewRequestHistoryAction::make(),
                    ActionGroup::make([
                        TagRequestAction::make(),
                        SuspendRequestAction::make(),
                        AssignRequestAction::make(),
                        RequeueRequestAction::make(),
                        RejectRequestAction::make(),
                        RecategorizeRequestAction::make(),
                        ReclassifyRequestAction::make(),
                        CloseRequestAction::make()
                            ->requireRemarks(false),
                    ]),
                ],
                'agent' => [
                    StartRequestAction::make(),
                    CompleteRequestAction::make(),
                    UndoRecentAction::make(),
                    ShowRequestAction::make(),
                    ViewRequestHistoryAction::make(),
                    ActionGroup::make([
                        TagRequestAction::make(),
                        SuspendRequestAction::make(),
                        RequeueRequestAction::make(),
                        RejectRequestAction::make(),
                        RecategorizeRequestAction::make(),
                        ReclassifyRequestAction::make(),
                        CloseRequestAction::make()
                            ->allowResolved(false),
                    ]),
                ],
                default => parent::tableActions(),
            },
            default => [
                ShowRequestAction::make(),
                ViewRequestHistoryAction::make(),
            ],
        };
    }
}
