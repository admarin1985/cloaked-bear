<?php

namespace Buseta\BodegaBundle\Entity;

use Buseta\BodegaBundle\Form\Model\PedidoCompraModel;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * PedidoCompra.
 *
 * @ORM\Table(name="d_pedido_compra")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\PedidoCompraRepository")
 */
class PedidoCompra
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
     * @ORM\Column(name="numero_documento", type="string")
     * @Assert\NotBlank()
     */
    private $numero_documento;

    /**
     * @var string
     *
     * @ORM\Column(name="consecutivo_compra", type="string")
     * @Assert\NotBlank()
     */
    private $consecutivo_compra;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero", inversedBy="pedidoCompra")
     */
    private $tercero;

    /**
     * @var date
     *
     * @ORM\Column(name="fecha_pedido", type="date")
     * @Assert\Date()
     * @Assert\NotBlank()
     */
    private $fecha_pedido;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega", inversedBy="pedidoCompra")
     */
    private $almacen;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Moneda")
     */
    private $moneda;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\FormaPago")
     */
    private $forma_pago;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\TallerBundle\Entity\CondicionesPago")
     */
    private $condiciones_pago;

    /**
     * @var string
     *
     * @ORM\Column(name="estado_documento", type="string")
     * @Assert\NotBlank()
     */
    private $estado_documento = 'BO';

    /**
     * @var float
     *
     * @ORM\Column(name="importe_total_lineas", type="decimal", scale=2, nullable=true)
     */
    private $importe_total_lineas;

    /**
     * @var float
     *
     * @ORM\Column(name="importe_total", type="decimal", scale=2, nullable=true)
     */
    private $importe_total;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\NecesidadMaterial")
     */
    private $necesidadMaterial;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\PedidoCompraLinea", mappedBy="pedidoCompra", cascade={"all"})
     */
    private $pedido_compra_lineas;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\SecurityBundle\Entity\User")
     */
    private $createdby;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\SecurityBundle\Entity\User")
     */
    private $updatedby;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\SecurityBundle\Entity\User")
     */
    private $deletedby;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->pedido_compra_lineas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->importe_total_lineas = 0;
        $this->importe_total = 0;
        $this->updated = new \DateTime();
        $this->deleted = false;
    }

    /**
     * @param PedidoCompraModel $model
     * @return PedidoCompra
     */
    public function setModelData(PedidoCompraModel $model)
    {
        $this->id = $model->getId();
        $this->created = $model->getCreated();
        $this->createdby = $model->getCreatedby();
        $this->consecutivo_compra = $model->getConsecutivoCompra();
        $this->deleted = $model->getDeleted();
        $this->deletedby = $model->getDeletedby();
        $this->updated = $model->getUpdated();
        $this->updatedby = $model->getUpdatedby();
        $this->estado_documento = $model->getEstadoDocumento();
        $this->fecha_pedido = $model->getFechaPedido();
        $this->importe_total = $model->getImporteTotal();
        $this->importe_total_lineas = $model->getImporteTotalLineas();
        $this->numero_documento = $model->getNumeroDocumento();

        if ($model->getTercero()) {
            $this->tercero  = $model->getTercero();
        }
        if ($model->getAlmacen()) {
            $this->almacen  = $model->getAlmacen();
        }
        if ($model->getMoneda()) {
            $this->moneda  = $model->getMoneda();
        }
        if ($model->getFormaPago()) {
            $this->forma_pago  = $model->getFormaPago();
        }
        if ($model->getCondicionesPago()) {
            $this->condiciones_pago  = $model->getCondicionesPago();
        }
        if (!$model->getPedidoCompraLineas()->isEmpty()) {
            $this->pedido_compra_lineas = $model->getPedidoCompraLineas();
        } else {
            $this->pedido_compra_lineas = new ArrayCollection();
        }

        return $this;
    }

    /**
     * Get id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set necesidadMaterial.
     *
     * @param \Buseta\BodegaBundle\Entity\NecesidadMaterial $necesidadMaterial
     *
     * @return PedidoCompra
     */
    public function setNecesidadMaterial(\Buseta\BodegaBundle\Entity\NecesidadMaterial $necesidadMaterial = null)
    {
        $this->necesidadMaterial = $necesidadMaterial;

        return $this;
    }

    /**
     * Get necesidadMaterial.
     *
     * @return \Buseta\BodegaBundle\Entity\NecesidadMaterial
     */
    public function getNecesidadMaterial()
    {
        return $this->necesidadMaterial;
    }

    /**
     * Set numero_documento.
     *
     * @param string $numeroDocumento
     *
     * @return PedidoCompra
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numero_documento = $numeroDocumento;

        return $this;
    }

    /**
     * Get numero_documento.
     *
     * @return string
     */
    public function getNumeroDocumento()
    {
        return $this->numero_documento;
    }

    /**
     * Set consecutivo_compra.
     *
     * @param string $consecutivoCompra
     *
     * @return PedidoCompra
     */
    public function setConsecutivoCompra($consecutivoCompra)
    {
        $this->consecutivo_compra = $consecutivoCompra;

        return $this;
    }

    /**
     * Get consecutivo_compra.
     *
     * @return string
     */
    public function getConsecutivoCompra()
    {
        return $this->consecutivo_compra;
    }

    /**
     * Set fecha_pedido.
     *
     * @param \DateTime $fechaPedido
     *
     * @return PedidoCompra
     */
    public function setFechaPedido($fechaPedido)
    {
        $this->fecha_pedido = $fechaPedido;

        return $this;
    }

    /**
     * Get fecha_pedido.
     *
     * @return \DateTime
     */
    public function getFechaPedido()
    {
        return $this->fecha_pedido;
    }

    /**
     * Set estado_documento.
     *
     * @param string $estadoDocumento
     *
     * @return PedidoCompra
     */
    public function setEstadoDocumento($estadoDocumento)
    {
        $this->estado_documento = $estadoDocumento;

        return $this;
    }

    /**
     * Get estado_documento.
     *
     * @return string
     */
    public function getEstadoDocumento()
    {
        return $this->estado_documento;
    }

    /**
     * Set importe_total_lineas.
     *
     * @param string $importeTotalLineas
     *
     * @return PedidoCompra
     */
    public function setImporteTotalLineas($importeTotalLineas)
    {
        $this->importe_total_lineas = $importeTotalLineas;

        return $this;
    }

    /**
     * Get importe_total_lineas.
     *
     * @return string
     */
    public function getImporteTotalLineas()
    {
        return $this->importe_total_lineas;
    }

    /**
     * Set importe_total.
     *
     * @param string $importeTotal
     *
     * @return PedidoCompra
     */
    public function setImporteTotal($importeTotal)
    {
        $this->importe_total = $importeTotal;

        return $this;
    }

    /**
     * Get importe_total.
     *
     * @return string
     */
    public function getImporteTotal()
    {
        return $this->importe_total;
    }

    /**
     * Set tercero.
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $tercero
     *
     * @return PedidoCompra
     */
    public function setTercero(\Buseta\BodegaBundle\Entity\Tercero $tercero = null)
    {
        $this->tercero = $tercero;

        return $this;
    }

    /**
     * Get tercero.
     *
     * @return \Buseta\BodegaBundle\Entity\Tercero
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * Set almacen.
     *
     * @param \Buseta\BodegaBundle\Entity\Bodega $almacen
     *
     * @return PedidoCompra
     */
    public function setAlmacen(\Buseta\BodegaBundle\Entity\Bodega $almacen = null)
    {
        $this->almacen = $almacen;

        return $this;
    }

    /**
     * Get almacen.
     *
     * @return \Buseta\BodegaBundle\Entity\Bodega
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }

    /**
     * Set forma_pago.
     *
     * @param \Buseta\NomencladorBundle\Entity\FormaPago $formaPago
     *
     * @return PedidoCompra
     */
    public function setFormaPago(\Buseta\NomencladorBundle\Entity\FormaPago $formaPago = null)
    {
        $this->forma_pago = $formaPago;

        return $this;
    }

    /**
     * Get forma_pago.
     *
     * @return \Buseta\NomencladorBundle\Entity\FormaPago
     */
    public function getFormaPago()
    {
        return $this->forma_pago;
    }

    /**
     * Add pedido_compra_lineas.
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas
     *
     * @return PedidoCompra
     */
    public function addPedidoCompraLinea(\Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas)
    {
        $pedidoCompraLineas->setPedidoCompra($this);

        $this->pedido_compra_lineas[] = $pedidoCompraLineas;

        return $this;
    }

    /**
     * Remove pedido_compra_lineas.
     *
     * @param \Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas
     */
    public function removePedidoCompraLinea(\Buseta\BodegaBundle\Entity\PedidoCompraLinea $pedidoCompraLineas)
    {
        $this->pedido_compra_lineas->removeElement($pedidoCompraLineas);
    }

    /**
     * Get pedido_compra_lineas.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPedidoCompraLineas()
    {
        return $this->pedido_compra_lineas;
    }

    /**
     * Set condiciones_pago.
     *
     * @param \Buseta\TallerBundle\Entity\CondicionesPago $condicionesPago
     *
     * @return PedidoCompra
     */
    public function setCondicionesPago(\Buseta\TallerBundle\Entity\CondicionesPago $condicionesPago = null)
    {
        $this->condiciones_pago = $condicionesPago;

        return $this;
    }

    /**
     * Get condiciones_pago.
     *
     * @return \Buseta\TallerBundle\Entity\CondicionesPago
     */
    public function getCondicionesPago()
    {
        return $this->condiciones_pago;
    }

    /**
     * Set moneda.
     *
     * @param \Buseta\NomencladorBundle\Entity\Moneda $moneda
     *
     * @return PedidoCompra
     */
    public function setMoneda(\Buseta\NomencladorBundle\Entity\Moneda $moneda = null)
    {
        $this->moneda = $moneda;

        return $this;
    }

    /**
     * Get moneda.
     *
     * @return \Buseta\NomencladorBundle\Entity\Moneda
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return PedidoCompra
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return PedidoCompra
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set deleted.
     *
     * @param \DateTime $deleted
     *
     * @return PedidoCompra
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted.
     *
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set createdby.
     *
     * @param \Buseta\SecurityBundle\Entity\User $createdby
     *
     * @return PedidoCompra
     */
    public function setCreatedby(\Buseta\SecurityBundle\Entity\User $createdby = null)
    {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * Get createdby.
     *
     * @return \Buseta\SecurityBundle\Entity\User
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * Set updatedby.
     *
     * @param \Buseta\SecurityBundle\Entity\User $updatedby
     *
     * @return PedidoCompra
     */
    public function setUpdatedby(\Buseta\SecurityBundle\Entity\User $updatedby = null)
    {
        $this->updatedby = $updatedby;

        return $this;
    }

    /**
     * Get updatedby.
     *
     * @return \Buseta\SecurityBundle\Entity\User
     */
    public function getUpdatedby()
    {
        return $this->updatedby;
    }

    /**
     * Set deletedby.
     *
     * @param \Buseta\SecurityBundle\Entity\User $deletedby
     *
     * @return PedidoCompra
     */
    public function setDeletedby(\Buseta\SecurityBundle\Entity\User $deletedby = null)
    {
        $this->deletedby = $deletedby;

        return $this;
    }

    /**
     * Get deletedby.
     *
     * @return \Buseta\SecurityBundle\Entity\User
     */
    public function getDeletedby()
    {
        return $this->deletedby;
    }
}
