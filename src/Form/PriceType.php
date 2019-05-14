<?php

namespace App\Form;

use App\Entity\Price;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('service', TextType::class, ['label' => ' ',
                'attr' => [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Услуга'
                ]
            ] )
            ->add('price', TextType::class, ['label' => ' ',
                'attr' => [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Цена'
                ]
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Price::class,
        ]);
    }
}
