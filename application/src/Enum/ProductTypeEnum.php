<?php

declare(strict_types=1);

namespace App\Enum;

use App\Collection\FruitCollection;
use App\Collection\VegetableCollection;
use App\Entity\Fruit;
use App\Entity\Vegetable;

enum ProductTypeEnum: string
{
    case FRUIT = 'fruit';
    case VEGETABLE = 'vegetable';

    public function getPluralLabel(): string
    {
        return match ($this) {
            self::FRUIT => 'fruits',
            self::VEGETABLE => 'vegetables',
        };
    }

    public function getEntityClass(): string
    {
        return match ($this) {
            self::FRUIT => Fruit::class,
            self::VEGETABLE => Vegetable::class,
        };
    }

    public function getCollectionClass(): string
    {
        return match ($this) {
            self::FRUIT => FruitCollection::class,
            self::VEGETABLE => VegetableCollection::class,
        };
    }
}
