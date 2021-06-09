<?php

namespace App\Form;

use App\Entity\Privatisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PrivatisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('capacite', TextType::class, [
                'label' => 'Capacite',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Nombre de personne (ex 250)"
                ]
            ])
            ->add('surface', TextType::class, [
                'label' => 'Surface',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Ex 50 m2"
                ]
            ])
            ->add('service', TextType::class, [
                'label' => 'Service',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Service propose"
                ]
            ])
            ->add('annonce', TextareaType::class, [
                'label' => 'Annonce',
                'attr' => [
                    'class' => 'form-control privatisation_annonce'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Privatisation::class,
        ]);
    }
}