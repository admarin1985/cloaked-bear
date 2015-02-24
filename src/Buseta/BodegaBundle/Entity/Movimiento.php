<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Movimiento
 *
 * @ORM\Table(name="d_movimiento")
 * @ORM\Entity
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\MovimientosProductos", mappedBy="movimiento", cascade={"all"})
     */
    private $movimientos_productos;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto", inversedBy="movimientos")
     */
    private $producto;

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
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;


    function __construct()
    {
        $this->created = new \DateTime();
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Movimiento
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
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

    public function __toString()
    {
        return $this->descripcion;
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
}