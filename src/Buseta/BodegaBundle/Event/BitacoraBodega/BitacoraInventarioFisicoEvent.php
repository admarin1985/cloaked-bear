<?php

namespace Buseta\BodegaBundle\Event\BitacoraBodega;

use Buseta\BodegaBundle\BusetaBodegaMovementTypes;
use Buseta\BodegaBundle\Entity\BitacoraAlmacen;
use Buseta\BodegaBundle\Entity\InventarioFisico;
use Buseta\BodegaBundle\Entity\InventarioFisicoLinea;
use Buseta\BodegaBundle\Model\BitacoraEventModel;

/**
 * Class BitacoraInventarioFisicoEvent
 *
 * @package Buseta\BodegaBundle\Event\BitacoraBodega
 */
class BitacoraInventarioFisicoEvent extends AbstractBitacoraEvent
{
    /**
     * @var InventarioFisico
     */
    private $inventarioFisico;


    /**
     * BitacoraInventarioFisicoEvent constructor.
     *
     * @param InventarioFisico  $inventarioFisico
     * @param boolean           $flush
     */
    public function __construct(InventarioFisico $inventarioFisico = null)
    {
        parent::__construct();

        if ($inventarioFisico !== null && $inventarioFisico->getInventarioFisicoLineas()->count() > 0) {
            $this->inventarioFisico = $inventarioFisico;
            foreach ($inventarioFisico->getInventarioFisicoLineas() as $inventarioFisicoLinea) {
                $movementQty = $inventarioFisicoLinea->getCantidadReal() - $inventarioFisicoLinea->getCantidadTeorica();
                if ($movementQty == 0) {
                    continue;
                }
                /** @var InventarioFisicoLinea $inventarioFisicoLinea */
                $bitacoraEvent = new BitacoraEventModel();
                $bitacoraEvent->setProduct($inventarioFisicoLinea->getProducto());
                $bitacoraEvent->setWarehouse($inventarioFisico->getAlmacen());
                $bitacoraEvent->setMovementQty(abs($movementQty));
                $bitacoraEvent->setMovementDate(new \DateTime());
                $bitacoraEvent->setMovementType(
                    $movementQty > 0 ? BusetaBodegaMovementTypes::INVENTORY_IN : BusetaBodegaMovementTypes::INVENTORY_OUT);
                $bitacoraEvent->setReferencedObject($inventarioFisicoLinea);
                $bitacoraEvent->setCallback(function (BitacoraAlmacen $bitacoraAlmacen) use ($inventarioFisicoLinea) {
                    $bitacoraAlmacen->setInventarioLinea($inventarioFisicoLinea);
                });
                $this->bitacoraEvents->add($bitacoraEvent);
            }
        }
    }
}
