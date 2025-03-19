<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ActionResolution: string implements HasColor, HasDescription, HasIcon, HasLabel
{
    case RESOLVED = 'resolved';
    case UNRESOLVED = 'unresolved';
    case ACKNOWLEDGED = 'acknowledged';
    case INVALIDATED = 'invalidated';
    case CANCELLED = 'cancelled';
    case NONE = '';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::RESOLVED => 'Resolved',
            self::UNRESOLVED => 'Unresolved',
            self::ACKNOWLEDGED => 'Acknowledged',
            self::INVALIDATED => 'Invalidated',
            self::CANCELLED => 'Cancelled',
            default => null,
        };
    }

    public function getDescription(): ?string
    {
        return match ($this) {
            self::RESOLVED => 'The request was successfully resolved.',
            self::UNRESOLVED => 'The request could not be resolved due to insufficient information, technical limitations, or other constraints.',
            self::ACKNOWLEDGED => 'The request was acknowledged and noted for future reference.',
            self::INVALIDATED => 'The request was found to be invalid therefore cannot be processed any further.',
            self::CANCELLED => 'The request was cancelled by the requester.',
            default => null,
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::UNRESOLVED => 'warning',
            self::INVALIDATED => 'danger',
            self::RESOLVED,
            self::ACKNOWLEDGED => 'success',
            self::CANCELLED => 'gray',
            default => null,
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::UNRESOLVED => 'gmdi-dangerous-o',
            self::RESOLVED,
            self::ACKNOWLEDGED => 'gmdi-done-all-o',
            self::INVALIDATED => 'gmdi-new-releases-o',
            self::CANCELLED => 'gmdi-do-not-disturb-on-o',
            default => null,
        };
    }

    public function remarks(): ?string
    {
        return match ($this) {
            self::INVALIDATED => "### We are sorry, but we cannot assist you with this request due to the following reason: \n\n 1. \n\n 2.",
            self::ACKNOWLEDGED => 'We have received your request. Thank you for taking the time to write to us. We will use your feedback to improve our services.',
            default => null,
        };
    }
}
