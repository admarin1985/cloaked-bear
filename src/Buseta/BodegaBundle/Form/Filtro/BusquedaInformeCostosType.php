<?php

namespace Buseta\BodegaBundle\Form\Filtro;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class BusquedaInformeCostosType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('almacen','entity',array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'empty_value' => '---Seleccione---',
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
            ->add('fecha','date',array(
                'widget' => 'single_text',
                'empty_value' => '---Seleccione fecha máxima---',
                'required' => false,
                'format'  => 'dd/MM/yyyy',
                'attr'   => array(
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
        return 'data_busqueda_informe_costos_type';
    }
}