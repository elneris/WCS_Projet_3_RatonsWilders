<?php

namespace App\Form;

use App\Entity\Domain;
use App\Entity\Media;
use App\Entity\Skill;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
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

            ->add('password',PasswordType::class, [

                'label' =>'Mot de passe'
            ])

            ->add('geoArea')

            ->add('price', MoneyType::class, [

                'divisor' => 100,
                'label' => 'Tarif',
            ])

            ->add('about',TextType::class,[
                'label'=>'Description'
            ])

            ->add('activities', EntityType::class, [

                'label' => 'Domaine',
                'class' => Domain::class,
                'choice_label' => 'name',
            ])

            ->add('activities', EntityType::class, [

                'label' => 'Accessoire',
                'class' => Skill::class,
                'choice_label' => 'name'
            ])


            ->add('links', EntityType::class, [

                'label' => 'Liens photos',
                'class' => Media::class,
                'choice_label' => 'url'
    ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
