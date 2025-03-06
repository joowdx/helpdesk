<?php

namespace App\Filament\Actions\Tables;

use App\Enums\ActionStatus;
use Filament\Tables\Actions\Action;

class ComplyRequestAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('comply-request');

        $this->label('Comply');

        $this->icon(ActionStatus::COMPLIED->getIcon());

        $this->modalIcon(ActionStatus::COMPLIED->getIcon());
    }
}
