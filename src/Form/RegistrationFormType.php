<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom:',
                'attr' => [
                    'placeholder' => 'John',
                ],
                'required' => true,
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom:',
                'attr' => [
                    'placeholder' => 'Doe',
                ],
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email:',
                'attr' => [
                    'placeholder' => 'john@exemple.com',
                ],
                'required' => true,
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre',
                'mapped' => false,
                'first_options' => [
                    'label' => 'Mot de passe:',
                    'required' => true,
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'S3CR3T',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez renter un mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit être supérieur à {{ limit }} caractères.',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                        new Regex(
                            pattern: '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,16}$/',
                            message: 'Votre mot de passe doit contenir au moins 1 nombre, 1 lettre en minuscule, 1 lettre en majuscule et un caractère spécial',
                        ),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe:',
                    'attr' => [
                        'placeholder' => 'S3CR3T',
                    ],
                    'required' => true,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
