<?php

declare(strict_types=1);

namespace Core\Support\Metrics\Enums;

enum Period: string
{
    case TODAY = 'today';
    case DAY = 'day';
    case WEEK = 'week';
    case MONTH = 'month';
    case YEAR = 'year';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
