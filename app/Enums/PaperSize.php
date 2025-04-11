<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use InvalidArgumentException;

enum PaperSize: string implements HasLabel
{
    case A4 = 'a4';
    case LETTER = 'letter';
    case FOLIO = 'folio';
    case LEGAL = 'legal';

    public function getDimensions(string $unit = 'in'): array
    {
        return match (mb_strtolower($unit)) {
            'mm' => match ($this) {
                self::A4 => [210, 297],
                self::LETTER => [216, 279],
                self::FOLIO => [216, 330],
                self::LEGAL => [216, 356],
            },
            'in' => match ($this) {
                self::A4 => [8.27, 11.69],
                self::LETTER => [8.5, 11],
                self::FOLIO => [8.5, 13],
                self::LEGAL => [8.5, 14],
            },
            default => throw new InvalidArgumentException('Invalid unit provided. Use "mm" or "in".'),
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::A4 => 'A4 ('.$this->getDimensions('mm')[0].' x '.$this->getDimensions('mm')[1].' mm)'.' ('.$this->getDimensions('in')[0].' x '.$this->getDimensions('in')[1].' in)',
            self::FOLIO => 'Folio ('.$this->getDimensions('mm')[0].' x '.$this->getDimensions('mm')[1].' mm)'.' ('.$this->getDimensions('in')[0].' x '.$this->getDimensions('in')[1].' in)',
            self::LETTER => 'Letter ('.$this->getDimensions('mm')[0].' x '.$this->getDimensions('mm')[1].' mm)'.' ('.$this->getDimensions('in')[0].' x '.$this->getDimensions('in')[1].' in)',
            self::LEGAL => 'Legal ('.$this->getDimensions('mm')[0].' x '.$this->getDimensions('mm')[1].' mm)'.' ('.$this->getDimensions('in')[0].' x '.$this->getDimensions('in')[1].' in)',
        };
    }
}
