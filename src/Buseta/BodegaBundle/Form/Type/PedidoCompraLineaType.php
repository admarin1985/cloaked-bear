<?php

namespace Buseta\BodegaBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PedidoCompraLineaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('linea', 'integer', array(
                    'required' => true,
                    'label'  => 'Línea',
                    'attr'   => array(
                        'class' => 'form-control',
                        'style' => 'height: 28px; font-size: 10px;',
                    )
                ))
            ->add('producto','entity',array(
                'class' => 'BusetaBodegaBundle:Producto',
                'empty_value' => '---Seleccione un producto---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'height: 28px; font-size: 10px;',
                )
            ))
            ->add('cantidad_pedido', 'integer', array(
                'required' => true,
                'label'  => 'Cantidad de pedido',
                'attr'   => array(
                    'class' => 'form-control',
                    'style' => 'height: 28px; font-size: 10px;',
                )
            ))
            ->add('uom','entity',array(
                'class' => 'BusetaNomencladorBundle:UOM',
                'empty_value' => '---Seleccione unidad de medida---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'height: 28px; font-size: 10px;',
                )
            ))
            ->add('precio_unitario', 'integer', array(
                'required' => true,
                'read_only' => true,
                'label'  => 'Precio unitario',
                'attr'   => array(
                    'class' => 'form-control',
                    'style' => 'height: 28px; font-size: 10px;',
                )
            ))
            ->add('impuesto','entity',array(
                    'class' => 'BusetaTallerBundle:Impuesto',
                    'empty_value' => '---Seleccione impuesto---',
                    'required' => true,
                    'attr' => array(
                        'class' => 'form-control',
                        'style' => 'height: 28px; font-size: 10px;',
                    )
            ))
            ->add('moneda','entity',array(
                'class' => 'BusetaNomencladorBundle:Moneda',
                'empty_value' => '---Seleccione moneda---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                    'style' => 'height: 28px; font-size: 10px;',
                )
            ))
            ->add('porciento_descuento', 'text', array(
                'required' => true,
                'label'  => '% Descuento',
                'attr'   => array(
                    'class' => 'form-control',
                    'style' => 'height: 28px; font-size: 10px;',
                )
            ))
            ->add('importe_linea', 'text', array(
                'required' => true,
                'read_only' => true,
                'label'  => 'Importe línea',
                'attr'   => array(
                    'class' => 'form-control',
                    'style' => 'height: 28px; font-size: 10px;',
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\BodegaBundle\Entity\PedidoCompraLinea'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_bodegabundle_pedido_compra_linea';
    }
}
