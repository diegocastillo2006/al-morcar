<?php

namespace App\Repository;

use App\Entity\Prestamo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Prestamo>
 */
class PrestamoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prestamo::class);
    }

    //    /**
    //     * @return Prestamo[] Returns an array of Prestamo objects
    //     */
       public function obtenerPrestamosUsuario($usuario): array
       {
           return $this->createQueryBuilder('p')
               ->andWhere('p.usuario = :u')
               ->setParameter('u', $usuario)
               ->orderBy('p.id', 'ASC')
               ->setMaxResults(10)
               ->getQuery()
               ->getResult();
       }

       public function atrasados(): array
       {
           return $this->createQueryBuilder('p')
               ->andWhere('p.estado = :e')
               ->setParameter('e', 'Atrasado')
               ->orderBy('p.id', 'ASC')
               ->setMaxResults(10)
               ->getQuery()
               ->getResult();
       }

       public function enProceso(): array
       {
           return $this->createQueryBuilder('p')
               ->andWhere('p.estado = :e')
               ->setParameter('e', 'En proceso')
               ->orderBy('p.id', 'ASC')
               ->setMaxResults(10)
               ->getQuery()
               ->getResult();
       }

       public function activos(): array
       {
           return $this->createQueryBuilder('p')
               ->andWhere('p.estado = :e')
               ->setParameter('e', 'Activo')
               ->orderBy('p.id', 'ASC')
               ->setMaxResults(10)
               ->getQuery()
               ->getResult();
       }

    //    public function findOneBySomeField($value): ?Prestamo
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
