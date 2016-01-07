<?php

namespace Buseta\BodegaBundle\EventListener;

use Buseta\BodegaBundle\Entity\AlbaranLinea;
use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Entity\InventarioFisicoLinea;
use Buseta\BodegaBundle\Entity\MovimientosProductos;
use Buseta\BodegaBundle\Entity\SalidaBodegaProducto;
use Buseta\BodegaBundle\Event\BitacoraEvents;
use Buseta\BodegaBundle\Event\FilterBitacoraEvent;
use Buseta\BodegaBundle\Manager\BitacoraAlmacenManager;
use Symfony\Bridge\Monolog\Logger;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Util\ClassUtils;

/**
 * Class BitacoraSubscriber
 * @package Buseta\BodegaBundle\EventListener
 */
class BitacoraSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Buseta\BodegaBundle\Manager\BitacoraAlmacenManager
     */
    private $bitacoraManager;

    /**
     * @var \Symfony\Bridge\Monolog\Logger
     */
    private $logger;


    /**
     * @param \Buseta\BodegaBundle\Manager\BitacoraAlmacenManager $bitacoraManager
     * @param Logger $logger
     */
    function __construct(BitacoraAlmacenManager $bitacoraManager, Logger $logger)
    {
        $this->bitacoraManager = $bitacoraManager;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return array(
            /* C+ */
            BitacoraEvents::CUSTOMER_RETURNS => 'customerReturns',
            /* C- */
            BitacoraEvents::CUSTOMER_SHIPMENT => 'customerShipment',
            /* D+ */
            BitacoraEvents::INTERNAL_CONSUMPTION_POSITIVE => 'internalConsumptionPositive',
            /* D- */
            BitacoraEvents::INTERNAL_CONSUMPTION_NEGATIVE => 'internalConsumptionNegative',
            /* I+ */
            BitacoraEvents::INVENTORY_IN => 'inventoryIn',
            /* I- */
            BitacoraEvents::INVENTORY_OUT => 'inventoryOut',
            /* M+ */
            BitacoraEvents::MOVEMENT_TO => 'movementTo',
            /* M- */
            BitacoraEvents::MOVEMENT_FROM => 'movementFrom',
            /* P+ */
            BitacoraEvents::PRODUCTION_POSITIVE => 'productionPositive',
            /* P- */
            BitacoraEvents::PRODUCTION_NEGATIVE => 'productionNegative',
            /* V+ */
            BitacoraEvents::VENDOR_RECEIPTS => 'vendorReceipts',
            /* V- */
            BitacoraEvents::VENDOR_RETURNS => 'vendorReturns',
            /* W+ */
            BitacoraEvents::WORK_ORDER_POSITIVE => 'workOrderPositive',
            /* W- */
            BitacoraEvents::WORK_ORDER_NEGATIVE => 'workOrderNegative',
        );
    }

    public function customerReturns(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'C+');
    }

    public function customerShipment(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'C-');
    }

    public function internalConsumptionPositive(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'D+');
    }

    public function internalConsumptionNegative(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'D-');
    }

    public function inventoryIn(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'I+');
    }

    public function inventoryOut(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'I-');
    }

    public function movementTo(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'M+');
    }

    public function movementFrom(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'M-');
    }

    public function productionPositive(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'P+');
    }

    public function productionNegative(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'P-');
    }

    public function vendorReceipts(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'V+');
    }

    public function vendorReturns(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'V-');
    }

    public function workOrderPositive(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'W+');
    }

    public function workOrderNegative(FilterBitacoraEvent $event)
    {
        $this->createRegistry($event, 'W-');
    }

    /**
     * @param FilterBitacoraEvent $event
     * @param $movementType
     *
     */
    public function createRegistry(FilterBitacoraEvent $event, $movementType)
    {
        try {

            $entity = $event->getEntityData();

            $nuevabitacora = New BitacoraAlmacen();
            $nuevabitacora->setTipoMovimiento($movementType);

            switch (ClassUtils::getRealClass($entity)) {
                case 'Buseta\BodegaBundle\Entity\AlbaranLinea': {
                    /* @var  $entity \Buseta\BodegaBundle\Entity\AlbaranLinea */
                    $nuevabitacora
                        ->setAlmacen($entity->getAlbaran()->getAlmacen())
                        ->setProducto($entity->getProducto())
                        ->setCantidadMovida($entity->getCantidadMovida())
                        ->setFechaMovimiento($entity->getAlbaran()->getFechaMovimiento())
                        ->setEntradaSalidaLinea($entity);

                    break;
                }

                case 'Buseta\BodegaBundle\Entity\InventarioFisicoLinea': {
                    /* @var  $entity \Buseta\BodegaBundle\Entity\InventarioFisicoLinea */
                    $nuevabitacora
                        ->setAlmacen($entity->getInventarioFisico()->getAlmacen())
                        ->setProducto($entity->getProducto())
                        ->setCantidadMovida($entity->getCantidadReal() - $entity->getCantidadTeorica())
                        ->setFechaMovimiento($entity->getInventarioFisico()->getFecha())
                        ->setInventarioLinea($entity);

                    break;
                }

                case 'Buseta\BodegaBundle\Entity\MovimientosProductos': {
                    /* @var  $entity \Buseta\BodegaBundle\Entity\MovimientosProductos */
                    $nuevabitacora
                        ->setProducto($entity->getProducto())
                        ->setCantidadMovida($entity->getCantidad())
                        ->setFechaMovimiento($entity->getMovimiento()->getFechaMovimiento())
                        ->setMovimientoLinea($entity);

                    if ($movementType === 'M-') {
                        $nuevabitacora->setAlmacen($entity->getMovimiento()->getAlmacenOrigen());
                    } else {
                        $nuevabitacora->setAlmacen($entity->getMovimiento()->getAlmacenDestino());
                    }

                    break;
                }

                case 'Buseta\BodegaBundle\Entity\SalidaBodegaProducto': {
                    /* @var  $entity \Buseta\BodegaBundle\Entity\SalidaBodegaProducto */
                    $nuevabitacora
                        //->setAlmacen($entity->getSalida()->get)
                        ->setProducto($entity->getProducto())
                        ->setCantidadMovida($entity->getCantidad())
                        ->setFechaMovimiento($entity->getSalida()->getFecha())
                        ->setProduccionLinea(sprintf('%s,%d', ClassUtils::getRealClass($entity), $entity->getId()));

                    break;
                }

                case 'Buseta\CombustibleBundle\Entity\ServicioCombustible': {
                    /* @var  $entity \Buseta\CombustibleBundle\Entity\ServicioCombustible */
                    $nuevabitacora
                        ->setAlmacen($entity->getCombustible()->getBodega())
                        ->setProducto($entity->getCombustible()->getProducto())
                        ->setCantidadMovida($entity->getCantidadLibros())
                        ->setFechaMovimiento($entity->getCreated())
                        ->setProduccionLinea(sprintf('%s,%d', ClassUtils::getRealClass($entity), $entity->getId()));

                    break;
                }

                default:
                    break;
            }

            //Si hay error devuelve false, si to ok devuelve true
            //llamada antigua
            //$resultadobooleano =  $this->bitacoraManager->createRegistry( $generadorbitacora  );

            $resultadobooleano = $this->bitacoraManager->createRegistry($nuevabitacora);

            $event->setReturnValue($resultadobooleano);

        } catch (\Exception $e) {
            $this->logger->error(sprintf('Ha ocurrido un error al crear la Bitacora de Almacen: %s', $e->getMessage()));

            $event->setReturnValue(false);
        }

    }
}
