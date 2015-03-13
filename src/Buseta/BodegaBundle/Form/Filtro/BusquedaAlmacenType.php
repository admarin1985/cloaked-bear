<?php

namespace Buseta\BodegaBundle\Form\Filtro;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BusquedaAlmacenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo', 'text', array(
                'required' => false,
                'label' => 'Código',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('nombre', 'text', array(
                'required' => true,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('descripcion', 'textarea', array(
                'required' => false,
                'label' => 'Descripción',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('direccion', 'textarea', array(
                'required' => false,
                'label' => 'Dirección',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'csrf_protection' => false,
            ));
    }

    public function getName()
    {
        return 'data_busqueda_almacen_type';
    }
}
