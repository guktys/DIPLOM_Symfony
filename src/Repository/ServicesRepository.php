<?php

namespace App\Repository;

use App\Entity\Services;
use App\Model\ServicesType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

class ServicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Services::class);
    }

    public function findServicesByNumber($number)
    {
        $entityManager = $this->getEntityManager();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder->select('s')
            ->from(Services::class, 's')
            ->andWhere('s.type = :type')
            ->setParameter('type', ServicesType::SERVICE);

        $services = $queryBuilder->getQuery()->getResult();
        shuffle($services);
        return array_slice($services, 0, $number);
    }
}