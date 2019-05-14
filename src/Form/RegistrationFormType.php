<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label' => 'Логин',
                'attr' => [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Придумайте логин'
                ]
            ] )
            ->add('master',ChoiceType::class, [
                'label' => 'Зарегестрироваться как:',
                'attr' => [
                    'class' => 'form-control',
                ],
                'choices'  => array(
                    'Пользователь' => null,
                    'Мастер' => 1,
                )])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Пароль',
                'attr' => [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'не менее 6 символов'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Пожалуйста, введите пароль',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Пароль должен быть не короче 6 символов',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
