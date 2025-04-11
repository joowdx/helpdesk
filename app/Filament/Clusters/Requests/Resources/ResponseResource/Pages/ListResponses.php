<?php

namespace App\Filament\Clusters\Requests\Resources\ResponseResource\Pages;

use App\Enums\ActionStatus;
use App\Filament\Actions\Concerns\Notifications\CanNotifyUsers;
use App\Filament\Clusters\Requests\Resources\ResponseResource;
use App\Filament\Forms\FileAttachment;
use App\Models\Document;
use App\Models\Request;
use App\Models\Response;
use Exception;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\CanUseDatabaseTransactions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Concerns\EvaluatesClosures;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use LSNepomuceno\LaravelA1PdfSign\Exceptions\HasNoSignatureOrInvalidPkcs7Exception;
use LSNepomuceno\LaravelA1PdfSign\Sign\ValidatePdfSignature;

class ListResponses extends ListRecords
{
    use CanNotifyUsers, CanUseDatabaseTransactions, EvaluatesClosures;

    protected static ?ActionStatus $requestAction = ActionStatus::RESPONDED;

    protected static string $resource = ResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('create')
                ->label('New response')
                ->slideOver()
                ->modalWidth(MaxWidth::ExtraLarge)
                ->form([
                    Select::make('document_id')
                        ->label('Document')
                        ->relationship('document', 'name')
                        ->searchable(['name', 'description'])
                        ->preload()
                        ->getOptionLabelFromRecordUsing(fn (Document $document) => "{$document->name}")
                        ->required(),
                    Select::make('request_id')
                        ->label('Request')
                        ->relationship('action.request', 'code')
                        ->searchable(['code', 'subject'])
                        ->preload()
                        ->getOptionLabelFromRecordUsing(fn (Request $request) => "#{$request->code} — {$request->subject}")
                        ->required(),
                    FileAttachment::make('file')
                        ->heading('File')
                        ->description('Attach a signed pdf file or draft your response')
                        ->collapsed(false)
                        ->component(function (FileUpload $component) {
                            $component->hint('File must have a maximum size of 12MB.');

                            $component->helperText('You can upload a single file that is signed with a PKCS#7 signature.');

                            $component->acceptedFileTypes(['application/pdf']);

                            $component->directory('responses');

                            $component->maxFiles(1);

                            $component->rule(fn () => function (string $attribute, TemporaryUploadedFile $value, $fail) {
                                try {
                                    ValidatePdfSignature::from($value->getPathname());
                                } catch (HasNoSignatureOrInvalidPkcs7Exception $exception) {
                                    $fail($exception->getMessage());
                                }
                            });
                        }),
                ])
                ->action(function (array $data) {
                    if (is_null($data['files']) || empty ($data['files'])) {
                        return $this->redirect(URL::signedRoute(
                            'filament.'.Filament::getCurrentPanel()->getId().'.requests.resources.responses.create',
                            ['document' => $data['document_id'], 'request' => $data['request_id']],
                        ));
                    }

                    try {
                        $request = Request::findOrFail($data['request_id']);

                        $this->beginDatabaseTransaction();

                        $action = $request->actions()->create([
                            'status' => ActionStatus::RESPONDED,
                            'user_id' => Auth::id(),
                        ]);

                        $response = Response::create([
                            'file' => true,
                            'user_id' => Auth::id(),
                            'document_id' => $data['document_id'],
                            'action_id' => $action->id,
                            'issued_at' => now(),
                        ]);

                        $attachment = $response->attachment()->create([
                            'files' => $data['files'],
                            'paths' => $data['paths'],
                        ]);

                        $this->commitDatabaseTransaction();

                        Notification::make()
                            ->title('Response issued')
                            ->success()
                            ->send();

                        $this->notifyUsers($request, [...$data, 'attachment' => $attachment->id]);
                    } catch (Exception $ex) {
                        $this->rollbackDatabaseTransaction();

                        throw $ex;

                        Notification::make()
                            ->title('Response failed')
                            ->success()
                            ->send();
                    }
                }),
        ];
    }
}
