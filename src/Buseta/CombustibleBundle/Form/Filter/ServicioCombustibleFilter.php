<?php
namespace Buseta\CombustibleBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServicioCombustibleFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chofer','entity',array(
                'class' => 'BusetaBusesBundle:Chofer',
                'empty_value' => '---Seleccione---',
                'label' => 'Chofer',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('combustible','entity',array(
                'class' => 'BusetaCombustibleBundle:ConfiguracionCombustible',
                'empty_value' => '---Seleccione---',
                'label' => 'Nomenclador de Combustible',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('vehiculo','entity',array(
                'class' => 'BusetaBusesBundle:Vehiculo',
                'empty_value' => '---Seleccione---',
                'label' => 'Vehículo',
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\CombustibleBundle\Form\Model\ServicioCombustibleFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_servicio_combustible_filter';
    }
}
