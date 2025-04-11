<?php

namespace App\Filament\Actions\Concerns;

use App\Enums\ActionStatus;
use App\Enums\RequestClass;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

trait ViewRequest
{
    protected function bootViewRequest(): void
    {
        $this->icon('heroicon-o-eye');

        $this->label('View');

        $this->color('gray');

        $this->slideOver();

        $this->modalIcon(fn (Model $record) => ($record->request ?? $record->action->request ?? $record)->class->getIcon());

        $this->modalIconColor(fn (Model $record) => ($record->request ?? $record->action->request ?? $record)->class->getColor());

        $this->modalHeading(function (Model $record) {
            $record = $record->request ?? $record->action->request ?? $record;

            return str("{$record->class->getLabel()} <span class='font-mono'>#{$record->code}</span>")->toHtmlString();
        });

        $this->modalDescription(fn (Model $record) => ($record->request ?? $record->action->request ?? $record)->user->name);

        $this->modalFooterActionsAlignment(Alignment::End);

        $this->modalSubmitAction(false);

        $this->modalCancelAction(false);

        $this->modalWidth(MaxWidth::ExtraLarge);

        $this->infolist(function (Model $record) {
            $record = $record->request ?? $record->action->request ?? $record;

            return [
                TextEntry::make('tags')
                    ->hiddenLabel()
                    ->badge()
                    ->alignEnd()
                    ->hidden($record->tags->isEmpty())
                    ->color(fn (string $state) => $record->tags->first(fn ($tag) => $tag->name === $state)?->color ?? 'gray')
                    ->state($record->tags->pluck('name')->toArray()),
                TextEntry::make('from.name')
                    ->hiddenLabel()
                    ->helperText("{$record->submission?->created_at->format('jS \of F \a\t H:i')}"),
                TextEntry::make('action.status')
                    ->hiddenLabel()
                    ->state($record->action->status === ActionStatus::CLOSED ? $record->action->resolution : $record->action->status),
                TextEntry::make('subject')
                    ->hiddenLabel()
                    ->weight(FontWeight::Bold),
                Tabs::make()
                    ->contained(false)
                    ->tabs([
                        Tab::make($record->class === RequestClass::INQUIRY ? 'Replies' : 'Content')
                            ->schema([
                                ViewEntry::make('body')
                                    ->view('filament.requests.show', [
                                        'request' => $record,
                                    ]),
                                ViewEntry::make('responses')
                                    ->visible($record->class === RequestClass::INQUIRY)
                                    ->view('filament.requests.history', [
                                        'request' => $record,
                                        'chat' => true,
                                        'descending' => false,
                                    ]),
                            ]),
                        Tab::make('History')
                            ->schema([
                                ViewEntry::make('history')
                                    ->view('filament.requests.history', [
                                        'request' => $record,
                                        'chat' => false,
                                        'descending' => true,
                                    ]),
                            ]),
                    ]),
            ];
        });

        $this->hidden(fn (Model $record) => in_array(SoftDeletes::class, class_uses_recursive(($record->request ?? $record->action->request ?? $record))) && ($record->request ?? $record->action->request ?? $record)->trashed());
    }
}
