<?php

namespace App\Helpers;


class PriceFormatter
{
    static $arabicNumbers = [
        '1' => '١',
        '2' => '٢',
        '3' => '٣',
        '4' => '٤',
        '5' => '٥',
        '6' => '٦',
        '7' => '٧',
        '8' => '٨',
        '9' => '٩',
        '0' => '٠',
    ];
    public static function getArabicNumber(string $price)
    {
        $formattedPrice = "";
        foreach (str_split($price) as $number) {
            $formattedPrice .= static::$arabicNumbers[$number];
        }
        return $formattedPrice;
    }
    public static function format($price)
    {
        // $price = $price . "";
        // $priceLength = strlen($price);
        // if ($priceLength >= 13 && $priceLength <= 15) {
        //     return static::formatMultipleParts(13, $price, "trillions", "billions");
        // }
        // if ($priceLength >= 10 && $priceLength <= 12) {
        //     return static::formatMultipleParts(10, $price, "billions", "millions");
        // }
        // if ($priceLength >= 7 && $priceLength <= 9) {
        //     return static::formatMultipleParts(7, $price, "millions", "hundreds");
        // }
        // if ($priceLength >= 4 && $priceLength <= 6) {
        //     $hundreds = substr($price, 0, static::getPartLength(4, $priceLength));
        //     return __("admin.hundreds", ['hundreds' => static::formatToArabic($hundreds)]);
        // }
        // return __('admin.normal_price', ['price' => $price]);
        return \number_format($price) . '';
    }
    public static function getPartLength(int $startIndex, int $priceLength)
    {
        return abs($startIndex - $priceLength) + 1;
    }
    public static function formatToArabic($price)
    {
        return static::getArabicNumber(intval($price) . "");
    }
    public static function getSecondPart(string $name, $price)
    {
        return  "و" . __("admin.$name", [$name => static::formatToArabic($price)]);
    }
    public static function formatMultipleParts(int $startIndex, string $price, string $firstName, string $secondName)
    {
        $priceLength = strlen($price);
        $firstPartCount = abs($startIndex - $priceLength) + 1;
        $firstPart = substr($price, 0, $firstPartCount);
        $secondPart = substr($price, $firstPartCount, 3);
        $formattedPrice = __("admin.$firstName", [$firstName => static::formatToArabic($firstPart)]);
        if (intval($secondPart)) {
            $formattedPrice .= static::getSecondPart($secondName, $secondPart);
        }
        return $formattedPrice;
    }
}