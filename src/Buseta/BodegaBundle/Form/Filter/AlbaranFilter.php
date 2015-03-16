<?php
namespace Buseta\BodegaBundle\Form\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class AlbaranFilter extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numeroReferencia', 'text', array(
                'required' => false,
                'label'  => 'Nro.Referencia',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('consecutivoCompra', 'text', array(
                'required' => false,
                'label'  => 'Nro.Documento',
                'attr'   => array(
                    'class' => 'form-control',
                )
            ))
            ->add('almacen','entity',array(
                'class' => 'BusetaBodegaBundle:Bodega',
                'label' => 'Almacén',
                'empty_value' => '---Seleccione almacén---',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('tercero','entity',array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'query_builder' => function(EntityRepository $er){
                    return $er->createQueryBuilder('t')
                        ->where('t.proveedor = true');
                },
                'empty_value' => '---Seleccione proveedor---',
                'required' => false,
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
            'data_class' => 'Buseta\BodegaBundle\Form\Model\AlbaranFilterModel',
            'method' => 'GET',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_albaran_filter';
    }
} 