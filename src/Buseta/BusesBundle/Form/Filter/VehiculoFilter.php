<?php
namespace Buseta\BusesBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VehiculoFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricula', null, array(
                'required'  => false,
                'label' => 'Matrícula',
                'trim'      => true,
                'attr'      => array(
                    'class' => 'form-control',
                )
            ))
            ->add('numero', null, array(
                'required'  => false,
                'label' => 'Número',
                'trim'      => true,
                'attr'      => array(
                    'class' => 'form-control',
                )
            ))
            ->add('marca','entity',array(
                'class' => 'BusetaNomencladorBundle:Marca',
                'empty_value' => '---Seleccione---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('estilo','entity',array(
                'class' => 'BusetaNomencladorBundle:Estilo',
                'empty_value' => '---Seleccione---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('color','entity',array(
                'class' => 'BusetaNomencladorBundle:Color',
                'empty_value' => '---Seleccione---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('marca_motor','entity',array(
                'class' => 'BusetaNomencladorBundle:MarcaMotor',
                'empty_value' => '---Seleccione---',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
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
            'data_class' => 'Buseta\BusesBundle\Form\Model\VehiculoFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_vehiculo_filter';
    }
} 