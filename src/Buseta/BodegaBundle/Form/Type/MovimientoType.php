<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MovimientoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('almacenOrigen','entity',array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'empty_value' => '---Seleccione bodega de origen---',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('almacenDestino','entity',array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'empty_value' => '---Seleccione bodega destino---',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('movimientos_productos','collection',array(
                'type' => new MovimientosProductosType(),
                'label'  => false,
                'required' => false,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Entity\Movimiento'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_movimiento';
    }
}
