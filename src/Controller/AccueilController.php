<?php

namespace App\Controller;


use App\Entity\Filtres;
use App\Entity\Inscription;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\FiltresType;
use App\Form\FiltreType;
use App\Repository\SortieRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function listeSorties(SortieRepository $sortieRepository, Request $request, EntityManagerInterface $em) : Response
    {

        $recherche = new Filtres();
        $sortiesListe = null;
        $form = $this->createForm(FiltresType::class,$recherche );
        $form->handleRequest($request);
        $now = new DateTime();

        if ($form->isSubmitted() and $form->isValid()){

        $participant = $em->getRepository(Participant::class)->find($this->getUser()->getId());

        $this->sortiesListe = $sortieRepository->findAllFilter($recherche, $participant);

        }
        else {
            $sortiesListe = $sortieRepository->findAll();
        }


        return $this->render('accueil/afficherListeSorties.html.twig', [
            'now'=> $now,
            'form' => $form->createView(),
            'sorties' => $sortiesListe
        ]);
    }

    /**
     * @Route("/ajoutParticipant/{id}", name="ajout_participant_sortie")
     */
    public function ajout_participant(EntityManagerInterface $em, Request $request, Sortie $sortie){

        $participant = $em->getRepository(Participant::class)->find($this->getUser()->getId());
        $inscription = new Inscription();
        $inscription->setSortie($sortie);
        $inscription->setParticipant($participant);

        $em->persist($inscription);
        $em->flush();
        $this->addFlash('success', 'L\'inscription a bien été comptabilisée !');

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/retraitParticipant/{id}", name="retrait_participant_sortie")
     */
    public function retrait_participant(EntityManagerInterface $em, Request $request){

        $participant = $this->getUser()->getId();
        $sortie = $em->getRepository(Sortie::class)->find($request->get('id'));
        $inscription = $em->getRepository(Inscription::class)->findBy(['sortie'=>$sortie->getId(), 'participant'=>$participant]);

        $em->remove($inscription[0]);
        $em->flush();
        $this->addFlash('success', 'Vous êtes bien désinscrit de la sortie !');

        return $this->redirectToRoute('home');
    }

}
