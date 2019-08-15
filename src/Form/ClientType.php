<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')

            ->add('sexe', ChoiceType::class, [
                'choices' => [ 'Veuillez choisir' => null, 'M' => 'M', 'F' => 'F', ]
            ])

            ->add('date_naissance', DateType::class, [
                'widget' => 'single_text'
            ])

            ->add('adresse')
            ->add('telephone')

            ->add('date_inscription', DateType::class, [
                'widget' => 'single_text'
            ])

            ->add('email')
            ->add('password', PasswordType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
