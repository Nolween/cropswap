<?php

namespace App\Enums;

enum SwapCategoryEnum: string
{
    case Vegetable = 'vegetable';
    case Fruit = 'fruit';
    case Herb = 'herb';
    case Flower = 'flower';
    case Cereal = 'cereal';
    case Meat = 'meat';
    case Fish = 'fish';
    case Dairy = 'dairy';
    case Beverage = 'beverage';
    case Sweet = 'sweet';
    case Condiment = 'condiment';
    case Nut = 'nut';
    case Seed = 'seed';
    case Bread = 'bread';
    case Other = 'other';

    public static function all(): array
    {
        return [
            self::Vegetable->value,
            self::Fruit->value,
            self::Herb->value,
            self::Flower->value,
            self::Cereal->value,
            self::Meat->value,
            self::Fish->value,
            self::Dairy->value,
            self::Beverage->value,
            self::Sweet->value,
            self::Condiment->value,
            self::Nut->value,
            self::Seed->value,
            self::Bread->value,
            self::Other->value,
        ];
    }

    public static function allTranslated(): array
    {
        $translated = [];

        foreach (self::all() as $category) {
            $translated[] = ['name' => __('swap-categories.' . $category), 'value' => $category];
        }
        return $translated;
    }
}
