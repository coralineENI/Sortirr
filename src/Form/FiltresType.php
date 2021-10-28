<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\Sortie;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('site', EntityType::class, [
                'class' => Site::class,
                'label'    => 'Site : ',
                'required'=>false,
                "choice_label" => "nom",
                'placeholder'=>"Saisir un site"

            ])
            ->add('nom', TextType::class,[
                'label' => 'Le nom de la sortie contient : ',
                'required'=>false,
                'attr'=>[
                    'placeholder'=>"recherche"
                ]
            ])
            ->add('debut', DateType::class,  [
                'label'    => 'Entre ',
                'required'=>false,
                'format' => 'dd-MM-yyyy',
                'mapped'  => false,
                'attr' => [
                    'class' => 'form-control datetimepicker-input',
                    'data-toggle'=>'datetimepicker',
                    'data-target'=>'#filter_debut'
                ]
                ])
            ->add('fin', DateType::class,  [
                'label'    => 'et ',
                'required'=>false,
                'format' => 'dd-MM-yyyy',
                'mapped'  => false,
                'attr' => [
                    'class' => 'form-control datetimepicker-input',
                    'data-toggle'=>'datetimepicker',
                    'data-target'=>'#filter_fin'

                ]])
            ->add('organisateur',CheckboxType::class,  [
                'required'=>false,
                'label'    => 'Sorties dont je suis l\'organisateur/trice ',])
            ->add('inscrit',CheckboxType::class,  [
                'required'=>false,
                'mapped'  => false,
                'label'    => 'Sorties auxquelles je suis inscrit/e ',])
            ->add('pasInscrit',CheckboxType::class,  [
                'required'=>false,
                'mapped'  => false,
        'label'    => 'Sorties auxquelles je ne suis pas inscrit/e ',])
            ->add('sortiePassee',CheckboxType::class,  [
                'required'=>false,
                'mapped'  => false,
        'label'    => 'Sorties passées',])

        ->add('submit', SubmitType::class, [
        'label' => 'Rechercher',
        'attr' => [
            'class' => 'btn btn-primary btn-xl bouton'
        ]
    ]);


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
