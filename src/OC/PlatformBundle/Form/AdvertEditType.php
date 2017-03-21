<?php
// src/OC/PlatformBundle/Form/AdvertEditType.php

namespace OC\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AdvertEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('date'); // we don't want to be able to change the date when editing an advert
    }

    public function getParent() // automatically called by Symfony (form inheritance)
    {
        return AdvertType::class;
    }
}
