<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom d\'utilisateur',
                    'class' => 'form-control'
                ],
                'required' => true,
                'label' => 'Nom d\'utilisateur'

            ])

            ->add('email', TextType::class, [
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'form-control'
                ],
                'required' => true
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => [
                    'attr' => [
                        'placeholder' => 'Mot de passe',
                        'class' => 'form-control'
                    ],
                    'label' => 'Mot de passe'

                ],
                'second_options' => [
                    'attr' => [
                        'placeholder' => 'Confirmer mot de passe',
                        'class' => 'form-control'
                    ],
                    'label' => 'Confirmer le mot de passe'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-lg btn-warning w-100'
                ],
                'label' => 'S\'inscrire'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
