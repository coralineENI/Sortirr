<?php

namespace App\Controller;

use App\Repository\SortieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function listeSorties(SortieRepository $sortieRepository): Response
    {
        return $this->render('accueil/afficherListeSorties.html.twig', [
            'page_name' => 'Description Sortie',

        ]);
    }

}
