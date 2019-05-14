<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisitorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => ' ',
                'attr' => [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Имя'
                ]
            ] )
            ->add('surname', TextType::class, ['label' => ' ',
                'attr' => [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Отчество'
                ]
            ] )
            ->add('family', TextType::class, ['label' => ' ',
                'attr' => [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Фамилия'
                ]
            ] )
            ->add('telephone', TextType::class, ['label' => ' ',
                'attr' => [
                    'label' => false,
                    'type' => 'tel',
                    'class' => 'form-control',
                    'placeholder' => 'телефон'
                ]
            ] );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
