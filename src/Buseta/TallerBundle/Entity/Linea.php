<?php

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Linea
 *
 * @ORM\Table(name="d_linea")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\LineaRepository")
 */
class Linea
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
     * @var string
     *
     * @ORM\Column(name="numero", type="string", nullable=false)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", nullable=false)
     */
    private $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="condicion", type="string", nullable=false)
     */
    private $condicion;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Grupo")
     */
    private $grupos;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Subgrupo")
     */
    private $subgrupos;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Producto", inversedBy="lineas")
     */
    private $productos;

    /**
     * @var float
     *
     * @ORM\Column(name="precio_producto", type="decimal", scale=2)
     */
    private $precio_producto;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\TallerBundle\Entity\Impuesto", inversedBy="lineas")
     */
    private $impuesto;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\TallerBundle\Entity\Compra", inversedBy="lineas")
     */
    private $compra;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad_pedido", type="integer")
     * @Assert\Type("integer")
     */
    private $cantidad_pedido;

    /**
     * @var float
     *
     * @ORM\Column(name="monto", type="decimal", scale=2)
     */
    private $monto;

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
     * Set numero
     *
     * @param string $numero
     * @return Linea
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    
        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Linea
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    
        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set cantidad_pedido
     *
     * @param integer $cantidadPedido
     * @return Linea
     */
    public function setCantidadPedido($cantidadPedido)
    {
        $this->cantidad_pedido = $cantidadPedido;
    
        return $this;
    }

    /**
     * Get cantidad_pedido
     *
     * @return integer 
     */
    public function getCantidadPedido()
    {
        return $this->cantidad_pedido;
    }

    /**
     * Set monto
     *
     * @param float $monto
     * @return Linea
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;
    
        return $this;
    }

    /**
     * Get monto
     *
     * @return float 
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set productos
     *
     * @param \Buseta\BodegaBundle\Entity\Producto $productos
     * @return Linea
     */
    public function setProductos(\Buseta\BodegaBundle\Entity\Producto $productos = null)
    {
        $this->productos = $productos;
    
        return $this;
    }

    /**
     * Get productos
     *
     * @return \Buseta\BodegaBundle\Entity\Producto 
     */
    public function getProductos()
    {
        return $this->productos;
    }

    /**
     * Set impuesto
     *
     * @param \Buseta\TallerBundle\Entity\Impuesto $impuesto
     * @return Linea
     */
    public function setImpuesto(\Buseta\TallerBundle\Entity\Impuesto $impuesto = null)
    {
        $this->impuesto = $impuesto;
    
        return $this;
    }

    /**
     * Get impuesto
     *
     * @return \Buseta\TallerBundle\Entity\Impuesto 
     */
    public function getImpuesto()
    {
        return $this->impuesto;
    }

    /**
     * Set compra
     *
     * @param \Buseta\TallerBundle\Entity\Compra $compra
     * @return Linea
     */
    public function setCompra(\Buseta\TallerBundle\Entity\Compra $compra = null)
    {
        $this->compra = $compra;
    
        return $this;
    }

    /**
     * Get compra
     *
     * @return \Buseta\TallerBundle\Entity\Compra 
     */
    public function getCompra()
    {
        return $this->compra;
    }

    /**
     * Set condicion
     *
     * @param string $condicion
     * @return Linea
     */
    public function setCondicion($condicion)
    {
        $this->condicion = $condicion;
    
        return $this;
    }

    /**
     * Get condicion
     *
     * @return string 
     */
    public function getCondicion()
    {
        return $this->condicion;
    }

    /**
     * Set grupos
     *
     * @param \Buseta\NomencladorBundle\Entity\Grupo $grupos
     * @return Linea
     */
    public function setGrupos(\Buseta\NomencladorBundle\Entity\Grupo $grupos = null)
    {
        $this->grupos = $grupos;
    
        return $this;
    }

    /**
     * Get grupos
     *
     * @return \Buseta\NomencladorBundle\Entity\Grupo 
     */
    public function getGrupos()
    {
        return $this->grupos;
    }

    /**
     * Set subgrupos
     *
     * @param \Buseta\NomencladorBundle\Entity\Subgrupo $subgrupos
     * @return Linea
     */
    public function setSubgrupos(\Buseta\NomencladorBundle\Entity\Subgrupo $subgrupos = null)
    {
        $this->subgrupos = $subgrupos;
    
        return $this;
    }

    /**
     * Get subgrupos
     *
     * @return \Buseta\NomencladorBundle\Entity\Subgrupo 
     */
    public function getSubgrupos()
    {
        return $this->subgrupos;
    }

    /**
     * Set precio_producto
     *
     * @param float $precioProducto
     * @return Linea
     */
    public function setPrecioProducto($precioProducto)
    {
        $this->precio_producto = $precioProducto;
    
        return $this;
    }

    /**
     * Get precio_producto
     *
     * @return float 
     */
    public function getPrecioProducto()
    {
        return $this->precio_producto;
    }
}