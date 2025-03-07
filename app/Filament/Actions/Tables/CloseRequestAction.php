<?php

namespace App\Filament\Actions\Tables;

use App\Enums\ActionResolution;
use App\Enums\ActionStatus;
use App\Models\Request;
use Filament\Facades\Filament;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Radio;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;

class CloseRequestAction extends Action
{
    protected bool $resolvedEnabled = true;

    protected bool $remarksRequired = true;

    protected function setUp(): void
    {
        $panel = Filament::getCurrentPanel()->getId();

        parent::setUp();

        $this->name('close-request');

        $this->label('Close');

        $this->slideOver();

        $this->icon(ActionStatus::CLOSED->getIcon());

        $this->modalIcon(ActionStatus::CLOSED->getIcon());

        $this->modalHeading('Close request');

        $this->modalDescription(fn (Request $request) => $request->action->status === ActionStatus::COMPLETED ? 'This will mark the request as resolved.' : 'Closed requests cannot be reopened.');

        $this->modalWidth(MaxWidth::ExtraLarge);

        $this->closeModalByClickingAway(false);

        $this->form([
            Radio::make('resolution')
                ->options(ActionResolution::class)
                ->disableOptionWhen(fn (string $value) => $value === ActionResolution::NONE->value ?:
                    $value === ActionResolution::RESOLVED->value && ! $this->resolvedEnabled
                )
                ->columns(2)
                ->required()
                ->live()
                ->afterStateUpdated(function ($state, $old, $set) {
                    $set('remarks', ActionResolution::from($state)->remarks());
                })
                ->hidden(fn (Request $request) => $request->action->status === ActionStatus::COMPLETED),
            MarkdownEditor::make('remarks')
                ->helperText('Please provide a brief reason for closing this request.')
                ->required(function (Request $request) {
                    if ($request->action->status === ActionStatus::COMPLETED) {
                        return false;
                    }

                    return $this->remarksRequired;
                }),
        ]);

        $this->action(function (Request $request, array $data) {
            $request->actions()->create([
                'status' => ActionStatus::CLOSED,
                'resolution' => $request->action->status === ActionStatus::COMPLETED
                    ? ActionResolution::RESOLVED
                    : $data['resolution'],
                'remarks' => $data['remarks'],
                'user_id' => Auth::id(),
            ]);
        });

        $this->hidden(fn (Request $request) => $request->action->status->finalized() ?: $panel === 'user' && $request->action->status !== ActionStatus::COMPLETED);
    }

    public function requireRemarks(bool $required = true)
    {
        $this->remarksRequired = $required;

        return $this;
    }

    public function allowResolved(bool $resolvedEnabled = true)
    {
        $this->resolvedEnabled = $resolvedEnabled;

        return $this;
    }
}
