<?php

namespace App\Filament\Actions\Tables;

use App\Enums\ActionStatus;
use App\Enums\RequestClass;
use App\Models\Request;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;

class SuspendRequestAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('suspend-request');

        $this->label('Suspend');

        $this->icon(ActionStatus::SUSPENDED->getIcon());

        $this->modalIcon(ActionStatus::SUSPENDED->getIcon());

        $this->slideOver();

        $this->modalHeading('Suspend Request');

        $this->modalDescription('Suspend this on-going request. This will hold the request until requester complies with the requirements.');

        $this->modalWidth(MaxWidth::ExtraLarge);

        $this->closeModalByClickingAway(false);

        $this->modalSubmitActionLabel('Confirm');

        $this->successNotificationTitle('Request suspended');

        $this->form([
            MarkdownEditor::make('remarks')
                ->label('Reason')
                ->required()
                ->helperText('Please describe the reason for suspending this request.'),
        ]);

        $this->action(function (Request $request, array $data) {
            if ($request->class !== RequestClass::TICKET || $request->action->status === ActionStatus::SUSPENDED) {
                return;
            }

            $request->actions()->create([
                'status' => ActionStatus::SUSPENDED,
                'user_id' => Auth::id(),
                'remarks' => $data['remarks'],
            ]);

            $this->sendSuccessNotification();
        });

        $this->visible(function (Request $request) {
            if ($request->action->status->finalized() || $request->action->status === ActionStatus::SUSPENDED) {
                return false;
            }

            return in_array($request->action->status, [ActionStatus::STARTED, ActionStatus::COMPLIED]) && match ($request->class) {
                RequestClass::TICKET => $request->assignees->contains(Auth::user()),
                default => false,
            };
        });
    }
}
