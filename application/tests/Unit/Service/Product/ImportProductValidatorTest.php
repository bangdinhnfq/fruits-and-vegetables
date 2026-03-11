<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\Product;

use App\Dto\ImportProductDto;
use App\Service\Product\ImportProductValidator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImportProductValidator::class)]
final class ImportProductValidatorTest extends TestCase
{
    private ImportProductValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new ImportProductValidator();
    }

    public function testValidateReturnsEmptyArrayForValidDto(): void
    {
        $dto = new ImportProductDto(
            name: 'Apple',
            type: 'fruit',
            quantity: 100,
            unit: 'g'
        );

        $errors = $this->validator->validate($dto);

        $this->assertSame([], $errors);
    }

    #[DataProvider('provideInvalidDtos')]
    public function testValidateCatchesErrors(ImportProductDto $dto, array $expectedErrorKeys): void
    {
        $errors = $this->validator->validate($dto);

        $this->assertSame($expectedErrorKeys, array_keys($errors));
    }

    public static function provideInvalidDtos(): iterable
    {
        yield 'missing name' => [
            new ImportProductDto(name: '', type: 'fruit', quantity: 100, unit: 'g'),
            ['name'],
        ];

        yield 'invalid type' => [
            new ImportProductDto(name: 'Carrot', type: 'invalid_type', quantity: 100, unit: 'g'),
            ['type'],
        ];

        yield 'negative quantity' => [
            new ImportProductDto(name: 'Banana', type: 'fruit', quantity: -5, unit: 'g'),
            ['quantity'],
        ];

        yield 'zero quantity' => [
            new ImportProductDto(name: 'Banana', type: 'fruit', quantity: 0, unit: 'g'),
            ['quantity'],
        ];

        yield 'invalid unit' => [
            new ImportProductDto(name: 'Banana', type: 'fruit', quantity: 100, unit: 'lb'),
            ['unit'],
        ];

        yield 'multiple errors at once' => [
            new ImportProductDto(name: '', type: 'meat', quantity: -10, unit: 'oz'),
            ['name', 'type', 'quantity', 'unit'],
        ];
    }
}
