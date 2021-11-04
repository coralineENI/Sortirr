<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnulerSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('nom')
//            ->add('dateHeureDebut')
//            ->add('duree')
//            ->add('dateLimiteInscription')
//            ->add('nbInscriptionsMax')
//            ->add('infosSortie')
//            ->add('etat')
//            ->add('organisateur')
//            ->add('lieu')
//            ->add('site')

        ->add('motif', TextareaType::class,[
            'label'=>'Motif de l\'annulation',
                'attr' => [
                    'placeholder'=>'Une bonne raison ou j\'te bute'
                ],
            ])
            ->add('annulerSortie', SubmitType::class,[
                'label'=>'Annuler la sortie'
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
