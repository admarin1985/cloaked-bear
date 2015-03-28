<?php

namespace Buseta\TallerBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrdenTrabajoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero', 'text', array(
                'required' => false,
                'label'  => 'Número',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('requisionMateriales', 'text', array(
                    'required' => false,
                    'label' => 'Número control materiales',
                    'attr'   => array(
                        'class' => 'form-control',
                    ),
                ))
            ->add('realizadaPor', 'entity', array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'required' => false,
                'label'  => 'Responsable',
                'attr'   => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('responsable');
                    $qb->join('responsable.persona', 'persona')
                        ->andWhere($qb->expr()->isNotNull('persona'));

                    return $qb;
                },
            ))
            ->add('diagnosticadoPor', 'entity', array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'required' => false,
                'label'  => 'Diagnosticado por',
                'attr'   => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('responsable');
                    $qb->join('responsable.usuario', 'usuario')
                        ->andWhere($qb->expr()->isNotNull('usuario'));

                    return $qb;
                },
            ))
            ->add('observaciones', 'textarea', array(
                'required' => true,
                'label'  => 'Observaciones',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('prioridad', 'choice', array(
                'label'  => 'Prioridad',
                'choices' => array(
                    'rapida' => 'Rápida',
                    'normal' => 'Normal',
                ),
                'data' => 'normal',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('ayudante', 'entity', array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'required' => false,
                'label'  => 'Ayudante',
                'attr'   => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('ayudante');
                    $qb->join('ayudante.persona', 'persona')
                        ->andWhere($qb->expr()->isNotNull('persona'));

                    return $qb;
                },
            ))
            ->add('autobus', 'entity', array(
                'class' => 'BusetaBusesBundle:Autobus',
                'empty_value' => '---Seleccione---',
                'label' => 'Autobús',
                'required' => true,
                'attr' => array(
                    'class' => 'form-control',
                )
            ))
            ->add('diagnostico','entity',array(
                'class' => 'BusetaTallerBundle:Diagnostico',
                'query_builder' => function (EntityRepository $er) {
                    $qb = $er->createQueryBuilder('d');
                    return $qb->join('d.ordenTrabajo', 'ot')
                        ->where($qb->expr()->isNull('ot'));
                },
                'empty_value' => '---Seleccione---',
                'label' => 'Diagnóstico',
                'required' => false,
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('tareasAdicionales', 'collection', array(
                'type' => new TareaAdicionalType(),
                'label'  => false,
                'required' => true,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ))
            ->add('kilometraje', 'number', array(
                'required' => false,
                'read_only' => true,
                'label' => 'Kilometraje',
                'attr' => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('fechaInicio', 'date', array(
                'required' => false,
                'label'  => 'Fecha inicio',
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('fechaFinal', 'date', array(
                'required' => false,
                'label'  => 'Fecha final',
                'format' => 'dd/MM/yyyy',
                'widget' => 'single_text',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('duracionDias', 'text', array(
                'required' => false,
                'label'  => 'Duración de días',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('duracionHorasLaboradas', 'text', array(
                'required' => false,
                'label'  => 'Duración de horas laboradas',
                'attr'   => array(
                    'class' => 'form-control',
                ),
            ))
            ->add('aprobadoPor', 'entity', array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'required' => false,
                'label'  => 'Aprobado por',
                'attr'   => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('tercero');
                    return $qb->join('tercero.persona', 'persona')
                        ->andWhere($qb->expr()->isNotNull('persona'));
                },
            ))
            ->add('revisadoPor', 'entity', array(
                'class' => 'BusetaBodegaBundle:Tercero',
                'required' => false,
                'label'  => 'Revisado por',
                'attr'   => array(
                    'class' => 'form-control',
                ),
                'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('tercero');
                    $qb->join('tercero.persona', 'persona')
                        ->andWhere($qb->expr()->isNotNull('persona'));

                    return $qb;
                },
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buseta\TallerBundle\Entity\OrdenTrabajo',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'buseta_tallerbundle_ordentrabajo';
    }
}
