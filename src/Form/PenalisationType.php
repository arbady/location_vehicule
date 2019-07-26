<?php

namespace App\Form;

use App\Entity\Penalisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PenalisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('date_penal')
            ->add('montant_a_payer')
            ->add('montant_tot_htva')
            ->add('montant_tot_tva')
            ->add('contrat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Penalisation::class,
        ]);
    }
}
