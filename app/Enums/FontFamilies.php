<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FontFamilies: string implements HasLabel
{
    case Arial = 'Arial';
    case TimesNewRoman = 'Times New Roman';
    case Verdana = 'Verdana';
    case Georgia = 'Georgia';
    case CourierNew = 'Courier New';

    case Merriweather = 'Merriweather';
    case Lato = 'Lato';
    case Inter = 'Inter';
    case RobotoSlab = 'Roboto Slab';
    case Poppins = 'Poppins';
    case CrimsonPro = 'Crimson Pro';
    case PlayfairDisplay = 'Playfair Display';
    case Cardo = 'Cardo';

    public function getLabel(): string
    {
        return $this->value;
    }
}
