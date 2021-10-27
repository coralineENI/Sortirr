<?php

namespace App\Repository;

use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Site|null find($id, $lockMode = null, $lockVersion = null)
 * @method Site|null findOneBy(array $criteria, array $orderBy = null)
 * @method Site[]    findAll()
 * @method Site[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Site::class);
    }




    public function findBySite()
    {

        // Méthode en QueryBuilder
        //Il attend en paramètre un alias
        $qb = $this->createQueryBuilder('s')
            //On peut aussi commencer par addOrderBy plutôt que OrderBy, c'est une habitude
            // à prendre pour ne pas se tromper
            ->join("s.nom", "n")
            ->addSelect("n");


        //L'avantage est qu'on n'est pas obligé de respecter l'ordre de construction d'un select (where, orderby).
        $query = $qb->getQuery();

        return $query->getResult();
    }


    // /**
    //  * @return Site[] Returns an array of Site objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Site
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
