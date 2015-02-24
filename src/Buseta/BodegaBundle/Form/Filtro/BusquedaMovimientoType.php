<?php

namespace Buseta\BodegaBundle\Form\Filtro;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class BusquedaMovimientoType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fechaInicio','date',array(
                'widget' => 'single_text',
                'empty_value' => '---Seleccione fecha máxima---',
                'required' => false,
                'label' => 'Fecha Inicio',
                'format'  => 'dd/MM/yyyy',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('fechaFin','date',array(
                'widget' => 'single_text',
                'empty_value' => '---Seleccione fecha máxima---',
                'required' => false,
                'label' => 'Fecha Final',
                'format'  => 'dd/MM/yyyy',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('almacenOrigen','entity',array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'empty_value' => '---Seleccione almacén origen---',
                'label' => 'Almacén Origen',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('almacenDestino','entity',array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'empty_value' => '---Seleccione almacén destino---',
                'label' => 'Almacén Destino',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('categoriaProducto','entity',array(
                'class' => 'BusetaBodegaBundle:CategoriaProducto',
                'empty_value' => '---Seleccione categoría de producto---',
                'label' => 'Categoría de Producto',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
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
        return 'data_busqueda_movimiento_producto_type';
    }
}