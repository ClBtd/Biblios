<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                "label" => "* Prénom"
            ])
            ->add('lastname', TextType::class, [
                "label" => "* Nom"
            ])
            ->add('username', TextType::class, [
                "label" => "Nom d'utilisateur", 
                'required' => false
            ])
            ->add('email', TextType::class, [
                "label" => "* Adresse email"
            ])
            ->add('roles', ChoiceType::class, [
                "label" => "Rôles",
                'multiple' => true,
                'expanded' => true,
                "choices" => [
                    'Utilisateur.ice' => 'ROLE_USER',
                    'Administrateur.ice' => 'ROLE_ADMIN'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                "label" => "* Mot de passe",
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
