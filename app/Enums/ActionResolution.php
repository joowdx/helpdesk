<?php

namespace App\Enums;

use Filament\Support\Contracts\HasDescription;
use Filament\Support\Contracts\HasLabel;

enum ActionResolution: string implements HasDescription, HasLabel
{
    case RESOLVED = 'resolved';
    case UNRESOLVED = 'unresolved';
    case INVALID = 'invalid';
    case NONE = '';

    public function getLabel(): string
    {
        return match ($this) {
            self::RESOLVED => 'Resolved',
            self::UNRESOLVED => 'Unresolved',
            self::INVALID => 'Invalid',
            default => 'None',
        };
    }

    public function getDescription(): string
    {
        return match ($this) {
            self::RESOLVED => 'The request was resolved.',
            self::UNRESOLVED => 'The request was unresolved.',
            self::INVALID => 'The request was invalid.',
            default => 'No resolution was provided.',
        };
    }

    public function remarks(): ?string
    {
        return match ($this) {
            self::INVALID => "### We are sorry, but we cannot assist you with this request due to the following reason: \n\n 1. \n\n 2.",
            default => null,
        };
    }
}
