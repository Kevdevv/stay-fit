<?php

namespace App\Form;

use App\Entity\Franchise;
use App\Entity\Structure;
use App\Repository\FranchiseRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructureType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('active')
            ->add('name')
            ->add('mail')
            ->add('address')
            ->add('sell_drink')
            ->add('mailing')
            ->add('promotion_salle')
            ->add('team_planning')
            ->add('franchise', EntityType::class, [
                'class' => Franchise::class,
                'choice_label' => 'name',
                'multiple' => false,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Structure::class,
        ]);
    }
}
