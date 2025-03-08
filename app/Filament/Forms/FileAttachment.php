<?php

namespace App\Filament\Forms;

use App\Models\Request;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;

class FileAttachment extends Section
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->collapsed();

        $this->collapsible();

        $this->icon('gmdi-attach-file-o');

        $this->heading('Attachments');

        $this->compact();

        $this->schema(fn (Request $request) => [
            FileUpload::make('files')
                ->hiddenLabel()
                ->storeFileNamesIn('paths')
                ->disk('local')
                ->directory("attachments/{$request->id}")
                ->visibility('private')
                ->previewable(false)
                ->multiple()
                ->maxFiles(12)
                ->moveFiles()
                ->maxSize(1024 * 12)
                ->downloadable()
                ->rule('clamav')
                ->hint('You can upload up to 12 files, each with a maximum size of 12MB.')
                ->helperText(function () {
                    $html = <<<'HTML'
                        <span class="text-sm text-custom-600 dark:text-custom-400" style="--c-400:var(--warning-400);--c-600:var(--warning-600);">
                            Files are stored for a maximum of sixty days and will be deleted after that period.
                        </span>
                    HTML;

                    return str($html)->toHtmlString();
                }),
        ]);
    }
}
