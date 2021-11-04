<?php

namespace App\Form;

use App\Entity\Site;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('site', EntityType::class, [
                'class' => Site::class,
                'choice_label' => 'nom',
                'required'=>false,
                'placeholder' => ''
            ])
            ->add('nom', TextType::class, [
                'label' => 'Le nom de la sortie contient :'
            ])
//            ->add('debut', DateTimeType::class, [
//                'label' => 'Entre :',
//                'date_widget' => 'single_text',
//                'html5' => true,
//            ])
//            ->add('fin', DateTimeType::class, [
//                'label' => 'et :',
//                'date_widget' => 'single_text',
//                'html5' => true,
//            ])
            ->add('organisateur', CheckboxType::class, [
                'label' => 'Sortie dont je suis l\'organisateur/trice',
                'required' => false,

            ])
            ->add('inscrit', CheckboxType::class, [
                'label' => 'Sortie auxquelles je suis inscrit/e',
                'required' => false,

            ])
            ->add('pasInscrit', CheckboxType::class, [
                'label' => 'Sortie auxquelles je ne suis pas inscrit/e',
                'required' => false,

            ])
            ->add('sortiePassee', CheckboxType::class, [
                'label' => 'Sorties passées',
                'required' => false,

            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method'=> 'get',
            'csrf_protection'=> false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
