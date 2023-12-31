<?php

namespace App\Repository;

use App\Entity\OrderProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderProduct>
 *
 * @method OrderProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderProduct[]    findAll()
 * @method OrderProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderProduct::class);
    }

    public function getProductCountByOrderId(int $orderId): int
    {
        return (int)$this->createQueryBuilder('op')
            ->select('SUM(op.count)')
            ->andWhere('op.order = :orderId')
            ->setParameter('orderId', $orderId)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
