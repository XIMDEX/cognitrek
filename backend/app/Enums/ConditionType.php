<?php

namespace App\Enums;

class ConditionType
{
    const USER = 'user';
    const DYSLEXIA = 'dyslexia';
    const ATTENTION_DEFICIT = 'attention_deficit';
    const AUTISM = 'autism';
    const VISUAL_IMPAIRMENT = 'visual_impairment';
    const HEARING_IMPAIRMENT = 'hearing_impairment';
    const LANGUAGE_DISORDER = 'language_disorder';

    public static function getValues()
    {
        return [
            self::USER,
            self::DYSLEXIA,
            self::ATTENTION_DEFICIT,
            self::AUTISM,
            self::VISUAL_IMPAIRMENT,
            self::HEARING_IMPAIRMENT,
            self::LANGUAGE_DISORDER,
        ];
    }
}