<?php

namespace App\Form;

use App\Entity\Slider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('img', TextType::class, ['label' => ' ',
                'attr' => [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'URL изображения'
                ]
            ] )
            ->add('description', TextType::class, ['label' => ' ',
                'attr' => [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Описание'
                ]
            ] )

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Slider::class,
        ]);
    }
}
