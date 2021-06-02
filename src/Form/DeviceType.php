<?php

namespace App\Form;

use App\Entity\Device;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeviceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mac')
            ->add('name')
            ->add('hostname')
            ->add('type')
            ->add('vendor')
            ->add('favorite')
            ->add('firstConnection')
            ->add('lastConnection')
            ->add('lastIP')
            ->add('alertDeviceDown')
            ->add('isGuest')
            ->add('isNewDevice')
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
