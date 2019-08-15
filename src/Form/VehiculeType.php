<?php

namespace App\Form;

use App\Entity\Vehicule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule', TextType::class, [
                'label_attr' => [
                    'class' => 'form_mat'
                ],
                'required' => true,
            ])
            //->add('matricule')
            //->add('caracteristiques')
            ->add('caracteristiques', TextType::class, [
                'label_attr' => [
                    'class' => 'form_car'
                ],
                'required' => true,
            ])
            ->add('categorie')
            ->add('etat')
            ->add('modele')
            /*->add('save', SubmitType::class);*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicule::class,
        ]);
    }
}
