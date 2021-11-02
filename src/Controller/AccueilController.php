<?php

namespace App\Controller;

use App\Repository\SortieRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @IsGranted("ROLE_USER",message="Votre compte a été temporeremnet désactivé. Veillez contacter l'administration")
     */
    public function listeSorties(SortieRepository $sortieRepository): Response
    {
        $user = $this->getUser();

        if ($user)
        {

            return $this->render('accueil/afficherListeSorties.html.twig') ;
        }
        else
        {
            return $this->redirectToRoute('app_login') ;
        }
    }
}
