<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bodega.
 *
 * @ORM\Table(name="d_bodega")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\BodegaRepository")
 */
class Bodega
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
     * @ORM\Column(name="codigo", type="string", nullable=true)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string")
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\InventarioFisico", mappedBy="almacen", cascade={"all"})
     */
    private $inventarioFisico;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\PedidoCompra", mappedBy="almacen", cascade={"all"})
     */
    private $pedidoCompra;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\NecesidadMaterial", mappedBy="almacen", cascade={"all"})
     */
    private $necesidadMaterial;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\Albaran", mappedBy="almacen", cascade={"all"})
     */
    private $albaran;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero", inversedBy="bodega")
     */
    private $responsable;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->lineas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->inventarioFisico = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @param string $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Add inventarioFisico.
     *
     * @param \Buseta\BodegaBundle\Entity\InventarioFisico $inventarioFisico
     *
     * @return Bodega
     */
    public function addInventarioFisico(\Buseta\BodegaBundle\Entity\InventarioFisico $inventarioFisico)
    {
        $inventarioFisico->setBodega($this);

        $this->inventarioFisico[] = $inventarioFisico;

        return $this;
    }

    /**
     * Remove inventarioFisico.
     *
     * @param \Buseta\BodegaBundle\Entity\InventarioFisico $inventarioFisico
     */
    public function removeInventarioFisico(\Buseta\BodegaBundle\Entity\InventarioFisico $inventarioFisico)
    {
        $this->inventarioFisico->removeElement($inventarioFisico);
    }

    /**
     * Get inventarioFisico.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInventarioFisico()
    {
        return $this->inventarioFisico;
    }

    public function __toString()
    {
        return $this->getNombre();
    }

    /**
     * Add pedidoCompra.
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra
     *
     * @return Bodega
     */
    public function addPedidoCompra(\Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra)
    {
        $this->pedidoCompra[] = $pedidoCompra;

        return $this;
    }

    /**
     * Remove pedidoCompra.
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra
     */
    public function removePedidoCompra(\Buseta\BodegaBundle\Entity\PedidoCompra $pedidoCompra)
    {
        $this->pedidoCompra->removeElement($pedidoCompra);
    }

    /**
     * Get pedidoCompra.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPedidoCompra()
    {
        return $this->pedidoCompra;
    }

    /**
     * Add necesidadMaterial.
     *
     * @param \Buseta\BodegaBundle\Entity\NecesidadMaterial $necesidadMaterial
     *
     * @return Bodega
     */
    public function addNecesidadMaterial(\Buseta\BodegaBundle\Entity\NecesidadMaterial $necesidadMaterial)
    {
        $this->necesidadMaterial[] = $necesidadMaterial;

        return $this;
    }

    /**
     * Remove necesidadMaterial.
     *
     * @param \Buseta\BodegaBundle\Entity\NecesidadMaterial $necesidadMaterial
     */
    public function removeNecesidadMaterial(\Buseta\BodegaBundle\Entity\NecesidadMaterial $necesidadMaterial)
    {
        $this->necesidadMaterial->removeElement($necesidadMaterial);
    }

    /**
     * Get necesidadMaterial.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNecesidadMaterial()
    {
        return $this->necesidadMaterial;
    }

    /**
     * Add albaran.
     *
     * @param \Buseta\BodegaBundle\Entity\Albaran $albaran
     *
     * @return Bodega
     */
    public function addAlbaran(\Buseta\BodegaBundle\Entity\Albaran $albaran)
    {
        $this->albaran[] = $albaran;

        return $this;
    }

    /**
     * Remove albaran.
     *
     * @param \Buseta\BodegaBundle\Entity\Albaran $albaran
     */
    public function removeAlbaran(\Buseta\BodegaBundle\Entity\Albaran $albaran)
    {
        $this->albaran->removeElement($albaran);
    }

    /**
     * Get albaran.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlbaran()
    {
        return $this->albaran;
    }

    /**
     * Add albaranLinea.
     *
     * @param \Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea
     *
     * @return Bodega
     */
    public function addAlbaranLinea(\Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea)
    {
        $this->albaranLinea[] = $albaranLinea;

        return $this;
    }

    /**
     * Remove albaranLinea.
     *
     * @param \Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea
     */
    public function removeAlbaranLinea(\Buseta\BodegaBundle\Entity\AlbaranLinea $albaranLinea)
    {
        $this->albaranLinea->removeElement($albaranLinea);
    }

    /**
     * Get albaranLinea.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlbaranLinea()
    {
        return $this->albaranLinea;
    }


    /**
     * Set responsable
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $responsable
     * @return Bodega
     */
    public function setResponsable(\Buseta\BodegaBundle\Entity\Tercero $responsable = null)
    {
        $this->responsable = $responsable;
    
        return $this;
    }

    /**
     * Get responsable
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero 
     */
    public function getResponsable()
    {
        return $this->responsable;
    }
}