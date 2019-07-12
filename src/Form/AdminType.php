<?php

namespace App\Form;

use App\Entity\Domain;
use App\Entity\Skill;
use App\Entity\Style;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
