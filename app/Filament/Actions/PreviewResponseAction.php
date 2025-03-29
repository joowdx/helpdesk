<?php

namespace App\Filament\Actions;

use App\Models\Response;
use Filament\Actions\Action;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class PreviewResponseAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('preview-response');

        $this->label('Preview');

        $this->action(function (Response $response) {
            $pdf = Pdf::view('filament.responses.base', [
                'response' => $response,
            ]);

            $pdf->withBrowserShot(fn (Browsershot $browsershot) => $browsershot->noSandbox()->setOption('args', ['--disable-web-security']));

            $pdf->format('A4');

            $pdf->margins(1, 1, 1, 1, 'in');

            $pdf->headerView('filament.responses.partials.header', [
                'response' => $response,
            ]);

            $pdf->disk('local');

            $pdf->save('responses/' . $response->id . '.pdf');

            return Storage::disk('local')->download('responses/' . $response->id . '.pdf');
        });
    }
}
