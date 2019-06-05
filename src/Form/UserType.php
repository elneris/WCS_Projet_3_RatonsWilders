<?php

namespace App\Form;

use App\Entity\Media;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class, [

                'label' => 'Prénom'
            ])

            ->add('lastname',TextType::class, [

                'label' => 'Nom'
            ])
            ->add('artistName',TextType::class,[

                'label'=>"Nom d'artiste"
            ])

            ->add('email',EmailType::class)

            ->add('phoneNumber',TelType::class,[

                'label' => 'N° de téléphone'
            ])

            ->add('city',CountryType::class,[

                'label'=>'Ville'
            ])

            ->add('posteCode',NumberType::class, [

                'label'=>'Code postal'
            ])

            ->add('birthdate',BirthdayType::class,[

                'label'=>'Date de naissance'
            ])

            ->add('address',TextType::class,[

                'label'=>'Adresse'
            ])

            ->add('password',RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],

            ])

            ->add('geoArea', ChoiceType::class,[
                'choices'  => [
                    'Région Nord' => null,
                    'Région Nord Ouest' => null,
                    'Région Nord Est' => null,
                    'Région Centre' => null,
                    'Région Sud' => null,
                    'Région Sud Ouest' => null,
                    'Région Sud Est' => null,


                ]])

            ->add('price', MoneyType::class, [

                'divisor' => 100,
                'label' => 'Tarif',
            ])

            ->add('about',TextareaType::class,[
                'label'=>'Description'
            ])

            ->add('links', EntityType::class, [

                'label' => 'Liens photos',
                'class' => Media::class,
                'choice_label' => 'type'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
