<?php
namespace App\Helpers;

class RandomImageHelper
{
    public static function getRandomImagePath(): string
    {
        $randomNumber = rand(1, 5);
        return asset('assets/images/NIKE_SB_' . $randomNumber . '.png');
    }
}
