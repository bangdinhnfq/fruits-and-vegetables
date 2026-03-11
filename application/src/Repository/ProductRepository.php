<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use App\Enum\ProductTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $product, bool $flush = false): void
    {
        $this->getEntityManager()->persist($product);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }

    public function remove(Product $product, bool $flush = false): void
    {
        $this->getEntityManager()->remove($product);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByRequestId(string|int $requestId): ?Product
    {
        return $this->findOneBy(['requestId' => (string)$requestId]);
    }

    /**
     * @param array<string|int> $requestIds
     * @return array<string, Product>
     */
    public function findByRequestIds(array $requestIds): array
    {
        if ($requestIds === []) {
            return [];
        }

        return $this->createQueryBuilder('p', 'p.requestId')
            ->andWhere('p.requestId IN (:requestIds)')
            ->setParameter('requestIds', $requestIds)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Product[]
     */
    public function listByType(string $type): array
    {
        $typeEnum = ProductTypeEnum::tryFrom($type);

        if ($typeEnum === null) {
            return [];
        }

        return $this->getEntityManager()
            ->getRepository($typeEnum->getEntityClass())
            ->findBy([], ['name' => 'ASC']);
    }

    /**
     * @return Product[]
     */
    public function searchByName(string $query, ?string $type = null): array
    {
        $repository = $this;

        if ($type !== null) {
            $typeEnum = ProductTypeEnum::tryFrom($type);

            if ($typeEnum === null) {
                return [];
            }

            $repository = $this->getEntityManager()->getRepository($typeEnum->getEntityClass());
        }

        $escapedQuery = addcslashes($query, '%_');

        return $repository->createQueryBuilder('p')
            ->andWhere('p.name LIKE :query')
            ->setParameter('query', '%' . $escapedQuery . '%')
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Product[]
     */
    public function list(): array
    {
        return $this->findAll();
    }
}
