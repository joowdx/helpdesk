<?php

namespace App\Filament\Actions\Tables;

use App\Enums\ActionStatus;
use App\Models\Request;
use Filament\Tables\Actions\Action;

class UnsuspendRequestAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('unsuspend-request');

        $this->label('Unsuspend');

        $this->icon('gmdi-change-circle-o');

        $this->modalIcon('gmdi-change-circle-o');

        $this->requiresConfirmation();

        $this->modalHeading('Undo suspension');

        $this->modalDescription('Are you sure you want to undo the suspension?');

        $this->successNotificationTitle('Request unsuspended');

        $this->action(function (Request $request) {
            if ($request->action->status !== ActionStatus::SUSPENDED) {
                return;
            }

            $request->action()->delete();

            $this->sendSuccessNotification();
        });

        $this->visible(fn (Request $request) => $request->action->status === ActionStatus::SUSPENDED && $request->action->created_at->addMinutes(15)->greaterThan(now()));
    }
}
