<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('artistName')
            ->add('email')
            ->add('phoneNumber')
            ->add('city')
            ->add('posteCode')
            ->add('birthdate')
            ->add('address')
            ->add('password')
            ->add('geoArea')
            ->add('price')
            ->add('about')
            ->add('role')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
