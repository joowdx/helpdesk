<?php

namespace App\Filament\Actions;

use App\Actions\GenerateResponse;
use App\Models\Response;
use Exception;
use Filament\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SubmitResponseAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('submit-response');

        $this->label(fn (Response $response) => $response->submitted ? 'Withdraw' : 'Submit');

        $this->keyBindings(['ctrl+alt+s']);

        $this->modalSubmitActionLabel('Confirm');

        $this->modalWidth(MaxWidth::Large);

        $this->successNotificationTitle(function (Response $response) {
            return $response->submitted
                ? 'Document is now awaiting for signers to sign the document.'
                : 'Document submission is withdrawn.';
        });

        $this->failureNotificationTitle(function (Response $response) {
            return $response->submitted
                ? 'Response submission failed.'
                : 'Response withdrawal failed.';
        });

        $this->modalDescription(function (Response $response) {
            $help = $response->submitted
                ? <<<'HTML'
                    <strong>Note:</strong> <br>
                    This action will delete the generated document including the all signatures.
                HTML
                : <<<'HTML'
                    <strong>Note:</strong> <br>
                    This action will generate a document and ask for signatures from
                    all signers before the response will be received by the other party.
                HTML;

            return str($help)->toHtmlString();
        });

        $this->action(function (Response $response) {
            $submitted = $response->submitted;

            try {
                $this->beginDatabaseTransaction();

                $response->update([
                    'submitted' => ! $submitted,
                    'user_id' => $submitted ? null : Auth::id(),
                ]);

                if (! $submitted) {

                    $path = "attachments/{$response->code}.pdf";

                    app(GenerateResponse::class)($response, $path, false);

                    $response->attachment()->create([
                        'files' => [$path],
                        'paths' => collect([$path])->mapWithKeys(fn ($path) => [$path => $response->code.'.pdf'])->toArray(),
                    ]);

                    $signers = collect($response->content)
                        ->filter(fn ($content) => $content['type'] === 'signatories')
                        ->map->data
                        ->flatMap->signers
                        ->pluck('user');

                    $response->users()->sync($signers->unique());
                } else {
                    $response->attachment?->delete();

                    $response->users()->sync([]);
                }

                $this->commitDatabaseTransaction();

                $this->success();
            } catch (Exception $ex) {
                $this->rollBackDatabaseTransaction();

                $this->failure();

                throw $ex;
            }

            $this->redirect(fn (Component $livewire) => $livewire->getResource()::getUrl($submitted ? 'edit' : 'view', ['record' => $response->id]));
        });
    }
}
