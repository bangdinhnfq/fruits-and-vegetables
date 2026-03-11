<?php

declare(strict_types=1);


namespace App\Entity;

use App\Enum\ProductTypeEnum;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Fruit extends Product
{
    public function getType(): ProductTypeEnum
    {
        return ProductTypeEnum::FRUIT;
    }
}
