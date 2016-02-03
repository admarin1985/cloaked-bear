<?php

namespace Buseta\TallerBundle\Form\Type;

use Buseta\TallerBundle\Form\EventListener\AddGarantiaTareaAdicionalFieldSubscriber;
use Buseta\TallerBundle\Form\EventListener\AddGrupoFieldSubscriber;
use Buseta\TallerBundle\Form\EventListener\AddSubgrupoFieldSubscriber;
use Buseta\TallerBundle\Form\EventListener\AddTareaMantenimientoFieldSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TareaAdicionalType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $objeto = $builder->getFormFactory();

        $grupos = new AddGrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($grupos);

        $subgrupos = new AddSubgrupoFieldSubscriber($objeto);
        $builder->addEventSubscriber($subgrupos);

        $tareamantenimiento = new AddTareaMantenimientoFieldSubscriber($objeto);
        $builder->addEventSubscriber($tareamantenimiento);

        $builder
            ->add('descripcion', 'textarea', array(
                'required' => true,
                'label'  => 'Observación de tarea',
                'attr'   => array(
                    'class' => 'form-control',
                    'style' => 'height: 120px',
                ),
            ))
            ->add('fechaEstimada', 'date', array(
                'widget' => 'single_text',
                'format'  => 'dd/MM/yyyy',
                'required' => false,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('horaInicio', 'text', array(
                'required' => false,
                'label'  => 'Hora inicio',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('horaFinal', 'text', array(
                'label'  => 'Hora final',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('horasLaboradas', 'hidden', array(
                'required' => false,
                'mapped' => false,
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('garantiaTarea', 'integer', array(
                'required' => false,
                'read_only' => true,
                'label' => 'Garantía tarea',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\TallerBundle\Entity\TareaAdicional',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_tallerbundle_tarea_adicional';
    }
}
