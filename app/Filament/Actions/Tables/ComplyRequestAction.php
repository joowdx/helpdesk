<?php

namespace App\Filament\Actions\Tables;

use App\Enums\ActionStatus;
use App\Models\Request;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;

class ComplyRequestAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('comply-request');

        $this->label('Comply');

        $this->icon(ActionStatus::COMPLIED->getIcon());

        $this->modalIcon(ActionStatus::COMPLIED->getIcon());

        $this->successNotificationTitle('Action success');

        $this->form([
            MarkdownEditor::make('remarks')
                ->required(),
        ]);

        $this->action(function (Request $request, array $data) {
            if ($request->action->status !== ActionStatus::SUSPENDED) {
                return;
            }

            $request->actions()->create([
                'status' => ActionStatus::COMPLIED,
                'user_id' => Auth::id(),
                'remarks' => $data['remarks'],
            ]);

            $this->sendSuccessNotification();
        });

        $this->visible(function (Request $request) {
            return $request->action->status === ActionStatus::SUSPENDED;
        });
    }
}
