<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ResponseDisposition: string implements HasLabel
{
    case CERTIFICATION = 'certification';
    case ENDORSEMENT = 'endorsement';
    case INCIDENT = 'incident';
    case RECOMMENDATION = 'recommendation';

    case OTHER = '';

    public function getLabel(): string
    {
        return mb_ucfirst($this->value);
    }
}
