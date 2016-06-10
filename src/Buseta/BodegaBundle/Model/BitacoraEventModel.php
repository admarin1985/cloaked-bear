<?php

namespace Buseta\BodegaBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class BitacoraEventModel
 *
 * @package Buseta\BodegaBundle\Event
 */
class BitacoraEventModel
{
    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     */
    private $warehouse;

    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     */
    private $fromWarehouse;

    /**
     * @var \Buseta\BodegaBundle\Entity\Producto
     *
     * @Assert\NotNull()
     */
    private $product;

    /**
     * @var \DateTime
     *
     * @Assert\DateTime()
     * @Assert\NotNull()
     */
    private $movementDate;

    /**
     * @var integer
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $movementQty;

    /**
     * @var integer
     */
    private $quantityOrder;

    /**
     * @var float
     */
    private $precioUnitario;

    /**
     * @var string
     */
    private $movementType;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @var \Buseta\BodegaBundle\Entity\BitacoraAlmacen
     */
    private $bitacoraLine;

    /**
     * @var mixed
     */
    private $referencedObject;

    /**
     * @var string
     */
    private $error;


    /**
     * @return \Buseta\BodegaBundle\Entity\Bodega
     */
    public function getWarehouse()
    {
        return $this->warehouse;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Bodega $warehouse
     */
    public function setWarehouse($warehouse)
    {
        $this->warehouse = $warehouse;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\Bodega
     */
    public function getFromWarehouse()
    {
        return $this->fromWarehouse;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Bodega $fromWarehouse
     */
    public function setFromWarehouse($fromWarehouse)
    {
        $this->fromWarehouse = $fromWarehouse;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\Producto
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Producto $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return \DateTime
     */
    public function getMovementDate()
    {
        return $this->movementDate;
    }

    /**
     * @param \DateTime $movementDate
     */
    public function setMovementDate($movementDate)
    {
        $this->movementDate = $movementDate;
    }

    /**
     * @return int
     */
    public function getMovementQty()
    {
        return $this->movementQty;
    }

    /**
     * @param int $movementQty
     */
    public function setMovementQty($movementQty)
    {
        $this->movementQty = $movementQty;
    }

    /**
     * @return float
     */
    public function getPrecioUnitario()
    {
        return $this->precioUnitario;
    }

    /**
     * @param float $precioUnitario
     */
    public function setPrecioUnitario($precioUnitario)
    {
        $this->precioUnitario = $precioUnitario;
    }

    /**
     * @return int
     */
    public function getQuantityOrder()
    {
        return $this->quantityOrder;
    }

    /**
     * @param int $quantityOrder
     */
    public function setQuantityOrder($quantityOrder)
    {
        $this->quantityOrder = $quantityOrder;
    }

    /**
     * @return string
     */
    public function getMovementType()
    {
        return $this->movementType;
    }

    /**
     * @param string $movementType
     */
    public function setMovementType($movementType)
    {
        $this->movementType = $movementType;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\BitacoraAlmacen
     */
    public function getBitacoraLine()
    {
        return $this->bitacoraLine;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\BitacoraAlmacen $bitacoraLine
     */
    public function setBitacoraLine($bitacoraLine)
    {
        $this->bitacoraLine = $bitacoraLine;
    }

    /**
     * @return mixed
     */
    public function getReferencedObject()
    {
        return $this->referencedObject;
    }

    /**
     * @param mixed $referencedObject
     */
    public function setReferencedObject($referencedObject)
    {
        $this->referencedObject = $referencedObject;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }

    /**
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param callable $callback
     */
    public function setCallback($callback)
    {
        $this->callback = $callback;
    }
}
