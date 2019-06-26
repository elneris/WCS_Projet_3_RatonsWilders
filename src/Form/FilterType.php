<?php

namespace App\Form;

use App\Entity\Domain;
use App\Entity\Skill;
use App\Entity\Style;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'metier',
                EntityType::class,
                [
                    'class' => Domain::class,
                    'choice_label' => 'name',
                    'label' => 'Métier'
                ]
            )
            ->add(
                'style',
                EntityType::class,
                [
                    'class' => Style::class,
                    'choice_label' => 'type',
                    'label' => 'Style',
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
                    'label' => 'Skill',
                    'required' => false,
                    'placeholder' => 'Tous'
                ]
            )
            ->add('Filtrer', SubmitType::class);
    }
}
