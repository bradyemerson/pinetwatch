<?php

namespace App\Form;

use App\Entity\Device;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Device1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mac')
            ->add('name')
            ->add('hostname')
            ->add('type')
            ->add('vendor')
            ->add('isFavorite')
            ->add('firstConnection')
            ->add('lastConnection')
            ->add('lastIP')
            ->add('alertDeviceDown')
            ->add('isGuest')
            ->add('isNewDevice')
            ->add('isWired')
            ->add('port')
            ->add('satisfaction')
            ->add('signal')
            ->add('identifiedBy')
            ->add('network')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Device::class,
        ]);
    }
}
