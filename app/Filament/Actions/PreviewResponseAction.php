<?php

namespace App\Filament\Actions;

use App\Actions\GenerateResponse;
use App\Models\Response;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Storage;

class PreviewResponseAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('preview-response');

        $this->label('Preview');

        $this->keyBindings(['ctrl+p']);

        $this->slideOver();

        $this->modalSubmitAction(false);

        $this->modalCancelActionLabel('Close');

        $this->modalContent(function (Response $response) {
            $path = 'responses/'.$response->id.'-preview.pdf';

            if (file_exists(Storage::path($path)) && hash_file('sha256', Storage::path($path)) === $response->hash) {
                $link = Storage::temporaryUrl($path, now()->addMinutes(5));

                $view = <<<HTML
                    <iframe
                        class="rounded-lg"
                        src="{$link}"
                        style="width: 100%; height: 100%; border: none;"
                        allowfullscreen
                        allow="fullscreen"
                    ></iframe>
                HTML;

                return str($view)->toHtmlString();
            }

            (new GenerateResponse)($response, $path, true);

            $response->update(['hash' => hash_file('sha256', Storage::path($path))]);

            $link = Storage::temporaryUrl($path, now()->addMinutes(5));

            $view = <<<HTML
                <iframe
                    src="{$link}"
                    class="rounded-lg"
                    style="width: 100%; height: 100%; border: none;"
                ></iframe>
            HTML;

            return str($view)->toHtmlString();
        });

        $this->disabled(fn (Response $response) => $response->submitted);
    }
}
