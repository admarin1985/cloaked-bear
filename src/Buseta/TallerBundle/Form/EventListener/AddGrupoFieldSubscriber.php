<?php

namespace Buseta\TallerBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddGrupoFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA    => 'preSetData',
            FormEvents::PRE_SUBMIT      => 'preBind'
        );
    }

    private function addGrupoForm($form, $grupo = null)
    {
        $form->add('grupos', 'entity', array(
            'class'         => 'BusetaNomencladorBundle:Grupo',
            'auto_initialize' => false,
            'empty_value'   => '---Seleccione un grupo---',
            'data' => $grupo,
            'attr' => array(
                'class' => 'form-control',
            ),
            'query_builder' => function (EntityRepository $repository) {
                    $qb = $repository->createQueryBuilder('grupos');

                    return $qb;
                }
        ));
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            $this->addGrupoForm($form);
        } else {
            //$grupo = ($data->city) ? $data->city->getSubgrupo()->getGrupo() : null ;
            $grupo = ($data->getGrupos()) ? $data->getGrupos() : null ;
            $this->addGrupoForm($form, $grupo);
        }
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $grupo = array_key_exists('grupos', $data) ? $data['grupos'] : null;
        $this->addGrupoForm($form, $grupo);
    }
}