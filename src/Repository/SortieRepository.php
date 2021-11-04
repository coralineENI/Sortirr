<?php

namespace App\Repository;

use App\Entity\Filtres;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\DateTime;

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

    public function  findDefault(Participant $user) {
        $qb = $this->createQueryBuilder('s');
        $qb
            ->setParameter('user', $user)
            ->andWhere('s.organisateur = :user');
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function findAllFilter(Site $site, string $nom, DateTime $debut, DateTime $fin, bool $isOrganisateur, bool $inscrit, bool $pasInscrit, bool $sortiePassee, Participant $id) {
        $qb = $this->createQueryBuilder('s');
        $qb
            ->setParameter('user', $id)
            ->andWhere('s.organisateur = :user')
            ->setParameter('site', $site)
            ->andWhere("s.site = :site")
            ->setParameter('nom', '%'.$nom.'%' )
            ->andWhere( $qb->expr()->like('s.nom', ':nom'))
            ->setParameter('dateHeureMin', $debut)
            ->setParameter('dateHeureMax', $fin)
            ->andWhere('s.dateHeureDebut > :dateHeureMin')
            ->andWhere('s.dateHeureDebut < :dateHeureMax');

        if ($isOrganisateur === false) {
            $qb->andWhere("s.organisateur != :user");
        }
        if ($inscrit === false) {
            $qb->innerJoin('s.participants', 'p')
                ->setParameter('userId', $id->getId())
                ->andWhere('p.id != :userId');
        }
        if ($pasInscrit === false) {
            $qb->innerJoin('s.participants', 'p')
                ->setParameter('userId', $id->getId())
                ->andWhere('p.id = :userId');
        }
        if ($sortiePassee === false) {
            $now = new DateTime('now');
            $qb->setParameter('now', $now)
                ->andWhere('s.dateHeureDebut > :now');
        }
        $query = $qb->getQuery();
        return $query->getResult();
    }

//    /**
//     * @return Query
//     *
//     */
//    public function findAllFilter(Filtres $recherche, $id) : Query
//    {
//        $qb = $this->createQueryBuilder('f');
//
//
//        if ($recherche->getSite()){
//            $qb = $qb
//                ->andWhere('f.site = :site)')
//                ->setParameter('site', $recherche->getSite());
//        }
//
//        if ($recherche->getNom()){
//            $mots = explode(" ", $recherche->getNom());
//            $qb ->andWhere("f.nom LIKE :mot")
//                ->setParameter('mot', "%".$mots[0]."%");
//            for ($i = 1; $i <sizeof($mots); $i++){
//                $qb->orWhere("f.nom LIKE :mot".$i)
//                    ->setParameter('mot'.$i, "%".$mots[$i]."%");
//            }
//        }
//
//        dump($qb);
//        if ($recherche->getDebut()){
//            $qb ->andWhere('f.dateHeuredebut >= :debut')
//                ->setParameter('debut', $recherche);
//        }
//        if ($recherche->getFin()){
//
//            $qb ->andWhere('f.dateLimiteInscription <= :fin')
//                ->setParameter('fin', $recherche);
//        }
//
//        if ($recherche->getSortiePassee()){
//               $qb = $qb
//                   ->andWhere('f.debut <= :sortiePassee')
//                   ->setParameter('sortiePassee', $recherche->getSortiePassee(),  date('Y-m-d H:i:s'));
//            }
//
//        if ($recherche->getOrganisateur()){
//            $qb = $qb
//                ->andWhere('f.organisateur = :organisateur')
//                ->setParameter('organisateur', $id);
//        }
//
//        if ($recherche->getInscrit()){
//            $qb = $qb
//                ->andWhere(':inscrit = f.Inscrit')
//                ->setParameter('inscrit', $id);
//        }
//
//        if ($recherche->getPasInscrit()){
//            $qb = $qb
//                ->andWhere('f.pasInscrit = :pasInscrit')
//                ->setParameter('pasInscrit', $id);
//        }
//
//        return   $qb->getQuery();
//    }


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
