<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Movimiento
 *
 * @ORM\Table(name="d_movimiento")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\MovimientoRepository")
 */
class Movimiento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega")
     */
    private $almacenOrigen;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega")
     */
    private $almacenDestino;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto", inversedBy="movimientos")
     */
    private $producto;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidadMovida", type="integer")
     */
    private $cantidadMovida;

    /**
     * @var date
     *
     * @ORM\Column(name="fechaMovimiento", type="date")
     */
    private $fechaMovimiento;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\MovimientosProductos", mappedBy="movimiento", cascade={"all"})
     */
    private $movimientos_productos;

    /**
     * @var string
     *
     * @ORM\Column(name="movidoBy", type="string", nullable=true)
     */
    private $movidoBy;

    /**
     * @var date
     *
     * @ORM\Column(name="created", type="date")
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="createdBy", type="string", nullable=true)
     */
    private $createdBy;

    /**
     * @var date
     *
     * @ORM\Column(name="updated", type="date")
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="updatedBy", type="string", nullable=true)
     */
    private $updatedBy;

    function __construct()
    {
        $this->created = new \DateTime();
        $this->updated = new \DateTime();
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cantidadMovida
     *
     * @param integer $cantidadMovida
     * @return Movimiento
     */
    public function setCantidadMovida($cantidadMovida)
    {
        $this->cantidadMovida = $cantidadMovida;
    
        return $this;
    }

    /**
     * Get cantidadMovida
     *
     * @return integer 
     */
    public function getCantidadMovida()
    {
        return $this->cantidadMovida;
    }

    /**
     * Set fechaMovimiento
     *
     * @param \DateTime $fechaMovimiento
     * @return Movimiento
     */
    public function setFechaMovimiento($fechaMovimiento)
    {
        $this->fechaMovimiento = $fechaMovimiento;
    
        return $this;
    }

    /**
     * Get fechaMovimiento
     *
     * @return \DateTime 
     */
    public function getFechaMovimiento()
    {
        return $this->fechaMovimiento;
    }

    /**
     * Set movidoBy
     *
     * @param string $movidoBy
     * @return Movimiento
     */
    public function setMovidoBy($movidoBy)
    {
        $this->movidoBy = $movidoBy;
    
        return $this;
    }

    /**
     * Get movidoBy
     *
     * @return string 
     */
    public function getMovidoBy()
    {
        return $this->movidoBy;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Movimiento
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     * @return Movimiento
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    
        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Movimiento
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set updatedBy
     *
     * @param string $updatedBy
     * @return Movimiento
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;
    
        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return string 
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set almacenOrigen
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $almacenOrigen
     * @return Movimiento
     */
    public function setAlmacenOrigen(\Buseta\BodegaBundle\Entity\Bodega $almacenOrigen = null)
    {
        $this->almacenOrigen = $almacenOrigen;
    
        return $this;
    }

    /**
     * Get almacenOrigen
     *
     * @return \Buseta\BodegaBundle\Entity\Bodega 
     */
    public function getAlmacenOrigen()
    {
        return $this->almacenOrigen;
    }

    /**
     * Set almacenDestino
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $almacenDestino
     * @return Movimiento
     */
    public function setAlmacenDestino(\Buseta\BodegaBundle\Entity\Bodega $almacenDestino = null)
    {
        $this->almacenDestino = $almacenDestino;
    
        return $this;
    }

    /**
     * Get almacenDestino
     *
     * @return \Buseta\BodegaBundle\Entity\Bodega 
     */
    public function getAlmacenDestino()
    {
        return $this->almacenDestino;
    }

    /**
     * Set producto
     *
     * @param \Buseta\BodegaBundle\Entity\Producto $producto
     * @return Movimiento
     */
    public function setProducto(\Buseta\BodegaBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;
    
        return $this;
    }

    /**
     * Get producto
     *
     * @return \Buseta\BodegaBundle\Entity\Producto 
     */
    public function getProducto()
    {
        return $this->producto;
    }

    /**
     * Add movimientos_productos
     *
     * @param \Buseta\BodegaBundle\Entity\MovimientosProductos $movimientosProductos
     * @return Movimiento
     */
    public function addMovimientosProducto(\Buseta\BodegaBundle\Entity\MovimientosProductos $movimientosProductos)
    {
        $movimientosProductos->setMovimiento($this);

        $this->movimientos_productos[] = $movimientosProductos;
    
        return $this;
    }

    /**
     * Remove movimientos_productos
     *
     * @param \Buseta\BodegaBundle\Entity\MovimientosProductos $movimientosProductos
     */
    public function removeMovimientosProducto(\Buseta\BodegaBundle\Entity\MovimientosProductos $movimientosProductos)
    {
        $this->movimientos_productos->removeElement($movimientosProductos);
    }

    /**
     * Get movimientos_productos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMovimientosProductos()
    {
        return $this->movimientos_productos;
    }
}