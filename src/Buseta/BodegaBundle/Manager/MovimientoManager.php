<?php

namespace Buseta\BodegaBundle\Manager;

use Buseta\BodegaBundle\Entity\Albaran;
use Buseta\BodegaBundle\Exceptions\NotValidStateException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\HttpFoundation\Session\Session;
use Buseta\BodegaBundle\Entity\MovimientosProductos;
use Buseta\BodegaBundle\Entity\InventarioFisicoLinea;
use Buseta\BodegaBundle\Event\FilterBitacoraEvent;
use Buseta\BodegaBundle\Event\BitacoraEvents;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Buseta\BodegaBundle\Exceptions\NotFoundElementException;



/**
 * Class AlbaranManager
 * @package Buseta\BodegaBundle\Manager
 */
class MovimientoManager
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $em;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private $event_dispacher;


    /**
     * @param ObjectManager            $em
     * @param Logger                   $logger
     * @param EventDispatcherInterface $event_dispacher
     */
    function __construct(
        ObjectManager $em,
        Logger $logger,
        EventDispatcherInterface $event_dispacher
    ) {
        $this->em = $em;
        $this->logger = $logger;
        $this->event_dispacher = $event_dispacher;
    }

    /**
     * Completar Movimiento
     *
     * @param integer $id
     * @return bool
     */
    public function completar($id)
    {
        try {
            /** @var \Buseta\BodegaBundle\Entity\Movimiento $movimiento */
            /** @var \Buseta\BodegaBundle\Entity\MovimientosProductos $linea */

            $movimiento = $this->em->getRepository('BusetaBodegaBundle:Movimiento')->find($id);
            if (!$movimiento) {
                throw new NotFoundElementException('Unable to find Movimiento entity.');
            }

            //entonces mando a crear los movimientos en la bitacora, producto a producto, a traves de eventos
            foreach ($movimiento->getMovimientosProductos() as $linea) {
                /** @var \Buseta\BodegaBundle\Entity\SalidaBodegaProducto $linea */
                $event = new FilterBitacoraEvent($linea);
                $this->event_dispacher->dispatch(BitacoraEvents::MOVEMENT_FROM /*M-*/, $event);
                $result = $event->getReturnValue();
                if ($result !== true ) {
                    //borramos los cambios en el entity manager
                    $this->em->clear();

                    return $error = $result;
                }

                $event = new FilterBitacoraEvent($linea);
                $this->event_dispacher->dispatch(BitacoraEvents::MOVEMENT_TO /*M+*/, $event);
                $result = $event->getReturnValue();
                if ($result !== true ) {
                    //borramos los cambios en el entity manager
                    $this->em->clear();

                    return $error = $result;
                }
            }

            //finalmentele damos flush a todo para guardar en la Base de Datos
            //tanto en la bitacora almacen como en la bitacora de seriales
            //es el unico flush que se hace.
            $this->em->flush();

            return true;
        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al completar el movimiento : %s', $e->getMessage()));

            return $error = 'Ha ocurrido un error al completar el movimiento entre almacenes';
        }
    }
}
