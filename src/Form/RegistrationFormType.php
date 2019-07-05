<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['attr' => ['placeholder' => 'Email', 'autofocus' => true,]])

            ->add('password', RepeatedType::class, [

                    'type' => PasswordType::class,
                    'invalid_message' => 'Les mots de passe doivent être identiques',
                    'required' => true,
                    'first_options' => [
                                         'attr' => ['placeholder' => 'Mot de passe']],

                    'second_options' => [
                                         'attr' => ['placeholder' => 'Confirmation du mot de passe']],
                    'mapped' => false,
                    'constraints' => [ new NotBlank([
                                                    'message' => 'Entrer un mot de passe',
                    ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit contenir au minimum {{ limit }} caractères',
                            'max' => 4096,]),
                        ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
