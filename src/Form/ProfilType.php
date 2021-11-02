<?php

namespace App\Form;

use App\Entity\Participant;
use App\Entity\Site;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('username',TextType::class,[
                'label'=>'Pseudo',
            ])
            ->add('prenom',TextType::class,[
                'label'=>'Prénom'
            ])

            ->add('nom', TextType::class, [
                'label' => 'Nom'
            ])
           ->add('telephone',IntegerType::class,[
               'label'=>"Numéro de téléphone"
           ])
            ->add('mail',EmailType::class,[
                'label'=>"Adresse meil"
            ])
            ->add('password',PasswordType::class,[
                'label'=>"Mot de passe"
            ])
            ->add('confirm_password',PasswordType::class,[
                'label'=>"Confirmer le mot de passe"
            ])
            ->add('site',EntityType::class,[
                'class'=>Site::class,
                'choice_label'  => "nom",

            ])

        ->add('imageFile',VichImageType::class,[
            'required' => false,
            'allow_delete' => true,
            'delete_label' => 'Supprimer votre image actuelle',
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
