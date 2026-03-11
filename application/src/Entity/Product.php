<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\ProductTypeEnum;
use App\Enum\ProductUnitEnum;
use App\Repository\ProductRepository;
use App\Trait\UnitConverter\UnitConverterTrait;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'products')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string', enumType: ProductTypeEnum::class)]
#[ORM\DiscriminatorMap([
    ProductTypeEnum::FRUIT->value => Fruit::class,
    ProductTypeEnum::VEGETABLE->value => Vegetable::class
])]
abstract class Product
{
    use UnitConverterTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $requestId = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column]
    private int $quantity;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $updatedAt;

    public function __construct(string $name, int $quantity, ?string $requestId = null)
    {
        $this->name = $name;
        $this->quantity = $quantity;
        $this->requestId = $requestId;
        $now = new DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    abstract public function getType(): ProductTypeEnum;

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getRequestId(): ?string
    {
        return $this->requestId;
    }

    public function setRequestId(?string $requestId): self
    {
        $this->requestId = $requestId;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getQuantityInUnit(ProductUnitEnum $unit): float|int
    {
        return $this->convertFromGrams($this->quantity, $unit);
    }
}
