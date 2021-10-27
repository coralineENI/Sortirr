<?php

namespace App\Controller;


use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\FiltresType;
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
    public function listeSorties(SortieRepository $sortieRepository, Request $request, EntityManagerInterface $em): Response
    {

        $sortiesListe = null;
        $form = $this->createForm(FiltresType::class, null);
        $form->handleRequest($request);

            $now = new DateTime();

            $lieu = $form['site']->getData();

            $debut = $form['debut']->getData();
            $fin = $form['fin']->getData();
            $organisateur = $form['organisateur']->getData();
            $inscrit = $form['inscrit']->getData();
            $pasInscrit = $form['pasInscrit']->getData();
            $sortiePassee = $form['sortiePassee']->getData();
      //      $user = $em->getRepository(Participant::class)->find($this->getUser()->getUserIdentifier());
        //    $this->sortiesListe = $sortieRepository->findAllFilter($user, $lieu,$organisateur);
        $sortiesListe= $sortieRepository->findAll();

        return $this->render('accueil/afficherListeSorties.html.twig', [
            'now'=> $now,
            'pasInscrit' => $pasInscrit,
            'inscrit' => $inscrit,
            'form' => $form->createView(),
            'sorties' => $sortiesListe
        ]);
    }

}
