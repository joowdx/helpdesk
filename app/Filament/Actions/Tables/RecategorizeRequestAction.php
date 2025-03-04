<?php

namespace App\Filament\Actions\Tables;

use Filament\Tables\Actions\Action;

class RecategorizeRequestAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('recategorize-request');

        $this->label('Recategorize');
    }
}
