<?php

namespace App\Repository;

use App\Entity\Filtres;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    /**
     * @return Sortie[]
     */
    public function findAllFilter(
        Participant $loguser,
        Site $site = null,
        bool $organisateur = false ,
        string $nom = null,
        string $debut = null,
        string $fin = null,
        bool $sortiePassee = false)
    {
        $qb = $this->createQueryBuilder('s');
//                    ->select('si', 's')
//                    ->join('s.site', 'si');


        if ($site!=null){
            $qb ->andWhere('s.site = :site)')
                ->setParameter('site', $site->getId());
        }

        if ($nom!=null){
            $mots = explode(" ", $nom);
            $qb ->andWhere('s.nom LIKE :mot')
                ->setParameter('mot', "%".$mots[0]."%");
            for ($i = 1; $i <sizeof($mots); $i++){
                $qb->orWhere("s.nom LIKE :mot".$i)
                    ->setParameter('mot'.$i, "%".$mots[$i]."%");
            }
        }

        if ($debut != null){
            $starttime = strtotime($debut);
            $startnewformat = date('Y-m-d',$starttime);
            $qb ->andWhere('s.datedebut >= :datedebut')
                ->setParameter('datedebut', $startnewformat);
        }
        if ($fin != null){
            $stoptime = strtotime($fin);
            $stopnewformat = date('Y-m-d',$stoptime);
            $qb ->andWhere('s.datecloture <= :datecloture')
                ->setParameter('datecloture', $stopnewformat);
        }

        if ($sortiePassee!= null){
               $qb= $qb
                   ->andWhere('f.debut <= :sortiePassee')
                   ->setParameter('sortiePassee', $sortiePassee,  date('Y-m-d H:i:s'));
            }

        if ($organisateur){
            $qb = $qb
                ->andWhere('s.organisateur = :organisateur')
                ->setParameter('organisateur', $loguser->getId());
        }

//        if ($inscrit){
//            $qb = $qb
//                ->andWhere(':inscrit MEMBER OF f.participants')
//                ->setParameter('inscrit', $id);
//        }
//
//        if ($pasInscrit){
//            $qb = $qb
//                ->andWhere('f.pasInscrit = :pasInscrit')
//                ->setParameter('pasInscrit', $id);
//        }


        $qb = $qb->getQuery();
        dump($qb);
        return $qb->execute();
    }


    // /**
    //  * @return Sortie[] Returns an array of Sortie objects
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
    public function findOneBySomeField($value): ?Sortie
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
