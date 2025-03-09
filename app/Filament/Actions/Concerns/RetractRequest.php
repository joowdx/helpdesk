<?php

namespace App\Filament\Actions\Concerns;

use App\Enums\ActionStatus;
use App\Models\Request;
use Illuminate\Support\Facades\Auth;

trait RetractRequest
{
    private static int $duration = 15;

    protected function bootRetractRequest()
    {
        $this->name('retract-request');

        $this->icon(ActionStatus::RETRACTED->getIcon());

        $this->requiresConfirmation();

        $this->modalHeading('Retract request');

        $this->modalDescription('For ' . static::$duration.' minutes since the last submission, you can cancel it. This will allow you to make changes before resubmitting. Are you sure you want to recall this request?');

        $this->modalIcon(ActionStatus::RETRACTED->getIcon());

        $this->successNotificationTitle('Request retracted');

        $this->action(function (Request $request) {
            $request->actions()->create(['user_id' => Auth::id(), 'status' => ActionStatus::RETRACTED]);

            $this->sendSuccessNotification();
        });

        $this->visible(fn (Request $request) => $request->action?->status === ActionStatus::SUBMITTED && $request->action->created_at->addMinutes(static::$duration)->greaterThan(now()));
    }
}
