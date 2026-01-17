<?php

namespace App\Enums;

enum ThesisPeriodStage: string
{
    case PENGAJUAN = 'PENGAJUAN';
    case REVIEW = 'REVIEW';
    case PENETAPAN = 'PENETAPAN';
    case SEMINAR = 'SEMINAR';
    case SIDANG = 'SIDANG';

    /**
     * Get the stages ordered by their order.
     *
     * @return array<int, string>
     */
    public static function orderedStages(): array
    {
        return [
            0 => self::PENGAJUAN->value,
            1 => self::REVIEW->value,
            2 => self::PENETAPAN->value,
            3 => self::SEMINAR->value,
            4 => self::SIDANG->value,
        ];
    }
}
