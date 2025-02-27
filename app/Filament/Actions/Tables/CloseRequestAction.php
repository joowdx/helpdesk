<?php

namespace App\Filament\Actions\Tables;

use App\Enums\ActionResolution;
use App\Enums\ActionStatus;
use App\Models\Request;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Radio;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;

class CloseRequestAction extends Action
{
    protected bool $remarksRequired = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->name('close-request');

        $this->label('Close');

        $this->icon(ActionStatus::CLOSED->getIcon());

        $this->modalIcon(ActionStatus::CLOSED->getIcon());

        $this->modalHeading('Close request');

        $this->modalDescription('Closed requests cannot be reopened.');

        $this->modalWidth(MaxWidth::ExtraLarge);

        $this->form([
            Radio::make('resolution')
                ->options(ActionResolution::class)
                ->disableOptionWhen(fn (string $value) => $value === ActionResolution::NONE->value)
                ->columns(2)
                ->required()
                ->live()
                ->afterStateUpdated(function ($state, $old, $set) {
                    $set('remarks', ActionResolution::from($state)->remarks());
                }),
            MarkdownEditor::make('remarks')
                ->helperText('Please provide a brief reason for closing this request.')
                ->required(fn () => $this->remarksRequired),
        ]);

        $this->action(function (Request $request, array $data) {
            $request->actions()->create([
                'status' => ActionStatus::CLOSED,
                'resolution' => $data['resolution'],
                'remarks' => $data['remarks'],
                'user_id' => Auth::id(),
            ]);
        });

        $this->hidden(fn (Request $request) => $request->action->status->finalized());
    }

    public function requireRemarks(bool $required = true)
    {
        $this->remarksRequired = $required;

        return $this;
    }
}
