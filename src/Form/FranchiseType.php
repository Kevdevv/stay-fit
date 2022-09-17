<?php

namespace App\Form;

use App\Entity\Franchise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FranchiseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('active')
            ->add('name')
            ->add('mail')
            ->add('sell_drink')
            ->add('mailing')
            ->add('promotion_salle')
            ->add('team_planning')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Franchise::class,
        ]);
    }
}
