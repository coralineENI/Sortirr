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
     */
    public function listeSorties(SortieRepository $sortieRepository, Request $request, EntityManagerInterface $em)
    {

        $sortiesListe = null;
        $pasInscrit = null;
        $inscrit = null;
        $nom = null ;
        $form = $this->createForm(FiltreType::class,null );
        $form->handleRequest($request);
        $now = new DateTime();

        if ($form->isSubmitted() and $form->isValid()){

            //récupération des données du formulaire
        $site = $form['site']->getData();
        $nom = $form['nom']->getData();
        $debut = $form['debut']->getData();
        $fin = $form['fin']->getData();
        $organisateur = $form['organisateur']->getData();
        $inscrit = $form['inscrit']->getData();
        $pasInscrit = $form['pasInscrit']->getData();
        $sortiePassee = $form['sortiePassee']->getData();

        dump($form);

        $participant = $em->getRepository(Participant::class)->find($this->getUser()->getId());
        $this->sortiesListe = $sortieRepository->findAllFilter($participant, $site,$nom, $organisateur , $debut, $fin, $sortiePassee);

        }
        else {
            $sortiesListe = $sortieRepository->findAll();
        }


        return $this->render('accueil/afficherListeSorties.html.twig', [
            'now'=> $now,
            'pasInscrit' => $pasInscrit,
            'inscrit' => $inscrit,
            'page_name' => "Sorties",
            'app_name' => 'Evenements',
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
