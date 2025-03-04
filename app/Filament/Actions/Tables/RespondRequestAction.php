<?php

namespace App\Filament\Actions\Tables;

use App\Enums\ActionStatus;
use App\Enums\RequestClass;
use App\Models\Request;
use Exception;
use Filament\Facades\Filament;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

class RespondRequestAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('respond-request');

        $this->label('Respond');

        $this->icon(ActionStatus::RESPONDED->getIcon());

        $this->modalIcon(ActionStatus::RESPONDED->getIcon());

        $this->modalDescription(fn (Request $request) => str('Respond to user\'s inquiry <span class="font-mono">#'.$request->code.'</span>')->toHtmlString());

        $this->slideOver();

        $this->modalWidth(MaxWidth::ExtraLarge);

        $this->successNotificationTitle(function (Request $request) {
            $pronoun = match (Filament::getCurrentPanel()->getId()) {
                'user' => 'your',
                default => 'the',
            };

            return 'You have responded to '.$pronoun.' inquiry <span class="font-mono">#'.$request->code.'</span>';
        });

        $this->form(fn (Request $request) => [
            Placeholder::make('tags')
                ->content(function () use ($request) {
                    if ($request->tags->isEmpty()) {
                        return '(none)';
                    }

                    $tags = $request->tags->map(function ($tag) {
                        return <<<HTML
                            <x-filament::badge class="w-fit" size="sm" color="{$tag->color}">
                                {$tag->name}
                            </x-filament::badge>
                        HTML;
                    })->join(PHP_EOL);

                    $html = Blade::render(<<<HTML
                        <div class="flex flex-wrap gap-2">
                            {$tags}
                        </div>
                    HTML);

                    return str($html)->toHtmlString();
                }),
            MarkdownEditor::make('response')
                ->label('Message')
                ->required(),
            Placeholder::make('responses')
                ->hidden($request->actions()->where('status', ActionStatus::RESPONDED)->doesntExist())
                ->content(view('filament.requests.history', [
                    'request' => $request,
                    'chat' => true,
                ])),
            Placeholder::make('subject')
                ->content($request->subject),
            Placeholder::make('inquiry')
                ->content(view('filament.requests.action', [
                    'content' => $request->body,
                    'chat' => true,
                ])),
        ]);

        $this->action(function (Request $request, array $data) {
            try {
                $this->beginDatabaseTransaction();

                $request->actions()->create([
                    'remarks' => $data['response'],
                    'status' => ActionStatus::RESPONDED,
                    'user_id' => Auth::id(),
                ]);

                $this->success();

                $this->commitDatabaseTransaction();
            } catch (Exception $e) {
                $this->rollBackDatabaseTransaction();

                throw $e;
            }
        });

        $this->visible(function (Request $request) {
            $valid = $request->class === RequestClass::INQUIRY && ! $request->action->status->finalized();

            return $valid && match (Filament::getCurrentPanel()->getId()) {
                'user' => $request->action->status === ActionStatus::RESPONDED,
                'moderator', 'agent' => in_array($request->action->status, [ActionStatus::RESPONDED, ActionStatus::ASSIGNED]) &&
                    $request->assignees->contains(Auth::user()),
                default => false,
            };
        });
    }
}
