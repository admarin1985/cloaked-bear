<?php

namespace Buseta\BusesBundle\Form\Type;

use Buseta\BusesBundle\Form\EventListener\AddMarcaFieldSubscriber;
use Buseta\BusesBundle\Form\EventListener\AddModeloFieldSubscriber;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;

class VehiculoType extends AbstractType
{
    /**
     * @var SecurityContextInterface
     */
    private $securityContext;

    /**
     * Constructor
     *
     * @param SecurityContextInterface $securityContext
     */
    function __construct(SecurityContextInterface $securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objeto = $builder->getFormFactory();
        $modelo = new AddModeloFieldSubscriber($objeto);
        $builder->addEventSubscriber($modelo);
        $marca = new AddMarcaFieldSubscriber($objeto);
        $builder->addEventSubscriber($marca);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $autobus    = $event->getData();
            $form       = $event->getForm();

            if ($autobus && null !== $autobus->getId() || $this->securityContext->isGranted('ROLE_ADMIN')) {
                $form
                    ->add('kilometraje', 'integer', array(
                        'required' => false,
                    ))
                    ->add('horas', 'integer', array(
                        'required' => false,
                    ));
            }
        });

        $builder
            ->add('id', 'hidden', array(
                'required' => false,
            ))
            ->add('matricula', 'text', array(
                'required' => true,
                'label' => 'Matrícula',
            ))
            ->add('numero', 'text', array(
                'required' => true,
                'label' => 'Número',
            ))
            ->add('capacidadTanque', 'number', array(
                'required' => true,
                'label' => 'Capacidad Tanque',
            ))

            ->add('numeroPlazas', 'integer', array(
                'required' => true,
                'label' => 'Número Plazas',
            ))
            ->add('numeroCilindros', 'integer', array(
                'required' => true,
                'label' => 'Número Cilindros',
            ))
            ->add('cilindrada', 'integer', array(
                'required' => true,
                'label' => 'Cilindrada',
            ))
            ->add('potencia', 'integer', array(
                'required' => true,
                'label' => 'Potencia',
            ))

            ->add('estilo','entity',array(
                'class' => 'BusetaNomencladorBundle:Estilo',
                'empty_value' => '---Seleccione---',
            ))
            ->add('color', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Color',
                'empty_value' => '---Seleccione---',
            ))
            ->add('marcaMotor', 'entity', array(
                    'class' => 'BusetaNomencladorBundle:MarcaMotor',
                    'label' => 'Marca de Motor',
                    'empty_value' => '---Seleccione---',
                ))
            ->add('combustible', 'entity', array(
                'class' => 'BusetaNomencladorBundle:Combustible',
                'empty_value' => '---Seleccione---',
            ))
            ->add('marcaCajacambio', 'text', array(
                'required' => false,
                'label' => 'Marca de Caja Cambios',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('tipoCajacambio', 'text', array(
                'required' => false,
                'label' => 'Tipo de Caja Cambios',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('anno', 'number', array(
                'required' => false,
                'label' => 'Año',
                'attr'   => array(
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
                'data_class' => 'Buseta\BusesBundle\Form\Model\VehiculoModel',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buses_vehiculo';
    }
}