<?php

namespace App\Filament\Actions\Tables;

use App\Enums\ActionStatus;
use App\Models\Request;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;

class CompleteRequestAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('complete-request');

        $this->label('Complete');

        $this->slideOver();

        $this->icon(ActionStatus::COMPLETED->getIcon());

        $this->modalIcon(ActionStatus::COMPLETED->getIcon());

        $this->modalHeading('Complete Request');

        $this->modalDescription('Mark this request as completed. Requester may reopen this request if needed.');

        $this->modalWidth(MaxWidth::ExtraLarge);

        $this->modalSubmitActionLabel('Confirm');

        $this->successNotificationTitle('Request completed');

        $this->form([
            MarkdownEditor::make('remarks')
                ->helperText('Please describe the reason for suspending this request.'),
        ]);

        $this->action(function (Request $request, array $data) {
            $request->actions()->create([
                'status' => ActionStatus::COMPLETED,
                'user_id' => Auth::id(),
                'remarks' => $data['remarks'],
            ]);

            $this->sendSuccessNotification();
        });

        $this->visible(fn (Request $request) => in_array($request->action->status, [ActionStatus::STARTED, ActionStatus::REOPENED]));
    }
}
