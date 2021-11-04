<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Entity\Villes;
use App\Repository\InscriptionRepository;
use App\Repository\LieuRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SiteRepository;
use App\Repository\SortieRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 *@IsGranted("ROLE_USER",message="Votre compte a été temporairement désactivé. Veillez contacter l'administration")
 */

class AdminController extends AbstractController
{

    /**
     * @Route("/utilisateur", name="utilisateurs")
     */
    public function usersList(ParticipantRepository  $utiliss) :Response
    {
        $utiliss=$this->getDoctrine()->getRepository(Participant::class)->findAll();
        return  $this->render('admin/users.html.twig',[
            'utiliss' => $utiliss
        ]);
    }



    /**
     * @Route("/utilisateur/detaiil/{id}", name="detail_utilisateur",requirements={"id"="\d+"}),methods={"GET"})
     */
    public function showUser(int $id ,ParticipantRepository  $participantRepository) :Response
    {
        $util = $participantRepository->find($id);

        if (!$util)
        {
            throw $this->createNotFoundException("Utilisateur inconnu");
        }
        return  $this->render('admin/detail.users.html.twig',[
            'util' => $util

        ]);
    }



    /**
     * @Route("/utilisteur/supprimer/{id}", name="supprimer_utilisateur")
     */
    public function supprimer(int $id, EntityManagerInterface $em, Request $request)
    {
        $participant = $em->getRepository(Participant::class)->find($id);
        if (!$participant)
        {
            throw $this->createNotFoundException("L'utilisateur inconu ou déjà supprimé");
        }

            $em->remove($participant);
            $em->flush();
            $this->addFlash("success", "L'utilisateur a été supprimé");
            return $this->redirectToRoute('utilisateurs');

    }

    /**
     * @Route("/utilisteur/innactifactif/{id}", name="desactiver_activer_utilisateur")
     */

    public function desactiveracriver(int $id, EntityManagerInterface $em,
                             Request $request): Response
    {
        $participant = $em->getRepository(Participant::class)->find($id);
        if(!$participant) {
            throw $this->createNotFoundException("Utilisateur inconnu");
        }

        if ($participant->getActif()==0)
        {

            $participant->setActif(1);
            $participant->setRoles(["ROLE_USER"]);
            $this->addFlash('success', 'Le participant a  été activé !');
        }
        else
        {
            $participant->setActif(0);
            $participant->setRoles(["ROLE_RIEN"]);
            $this->addFlash('success', 'Le participant a  été désactivé !');
        }

            $em->persist($participant);
            $em->flush();
            return $this->redirectToRoute('utilisateurs');

    }


    /**
     * @Route("/lieux", name="lieux")
     */
    public function gestionLieux(Request $request, EntityManagerInterface $em)
    {
         $lieu = null;
        $this->$lieu=$em->getRepository(Lieu::class)->findAll();
        return  $this->render('gestion_lieux/lieux.html.twig',[
            'lieu' => $this-> $lieu
        ]);
    }

    /**
     * @Route("/site", name="site")
     */
    public function gestionSite(Request $request, EntityManagerInterface $em)
    {
        $site=null;
        $this->$site=$em->getRepository(Site::class)->findAll();
        return  $this->render('gestion_site/site.html.twig',[
            'site' => $this-> $site
        ]);
    }
}
