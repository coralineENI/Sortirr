<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use App\Security\LoginFormAuthenticator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

/**
 *@IsGranted("ROLE_USER",message="Votre compte a été temporeremnet désactivé. Veillez contacter l'administration")
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request,
                             UserPasswordHasherInterface $userPasswordHasherInterface,
                             LoginFormAuthenticator $loginFormAuthenticator,
                             UserAuthenticatorInterface $authenticator): Response
    {
        $participant = new Participant();
        $form = $this->createForm(RegistrationFormType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $participant->setPassword(
            $userPasswordHasherInterface->hashPassword(
                    $participant,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participant);
            $entityManager->flush();

            $this->addFlash('success', 'L\'utilisateur a été crée');

            return $this->redirectToRoute("utilisateurs");


            /* commenter pour ne pas  connecter le nouvel utilisteur

            return $authenticator->authenticateUser(
                 $participant,
                 $loginFormAuthenticator,
                 $request

             );*/

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }



}
