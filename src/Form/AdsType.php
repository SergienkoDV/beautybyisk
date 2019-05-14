<?php

namespace App\Form;

use App\Entity\Ads;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('text')
            ->add('img', FileType::class,['label' => 'Добавьте фото',
                'data_class' => null,
                'attr' => [
                    'label' => 'Добавьте изображение',
                    'class' => 'form-control-file',
                    'multiple' =>true,
                    'mapped' => false
                ]
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ads::class,
        ]);
    }
}
