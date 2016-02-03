<?php

namespace Buseta\BusesBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltroAceiteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('filtroAceite1', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('filtroAceite2', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('filtroAceite3', 'text', array(
                    'required' => false,
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        /*$resolver->setDefaults(array(
            'data_class' => 'Buseta\BusesBundle\Entity\FiltroAceite'
        ));*/
        $resolver->setDefaults(array(
                'data_class' => 'Buseta\BusesBundle\Entity\FiltroAceite',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_databundle_filtro_aceite';
    }
}
