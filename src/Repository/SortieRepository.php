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
    public function findAllFilter(Filtres $recherche, $id)
    {
        $qb = $this->createQueryBuilder('f');
//                    ->select('si', 's')
//                    ->join('s.site', 'si');


        if ($recherche->getSite()){
            $qb ->andWhere('f.site = :site)')
                ->setParameter('site', $recherche->getSite()->getId());
        }

        if ($recherche->getNom()){
            $mots = explode(" ", $recherche->getNom());
            $qb ->andWhere('f.nom LIKE :mot')
                ->setParameter('mot', "%".$mots[0]."%");
            for ($i = 1; $i <sizeof($mots); $i++){
                $qb->orWhere("f.nom LIKE :mot".$i)
                    ->setParameter('mot'.$i, "%".$mots[$i]."%");
            }
        }

//        if ($recherche->getDebut()){
//            $starttime = strtotime($recherche->getDebut());
//            $startnewformat = date('Y-m-d',$starttime);
//            $qb ->andWhere('so.dateHeuredebut >= :debut')
//                ->setParameter('debut', $startnewformat);
//        }
//        if ($recherche->getFin()){
//            $stoptime = strtotime($recherche->getFin());
//            $stopnewformat = date('Y-m-d',$stoptime);
//            $qb ->andWhere('so.dateLimiteInscription <= :fin')
//                ->setParameter('fin', $stopnewformat);
//        }

        if ($recherche->getSortiePassee()){
               $qb= $qb
                   ->andWhere('f.debut <= :sortiePassee')
                   ->setParameter('sortiePassee', $recherche->getSortiePassee(),  date('Y-m-d H:i:s'));
            }

        if ($recherche->getOrganisateur()){
            $qb = $qb
                ->andWhere('f.organisateur = :organisateur')
                ->setParameter('organisateur', $id);
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
