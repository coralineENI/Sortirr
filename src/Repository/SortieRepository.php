<?php

namespace App\Repository;

use App\Entity\Filtres;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
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

    private function findFilter() : QueryBuilder
    {
        return $this->createQueryBuilder('s');
    }

    public function findAllFilter(Filtres $recherche, int $participant)
    {
        $qb = $this->findFilter();

        if ($recherche->getNom()) {
            $mots= explode(", ", $recherche->getNom());

            $qb = $qb->andWhere("s.nom LIKE :mot")
                ->setParameter('mot', "%".$mots[0]."%");
            for ($i=1; $i <sizeof($mots);$i++){
                $qb->orWhere("s.nom LIKE :mot".$i)
                    ->setParameter('mot'.$i,"%".$mots[$i]."%");
            }
            dump($qb);
        }

        if ($recherche->getDebut()) {
            $qb = $qb->andWhere("s.dateHeureDebut >= :debut")
                ->setParameter('debut', $recherche->getDebut());
        }
        if ($recherche->getFin()) {
            $qb= $qb->andWhere("s.dateHeureDebut <= :fin")
                ->setParameter('fin', $recherche->getFin());
        }

        if ($recherche->getOrganisateur()) {
            $qb= $qb->andWhere("s.organisateur = :organisateur")
                ->setParameter('organisateur', $participant);
        }

        if ($recherche->getSite() ) {
            $qb=$qb
                ->andWhere("s.site = :site")
                ->setParameter('site', $recherche->getSite());
            dump($qb);
        }

        if ($recherche->getInscrit()) {
            $qb= $qb->andWhere("f.inscrit = :inscrit")
                ->setParameter('inscrit', $participant);
        }
        if ($recherche->getPasInscrit()) {
            $qb=$qb ->andWhere("f.pasInscrit = :pasInscrit")
                ->setParameter('pasInscrit', $participant);
        }
        if ($recherche->getSortiePassee()) {
            $qb=$qb->andWhere('s.dateHeureDebut <= :sortiePassee')
                ->setParameter('sortiePassee', date('d-m-Y'));

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
