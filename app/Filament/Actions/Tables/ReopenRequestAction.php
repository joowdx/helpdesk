<?php

namespace App\Filament\Actions\Tables;

use App\Enums\ActionStatus;
use App\Models\Request;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;

class ReopenRequestAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('reopen-request');

        $this->label('Reopen');

        $this->slideOver();

        $this->icon(ActionStatus::REOPENED->getIcon());

        $this->modalIcon(ActionStatus::REOPENED->getIcon());

        $this->modalDescription('Reopen this request if you feel it was closed in error.');

        $this->modalWidth(MaxWidth::ExtraLarge);

        $this->successNotificationTitle('Request reopened');

        $this->form([
            MarkdownEditor::make('remarks')
                ->required()
                ->helperText('Please provide a brief reason for reopening this request.'),
        ]);

        $this->action(function (Request $request, array $data) {
            if ($request->action->status !== ActionStatus::COMPLETED) {
                return;
            }

            $request->actions()->create([
                'remarks' => $data['remarks'],
                'status' => ActionStatus::REOPENED,
                'user_id' => Auth::id(),
            ]);

            $this->sendSuccessNotification();
        });

        $this->visible(fn (Request $request) => $request->action->status === ActionStatus::COMPLETED);
    }
}
