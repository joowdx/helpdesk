<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ActionStatus: string implements HasColor, HasDescription, HasIcon, HasLabel
{
    case STALE = 'stale';
    case RESTORED = 'restored';
    case TRASHED = 'trashed';
    case UPDATED = 'updated';
    case APPROVED = 'approved';
    case COMPLETED = 'completed';
    case STARTED = 'started';
    case SUBMITTED = 'submitted';
    case RETRACTED = 'retracted';
    case QUEUED = 'queued';
    case SUSPENDED = 'suspended';
    case ASSIGNED = 'assigned';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case COMPLIED = 'complied';
    case VERIFIED = 'verified';
    case REOPENED = 'reopened';
    case RECLASSIFIED = 'reclassified';
    case RECATEGORIZED = 'recategorized';
    case RESPONDED = 'responded';
    case TAGGED = 'tagged';
    case CLOSED = 'closed';

    case ON_HOLD = 'on_hold';           // Placeholder only
    case IN_PROGRESS = 'in_progress';   // Placeholder only

    public static function majorActions(): array
    {
        return array_filter(self::cases(), fn ($case) => in_array($case->value, [
            self::SUBMITTED->value,
            self::RETRACTED->value,
            self::QUEUED->value,
            self::ASSIGNED->value,
            self::APPROVED->value,
            self::COMPLETED->value,
            self::STARTED->value,
            self::SUSPENDED->value,
            self::CLOSED->value,
            self::RESPONDED->value,
            self::STALE->value,
            self::COMPLIED->value,
            self::REOPENED->value,
        ], true));
    }

    public static function minorActions(): array
    {
        return array_filter(self::cases(), fn ($case) => ! in_array($case, self::majorActions(), true));
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::RESTORED,
            self::TRASHED => 'gray',
            self::UPDATED => 'info',
            self::APPROVED => 'success',
            self::COMPLETED => 'success',
            self::REOPENED => 'info',
            self::STARTED => 'info',
            self::SUSPENDED => 'warning',
            self::SUBMITTED => 'success',
            self::RETRACTED => 'warning',
            self::ACCEPTED => 'success',
            self::REJECTED,
            self::ASSIGNED,
            self::QUEUED => 'info',
            self::COMPLIED => 'warning',
            self::CLOSED => 'danger',
            self::ON_HOLD => 'warning',
            default => 'gray'
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::QUEUED => 'The request has been queued and is awaiting processing.',
            self::RESTORED => 'The request has been restored after being trashed.',
            self::TRASHED => 'The request has been trashed.',
            self::UPDATED => 'The request has been updated.',
            self::ACCEPTED => 'The request has been accepted.',
            self::COMPLETED => 'The request has been completed.',
            self::STARTED => 'The request has been taken up and is in progress.',
            self::SUSPENDED => 'The request has been suspended and is awaiting further action.',
            self::SUBMITTED => 'The request has been published by the user.',
            self::RETRACTED => 'The request has been retracted by the requestor and is waiting to be republished.',
            self::COMPLIED => 'The user submitted the lacking documents.',
            self::APPROVED => 'The request has been accepted and is being processed.',
            self::REJECTED => 'The request assignment has been rejected.',
            self::ASSIGNED => 'The request has been assigned to a user.',
            self::QUEUED => 'The request has been queued and is awaiting processing.',
            self::REOPENED => 'The request has been reopened for further action.',
            default => null
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::QUEUED => 'gmdi-start-o',
            self::RESTORED => 'gmdi-restore-o',
            self::TRASHED => 'gmdi-delete-o',
            self::UPDATED => 'gmdi-update-o',
            self::APPROVED => 'gmdi-verified-o',
            self::COMPLETED => 'gmdi-task-alt-o',
            self::STARTED => 'gmdi-alarm-o',
            self::SUSPENDED => 'gmdi-front-hand-o',
            self::SUBMITTED => 'gmdi-publish-o',
            self::RETRACTED => 'gmdi-settings-backup-restore-o',
            self::ASSIGNED => 'gmdi-supervisor-account-o',
            self::ACCEPTED => 'gmdi-published-with-changes-o',
            self::REJECTED => 'gmdi-person-off-o',
            self::COMPLIED => 'gmdi-task-r',
            self::RECATEGORIZED => 'gmdi-playlist-add-check-circle-o',
            self::RECLASSIFIED => 'gmdi-swap-horizontal-circle-o',
            self::CLOSED => 'gmdi-cancel-o',
            self::REOPENED => 'gmdi-replay-o',
            self::TAGGED => 'gmdi-sell-o',
            self::RESPONDED => 'gmdi-chat-o',
            self::IN_PROGRESS => 'gmdi-sync-o',
            self::ON_HOLD => 'gmdi-pause-o',
            default => 'gmdi-circle-o',
        };
    }

    public function getLabel(?string $type = null, ?bool $capitalize = true): ?string
    {
        if (in_array($this, [self::IN_PROGRESS, self::ON_HOLD], true)) {
            return match ($this) {
                self::IN_PROGRESS => 'In Progress',
                self::ON_HOLD => 'On Hold',
                default => null,
            };
        }

        $label = match ($type) {
            'nounForm' => match ($this->value) {
                'updated' => 'update',
                'approved' => 'approval',
                'declined' => 'declination',
                'completed' => 'completion',
                'cancelled' => 'cancellation',
                'initiated' => 'initiation',
                'suspended' => 'suspension',
                'published' => 'publication',
                'retracted' => 'retraction',
                'assigned' => 'assignment',
                'accepted' => 'acceptance',
                'rejected' => 'rejection',
                'adjusted' => 'adjustment',
                'scheduled' => 'scheduling',
                'extended' => 'extension',
                'verified' => 'verification',
                'denied' => 'denial',
                'ammended' => 'alter',
                'responded' => 'response',
                'reclassified' => 'reclassification',
                'recategorized' => 'recategorization',
                'tagged' => 'tag',
                default => $this->value,
            },
            'presentTense' => match ($this->value) {
                'approved' => 'approve',
                'cancelled' => 'cancel',
                'declined' => 'decline',
                'scheduled' => 'schedule',
                'completed' => 'complete',
                'tagged' => 'tag',
                'closed' => 'close',
                default => substr($this->value, 0, -2),
            },
            default => $this->value,
        };

        return $capitalize ? ucfirst($label) : $label;
    }

    public function major()
    {
        return in_array($this, self::majorActions(), true);
    }

    public function minor()
    {
        return in_array($this, self::minorActions(), true);
    }

    public function finalized()
    {
        return in_array($this, [self::CLOSED], true);
    }
}
