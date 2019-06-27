<?php

namespace App\Form;

use App\Entity\Link;
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
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [

                'label' => 'Prénom',
                'required'=>false
            ])

            ->add('lastname', TextType::class, [

                'label' => 'Nom',
                'required'=>false
            ])
            ->add('artistName', TextType::class, [

                'label'=>'Nom d\'artiste',
                'required'=>false
            ])

            ->add('email', EmailType::class)

            ->add('phoneNumber', TelType::class, [

                'label' => 'N° de téléphone',
                'required'=>false
            ])

            ->add('city', CountryType::class, [

                'label'=>'Ville'
            ])

            ->add('posteCode', NumberType::class, [

                'label'=>'Code postal',
                'required'=>false
            ])

            ->add('birthdate', BirthdayType::class, [

                'label'=>'Date de naissance',
                'required'=>false
            ])

            ->add('address', TextType::class, [

                'label'=>'Adresse',
                'required'=>false
            ])

            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe'],

            ])

            ->add('geoArea', ChoiceType::class, [
                'label' => 'Région',
                'choices'  => [
                    'Région Nord' => 'Région Nord',
                    'Région Nord Ouest' => 'Région Nord Ouest',
                    'Région Nord Est' => 'Région Nord Est',
                    'Région Centre' => 'Région Centre',
                    'Région Sud' => 'Région Sud',
                    'Région Sud Ouest' => 'Région Sud Ouest',
                    'Région Sud Est' => 'Région Sud Est',


                ]])

            ->add('price', MoneyType::class, [

                'label' => 'Tarif',
                'required'=>false
            ])

            ->add('about', TextareaType::class, [

                'label'=>'Description',
                'required'=>false

            ])

            ->add('personsNumber', ChoiceType::class, [
                'label' => 'Nombre de personnes',
                'choices'  => [
                    'Solo' => 'Solo',
                    'Duo' => 'Duo',
                    'Trio' => 'Trio',
                    'Quatuor' => 'Quatuor',
                    '5 +' => '5 +',
                ],
                'required'=>false,
            ])

            ->add('billingType', ChoiceType::class, [
                'label' => 'Type de facturation',
                'choices' => [
                    'Guso' => 'Guso',
                    'Facture' => 'Facture',
                    'Autres' => 'Autres',
                ],
                'required'=>false,
            ])

            ->add('technicalNeeds', TextareaType::class, [
                'label' => 'Besoin(s) technique(s)',
                'required' => false,
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
