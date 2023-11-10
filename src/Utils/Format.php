<?php

namespace Utils;

use Collection\EntityCollection;

class Format {
    const TIME_RANGE_INPUT_REGEXP = '/^(\d{2}):(\d{2}):(\d{2})$/';
    const TIME_RANGE_OUTPUT_REGEXP = '$1:$2';
    const DAYS_OF_WEEK = [
        "domingo",
        "segunda-feira",
        "terça-feira",
        "quarta-feira",
        "quinta-feira",
        "sexta-feira",
        "sábado",
    ];
    const AGE_GROUPS = [
        'livre',
        '10 anos',
        '12 anos',
        '14 anos',
        '16 anos',
        '18 anos',
    ];

    public static function mainPhoto(string | null $thumb) {
        return $thumb ? Env::PHOTO_BASE_URL_PORTAL() . $thumb : '';
    }
    
    public static function toWordPressGallery(array $photoURLs) {
        if (empty($photoURLs)) {
            return '';
        }
    
        $output = [];
        foreach($photoURLs as $photoData) {
            list($photoURL, $title) = explode(":", $photoData);
            $output[] = Env::PHOTO_BASE_URL_PORTAL() . $photoURL;
        }
    
        return join('|', $output);
    }
    
    public static function nullableDate(string | null $date) {
        if ($date === Env::NULL_DATE() || $date === Env::NULL_DATETIME()) {
            return null;
        }
    
        return $date;
    }

    public static function eventHours(EntityCollection | null $collection): string {
        if (!$collection) {
            return "";
        }

        $matrix = [];
        /** @var \Entity\EventHours $hours */
        foreach($collection as $hours) {
            if (!isset($matrix[$hours->dayOfWeek])) {
                $matrix[$hours->dayOfWeek] = [];
            }

            $matrix[$hours->dayOfWeek][] = self::timeRange($hours->init, $hours->end);
        }

        $array = [];
        foreach($matrix as $dayOfWeek => $timeRanges) {
            $lastIndex = count($timeRanges) - 1;
            $last = $timeRanges[$lastIndex];
            unset($timeRanges[$lastIndex]);
            $array[] = self::toDayOfWeek($dayOfWeek) . ": " . join(", ", $timeRanges) . ($lastIndex > 0 ? " e " : "") . $last;
        }

        return join("|", $array);
    }

    public static function timeRange(string $init, string $end): string {
        $init = preg_replace(
            self::TIME_RANGE_INPUT_REGEXP,
            self::TIME_RANGE_OUTPUT_REGEXP,
            $init,
        );

        $end = preg_replace(
            self::TIME_RANGE_INPUT_REGEXP,
            self::TIME_RANGE_OUTPUT_REGEXP,
            $end,
        );
        return "$init - $end";
    }

    public static function toDayOfWeek(int $dayOfWeek): string {
        if ($dayOfWeek < 0 || $dayOfWeek >= count(self::DAYS_OF_WEEK)) {
            return "";
        }

        return self::DAYS_OF_WEEK[$dayOfWeek];
    }

    public static function toAgeGroup(int $ageGroup): string {
        if ($ageGroup < 0 || $ageGroup >= count(self::AGE_GROUPS)) {
            return "";
        }

        return self::AGE_GROUPS[$ageGroup];
    }
    
    /**
     * Digits: formata o número de dígitos de um valor numérico.
     * Exemplo:
     * echo Format::Digits(3.549);
     * # imprime '3,55'
     * @param mixed $value número a ser formatado
     * @param int $count número de dígitos a aplicar
     * @param String $cents caractere que separa os centavos
     * @param String $chillad caractere que separa os milhares
     * @return String com o resultado da formatação.
     */
    public static function digits($value, $count = 2, $cents = ",", $chillad = ".") {
        if (!is_numeric($value)) {
            return null;
        }

        return number_format($value, $count, $cents, $chillad);
    }
    
    /**
     * toMoney: transforma um valor numérico em símbolo de moeda.
     * Exemplo:
     * echo Format::toMoney(2.85);
     * # imprime 'R$ 2,85'
     * @param mixed $value número a ser convertido
     * @param String $symbol símbolo que ficará na frente do valor
     * @return uma String com o resultado.
     */
    public static function toMoney($value, $symbol = "R$ ") {
        if (!is_numeric($value)) {
            return null;
        }

        if ($value > 0) {
            return $symbol . self::digits($value);
        }

        if ($value < 0) {
            return "-" . $symbol . self::digits($value * (-1));
        }

        return "{$symbol}00,00";
    }
}