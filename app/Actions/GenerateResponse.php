<?php

namespace App\Actions;

use App\Enums\PaperSize;
use App\Models\Response;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class GenerateResponse
{
    public function __invoke(Response $response, string $path, bool $preview = false): void
    {
        $url = config('app.url') . '/verification/' . $response->code;

        $qr = (new GenerateQrCode)('this is for drafting purposes only', 96);

        /** @var \Spatie\LaravelPdf\PdfBuilder $pdf */
        $pdf = Pdf::view('filament.responses.print', [
            'response' => $response,
        ]);

        $pdf->headerView('filament.responses.partials.header', [
            'response' => $response,
            'qr' => $qr,
            'final' => !(bool) $preview,
        ]);

        $pdf->footerView('filament.responses.partials.footer', [
            'response' => $response,
            'url' => $url,
        ]);

        $pdf->withBrowsershot(function (Browsershot $browsershot) {
            $browsershot->writeOptionsToFile();

            $browsershot->waitUntilNetworkIdle();

            $browsershot->noSandbox();

            $browsershot->setOption('args', ['--disable-web-security']);
        });

        $pdf->paperSize(...array_merge(PaperSize::tryFrom($response->options['size'] ?? 'a4')->getDimensions(), ['in']));

        $pdf->margins(...$this->margins($response->options['margins'] ?? '1 1 1 1'));

        $pdf->disk('local');

        $pdf->save($path);
    }

    protected function margins(string $margins): array
    {
        $margins = array_map('floatval', explode(' ', $margins));

        $margins[0] = 0.6 + $margins[0];

        $margins[2] = 0.6 + $margins[2];

        return array_merge($margins, ['in']);
    }
}
