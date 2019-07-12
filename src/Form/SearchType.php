<?php

namespace App\Form;

use App\Entity\Domain;
use App\Entity\Skill;
use App\Entity\Style;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('zone', ChoiceType::class, [
                'label' => 'Zone de déplacement',
                'choices'  => [
                    'Tous' => null,
                    'Région Nord' => 'Région Nord',
                    'Région Nord Ouest' => 'Région Nord Ouest',
                    'Région Nord Est' => 'Région Nord Est',
                    'Région Centre' => 'Région Centre',
                    'Région Sud' => 'Région Sud',
                    'Région Sud Ouest' => 'Région Sud Ouest',
                    'Région Sud Est' => 'Région Sud Est',


                ]])
            ->add(
                'metier',
                EntityType::class,
                [
                    'class' => Domain::class,
                    'choice_label' => 'name',
                    'label' => 'Domaine (Danse, Musique..)',
                    'required' => false,
                    'placeholder' => 'Tous'
                ]
            )
            ->add(
                'style',
                EntityType::class,
                [
                    'class' => Style::class,
                    'choice_label' => 'type',
                    'label' => 'Style (Rock, Blues..)',
                    'required' => false,
                    'placeholder' => 'Tous'
                ]
            )
            ->add(
                'skill',
                EntityType::class,
                [
                    'class' => Skill::class,
                    'choice_label' => 'name',
                    'label' => 'Accessoire (Guitare, Violon..)',
                    'required' => false,
                    'placeholder' => 'Tous'
                ]
            )
            ->add(
                'searchField',
                null,
                [
                    'label' => 'Recherche par : Nom, Email ...',
                    'required' => false
                ]
            )
            ->add('Rechercher', SubmitType::class);
    }
}
