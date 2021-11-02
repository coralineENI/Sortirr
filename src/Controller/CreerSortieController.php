<?php

namespace App\Controller;

use App\Entity\Sortie;
use App\Form\SortieType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreerSortieController extends AbstractController
{
    /**
     * @Route("/sortie/creer", name="creer_sortie")
     */
    public function creerSortie(Request $request, EntityManagerInterface $em): Response
    {
        $sortie = new Sortie();

        $formSortie = $this->createForm(SortieType::class, $sortie);

        $formSortie->handleRequest($request);
        if($formSortie->isSubmitted() && $formSortie->isValid()){
            $sortie->setOrganisateur($this->getUser());
            $em->persist($sortie);
            $em->flush();
            return $this->redirectToRoute('home',['id'=>$sortie->getId()]);
        }

        return $this->render('creer_sortie/creer_sortie.html.twig', [
            'formSortie' => $formSortie->createView()
        ]);
    }

    /**
     * @Route("sortie/modifier/{id}", name="modifier_sortie")
     */
    public function modifierSortie(int $id, Request $request, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
        $sortie = $em->getRepository(Sortie::class)->find($id);
        if(!$sortie){
            throw $this->createNotFoundException("Cette sortie n'existe pas");
        }
        if ($sortie->getOrganisateur() != $this->getUser()) {
            throw $this->createAccessDeniedException("Vous n'avez les droits de modification");
        }
        $formSortie = $this->createForm(SortieType::class, $sortie);
        $formSortie->handleRequest($request);
        if($formSortie->isSubmitted() && $formSortie->isValid()){
            $sortie->setOrganisateur($this->getUser());
            $em->persist($sortie);
            $em->flush();
            $this->addFlash('success', 'Sortie modifiée');
            return $this->redirectToRoute('home',['id'=>$sortie->getId()]);
        }
        return $this->render('creer_sortie/modifier_sortie.html.twig', [
            'formSortie' => $formSortie->createView()
        ]);
    }

}
