<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MyCustomDateType extends DateType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        // Set the defaults from the DateTimeType we're extending from
        parent::configureOptions($resolver);

        // Override: Go back 20 years and add 20 years
        $resolver->setDefault('years', range(date('Y') + 0, date('Y') - 70));

        // Override: Use an hour range between 08:00AM and 11:00PM
        //$resolver->setDefault('hours', range(8, 23));
    }
}