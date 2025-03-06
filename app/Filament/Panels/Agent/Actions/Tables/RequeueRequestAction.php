<?php

namespace App\Filament\Panels\Agent\Actions\Tables;

use App\Enums\ActionStatus;
use App\Enums\UserRole;
use App\Models\Request;
use Filament\Facades\Filament;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;

class RequeueRequestAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('requeue');

        $this->slideOver();

        $this->color(ActionStatus::QUEUED->getColor());

        $this->icon(ActionStatus::QUEUED->getIcon());

        $this->modalIcon(ActionStatus::QUEUED->getIcon());

        $this->modalDescription('Please provide a valid reason for requeueing this request.');

        $this->modalWidth(MaxWidth::ExtraLarge);

        $this->successNotificationTitle('Requeued');

        $this->form([
            MarkdownEditor::make('remarks')
                ->label('Reason')
                ->required(Filament::getCurrentPanel()->getId() === 'agent'),
        ]);

        $this->action(function (Request $request, array $data) {
            if ($request->action->status !== ActionStatus::ASSIGNED) {
                return;
            }

            $request->assignees()->detach();

            $request->actions()->create([
                'remarks' => $data['remarks'],
                'status' => ActionStatus::QUEUED,
                'user_id' => Auth::id(),
            ]);

            $this->sendSuccessNotification();
        });

        $this->closeModalByClickingAway(false);

        $this->hidden(fn (Request $request) => $request->action->status->finalized() ?: $request->action->status === ActionStatus::QUEUED);

        $this->visible(fn (Request $request) => in_array(Auth::user()->role, [UserRole::ADMIN, UserRole::MODERATOR]) ?:
            $request->declination === true &&
            $request->assignees()->count() === 1 &&
            $request->action->status === ActionStatus::ASSIGNED,
        );
    }
}
