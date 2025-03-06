<?php

namespace App\Filament\Actions\Tables;

use App\Enums\ActionStatus;
use App\Enums\UserRole;
use App\Models\Request;
use App\Models\User;
use Exception;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;

class RejectRequestAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('reject-request');

        $this->label('Reject');

        $this->slideOver();

        $this->color(ActionStatus::REJECTED->getColor());

        $this->icon(ActionStatus::REJECTED->getIcon());

        $this->modalIcon(ActionStatus::REJECTED->getIcon());

        $this->modalDescription('Reject this request assignment.');

        $this->modalWidth(MaxWidth::ExtraLarge);

        $this->form([
            MarkdownEditor::make('remarks')
                ->label('Reason')
                ->required()
                ->helperText('Please provide a valid reason for rejecting this request assignment.'),
        ]);

        $this->action(function (Request $request, array $data) {
            if ($request->action->status !== ActionStatus::ASSIGNED) {
                return;
            }

            $request->assignees()->detach(Auth::id());

            $request->actions()->create([
                'remarks' => $data['remarks'],
                'status' => ActionStatus::REJECTED,
                'user_id' => Auth::id(),
            ]);
        });

        $this->closeModalByClickingAway(false);

        $this->visible(fn (Request $request) =>
            $request->declination &&
            $request->assignees->first(fn (User $user) => $user->id === Auth::id()) &&
            $request->assignees->count() > 1 &&
            $request->action->status === ActionStatus::ASSIGNED,
        );
    }
}
