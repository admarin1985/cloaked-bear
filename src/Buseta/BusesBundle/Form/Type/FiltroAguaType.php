<?php

namespace Buseta\BusesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiltroAguaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filtroAgua1', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('filtroAgua2', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Buseta\BusesBundle\Entity\FiltroAgua',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_databundle_filtro_agua';
    }
}
