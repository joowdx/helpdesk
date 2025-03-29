<?php

namespace App\Filament\Actions;

use App\Actions\GenerateQrCode;
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
            $qr = app(GenerateQrCode::class)((string) url($response->code), 96);

            $pdf = Pdf::view('filament.responses.base', [
                'response' => $response,
                'qr' => $qr,
            ]);

            $pdf->withBrowserShot(fn (Browsershot $browsershot) => $browsershot->noSandbox()->setOption('args', ['--disable-web-security']));

            $pdf->format('A4');

            $pdf->margins(1, 1, 1, 1, 'in');

            $pdf->headerView('filament.responses.partials.header', [
                'response' => $response,
                'qr' => $qr,
            ]);

            $pdf->disk('local');

            $pdf->save('responses/' . $response->id . '.pdf');

            return Storage::disk('local')->download('responses/' . $response->id . '.pdf');
        });
    }
}
