<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,[
                'label'=>'Nom de la sortie',
                'attr' => [
                    'placeholder' => 'Exemple : La bonne beuverie chez Ant1'
                ]
            ])
            ->add('dateHeureDebut', DateTimeType::class,[
                'label' => 'Date et heure de début de la sortie',
                'date_widget' => 'single_text',
//                'placeholder'=>['day'=>'Jour','month'=>'Mois',
//                    'year'=>'Année','hour'=>'Heure',
//                    'minute'=>'Minutes']
            ])
            ->add('duree', IntegerType::class,[
                'label' => 'Durée de la sortie',
                'attr' => [
                    'placeholder' => 'Durée en minutes'
                ]
            ])
            ->add('dateLimiteInscription', DateTimeType::class,[
                'label' => 'Limite d\'inscription',
                'date_widget' => 'single_text',
            ])
            ->add('nbInscriptionsMax', IntegerType::class,[
                'label' => 'Nombre max de participants',
                'attr' => [
                    'placeholder' => 'Ecrire en lettres'
                ]
            ])
            ->add('infosSortie',TextareaType::class,[
                'label'=>'Informations sur la sortie ',
                'attr' => [
                    'placeholder' => 'Exemple : Grosse soirée chez Ant1 également animateur. Musique joué par les Cata Marrants : Loucass au blackout, Maxime à la vape, Kevin à la grappe et Mathieu a la moustache'
                ]
            ])
//            ->add('etat', ChoiceType::class,[
//                'label'=>'Etat de la sortie',
//                'choices' => [
//                    'Ouvert' => 'ouvert'
//                ]
//
//            ])
//            ->add('organisateur', EntityType::class,[
//                'class' => Participant::class,
//                'choice_label' => 'nom'
//            ])
            ->add('lieu', EntityType::class,[
                'class' => Lieu::class,
                'placeholder' => '- Choisissez un lieu -'
            ])
            ->add('site', EntityType::class,[
                'class' => Site::class,
                'placeholder' => '- Choisissez un site -'
            ])
            ->add('enregistrer', SubmitType::class,[
                'label'=>'Enregistrer'
            ])
            ->add('publier', SubmitType::class,[
                'label'=>'Publier'
            ])
            ->add('cancel', ResetType::class,[
                'label'=>'Annuler',
               'attr' => [
                    'class' => 'btn btn-danger'
                 ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
