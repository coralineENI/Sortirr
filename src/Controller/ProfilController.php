<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 *@IsGranted("ROLE_USER",message="Votre compte a été temporeremnet désactivé. Veillez contacter l'administration")
 */
class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="show_profil")
     */
    public function index(): Response
    {

        return $this->render('profil/edit.html.twig', [
            'controller_name' => 'ProfilController',
        ]);
    }

    /**
     * @Route("/profil/{id}", name="edit_profile",requirements={"id"="\d+"}))
     * @IsGranted("ROLE_USER")
     */
    public function modifier(int $id, EntityManagerInterface $em,
                             Request $request,UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $participant = $this->getUser();
        if(!$participant) {
            throw $this->createNotFoundException("Utilisateur inconnu");
        }
        $formProfile = $this->createForm(ProfilType::class, $participant);
        $formProfile->handleRequest($request);

        if($formProfile->isSubmitted() && $formProfile->isValid())
        {
            $participant->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $participant,
                    $formProfile->get('password')->getData()
                )
            );


            $em->persist($participant);
            $em->flush();


            $this->addFlash('success', 'Le profil a  été modifié avec succes!');

        }

        return $this->render("profil/edit.html.twig", [
            'formProfile' => $formProfile->createView()
        ]);

    }

}
