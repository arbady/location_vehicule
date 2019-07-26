<?php

namespace App\Form;

use App\Entity\Contrat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('num_contrat')
            ->add('date_retour_reelle')
            ->add('km_depart')
            ->add('km_retour')
            ->add('date_contrat')
            ->add('montant_tot_htva')
            ->add('montant_tot_tva')
            ->add('signe')
            ->add('reservation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
