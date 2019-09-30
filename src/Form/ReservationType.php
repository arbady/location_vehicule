<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_res')
            ->add('date_debut_loc')
            ->add('date_fin_loc')
            ->add('montant_tot_tva')
            ->add('acompte')
            ->add('acompte_paye')
            ->add('statut_res')
            ->add('agence')
            ->add('categorie')
            ->add('user')
            ->add('contrat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
