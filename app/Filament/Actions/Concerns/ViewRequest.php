<?php

namespace App\Filament\Actions\Concerns;

use App\Enums\ActionStatus;
use App\Enums\RequestClass;
use App\Models\Request;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;

trait ViewRequest
{
    protected function bootViewRequest(): void
    {
        $this->icon('heroicon-o-eye');

        $this->label('View');

        $this->color('gray');

        $this->slideOver();

        $this->modalIcon(fn (Request $request) => $request->class->getIcon());

        $this->modalIconColor(fn (Request $request) => $request->class->getColor());

        $this->modalHeading(fn (Request $request) => str("{$request->class->getLabel()} <span class='font-mono'>#{$request->code}</span>")->toHtmlString());

        $this->modalDescription(fn (Request $request) => $request->user->name);

        $this->modalFooterActionsAlignment(Alignment::End);

        $this->modalSubmitAction(false);

        $this->modalCancelAction(false);

        $this->modalWidth(MaxWidth::ExtraLarge);

        $this->infolist(fn (Request $request) => [
            Tabs::make()
                ->contained(false)
                ->tabs([
                    Tab::make('Information')
                        ->schema([
                            TextEntry::make('tags')
                                ->hiddenLabel()
                                ->badge()
                                ->alignEnd()
                                ->hidden($request->tags->isEmpty())
                                ->color(fn (string $state) => $request->tags->first(fn ($tag) => $tag->name === $state)?->color ?? 'gray')
                                ->state($request->tags->pluck('name')->toArray()),
                            TextEntry::make('from.name')
                                ->hiddenLabel()
                                ->helperText("{$request->user->name} on {$request->submission?->created_at->format('jS \of F \a\t H:i')}"),
                            TextEntry::make('action.status')
                                ->hiddenLabel()
                                ->size(TextEntry\TextEntrySize::ExtraSmall)
                                ->state($request->action->status === ActionStatus::CLOSED ? $request->action->resolution : $request->action->status),
                            TextEntry::make('subject')
                                ->hiddenLabel()
                                ->weight(FontWeight::Bold)
                                ->size(TextEntry\TextEntrySize::Large),
                            TextEntry::make('submitted.created_at')
                                ->hiddenLabel()
                                ->color('gray')
                                ->dateTime('F j, Y \a\t H:i'),
                            ViewEntry::make('body')
                                ->label('Inquiry')
                                ->hiddenLabel(false)
                                ->view('filament.requests.show', [
                                    'request' => $request,
                                ]),
                            ViewEntry::make('responses')
                                ->visible($request->class === RequestClass::INQUIRY)
                                ->view('filament.requests.history', [
                                    'request' => $request,
                                    'chat' => true,
                                    'descending' => false,
                                ]),
                        ]),
                    Tab::make('History')
                        ->schema([
                            ViewEntry::make('history')
                                ->view('filament.requests.history', [
                                    'request' => $request,
                                    'chat' => false,
                                    'descending' => true,
                                ]),
                        ]),
                ]),
        ]);

        $this->hidden(fn (Request $request) => $request->trashed());
    }
}
