<?php

namespace App\Form;

use App\Entity\Domain;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class FilterDomainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                EntityType::class,
                ['class' => Domain::class,
                    'choice_label' => 'name',
                    'label' => 'Métier'
                ]
            )
            ->add('Recherche', SubmitType::class);
    }
}
