<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Profile;
use App\Entity\Section;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
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
            ] )
            ->add('img', FileType::class,['label' => 'Добавьте фото',
                'data_class' => null,
                'attr' => [
                    'label' => 'Добавьте фото',
                    'class' => 'form-control-file',
                    'multiple' =>true,
                    'mapped' => false
                ]
            ] )
            ->add('vk', TextType::class, ['label' => ' ',
                'attr' => [
                    'label' => false,
                    'type' => 'url',
                    'required' => false,
                    'class' => 'form-control',
                    'placeholder' => 'ССылка на Вконтакте'
                ]
            ] )
            ->add('instagram', TextType::class, ['label' => ' ',
                'attr' => [
                    'label' => false,
                    'type' => 'url',
                    'required' => false,
                    'class' => 'form-control',
                    'placeholder' => 'ССылка на Instagram'
                ]
            ] )
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'label' => 'В чем вы специализируетесь?',
                'attr' => [
                    'class' => 'form-control'],
                'choice_label' => 'name',
            ))
        ;
       /* $builder->get('category')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event){
                $form = $event->getForm();
                $form->getParent()->add('section', EntityType::class, array(
                    'class' => Section::class,
                    'label' => 'В чем вы специализируетесь?',
                    'attr' => [
                        'class' => 'form-control'],
                    'choice_label' => 'name',
                ));

            }
        );*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
