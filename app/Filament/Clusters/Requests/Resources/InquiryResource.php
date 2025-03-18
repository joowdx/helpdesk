<?php

namespace App\Filament\Clusters\Requests\Resources;

use App\Enums\RequestClass;
use App\Filament\Actions\Tables\AssignRequestAction;
use App\Filament\Actions\Tables\CloseRequestAction;
use App\Filament\Actions\Tables\CompleteRequestAction;
use App\Filament\Actions\Tables\DeleteRequestAction;
use App\Filament\Actions\Tables\RecategorizeRequestAction;
use App\Filament\Actions\Tables\ReclassifyRequestAction;
use App\Filament\Actions\Tables\ReopenRequestAction;
use App\Filament\Actions\Tables\RespondRequestAction;
use App\Filament\Actions\Tables\RetractRequestAction;
use App\Filament\Actions\Tables\ShowRequestAction;
use App\Filament\Actions\Tables\TagRequestAction;
use App\Filament\Actions\Tables\UpdateRequestAction;
use App\Filament\Actions\Tables\ViewRequestHistoryAction;
use App\Filament\Clusters\Requests\Resources\RequestResource\Pages\ListInquiries;
use App\Filament\Resources\RequestResource;
use Filament\Facades\Filament;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ForceDeleteAction;

class InquiryResource extends RequestResource
{
    public static ?RequestClass $class = RequestClass::INQUIRY;

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $label = 'Inquiries';

    public static function getPages(): array
    {
        return [
            'index' => ListInquiries::route('/'),
        ];
    }

    public static function tableActions(): array
    {
        $moderator = [
            CompleteRequestAction::make(),
            RespondRequestAction::make(),
            AssignRequestAction::make(),
            ShowRequestAction::make(),
            ViewRequestHistoryAction::make(),
            ActionGroup::make([
                TagRequestAction::make(),
                RecategorizeRequestAction::make(),
                ReclassifyRequestAction::make(),
                CloseRequestAction::make()
                    ->requireRemarks(false),
            ]),
        ];

        return match (Filament::getCurrentPanel()->getId()) {
            'admin' => static::$inbound ? $moderator : [
                ShowRequestAction::make(),
                ViewRequestHistoryAction::make(),
            ],
            'moderator' => $moderator,
            'agent' => [
                CompleteRequestAction::make(),
                RespondRequestAction::make(),
                ShowRequestAction::make(),
                ViewRequestHistoryAction::make(),
                ActionGroup::make([
                    TagRequestAction::make(),
                    RecategorizeRequestAction::make(),
                    ReclassifyRequestAction::make(),
                    CloseRequestAction::make()
                        ->allowResolved(false)
                        ->requireRemarks(false),
                ]),
            ],
            'user' => [
                RespondRequestAction::make(),
                ShowRequestAction::make(),
                ViewRequestHistoryAction::make(),
                ActionGroup::make([
                    ReopenRequestAction::make(),
                    UpdateRequestAction::make(),
                    RetractRequestAction::make()
                        ->label('Retract'),
                    DeleteRequestAction::make(),
                    ForceDeleteAction::make()
                        ->label('Delete'),
                ]),
            ],
            default => parent::tableActions(),
        };
    }
}
