<?php

namespace Buseta\BodegaBundle\Entity;

use Buseta\BodegaBundle\Form\Model\NecesidadMaterialModel;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * NecesidadMaterial.
 *
 * @ORM\Table(name="d_necesidad_material")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\NecesidadMaterialRepository")
 */
class NecesidadMaterial
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
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero", inversedBy="necesidadMaterial")
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
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\Bodega", inversedBy="necesidadMaterial")
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\BodegaBundle\Entity\NecesidadMaterialLinea", mappedBy="necesidadMaterial", cascade={"all"})
     */
    private $necesidad_material_lineas;

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
        $this->necesidad_material_lineas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->importe_total_lineas = 0;
        $this->importe_total = 0;
        $this->updated = new \DateTime();
        $this->deleted = false;
    }

    /**
     * @param NecesidadMaterialModel $model
     * @return NecesidadMaterial
     */
    public function setModelData(NecesidadMaterialModel $model)
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
        if (!$model->getNecesidadMaterialLineas()->isEmpty()) {
            $this->necesidad_material_lineas = $model->getNecesidadMaterialLineas();
        } else {
            $this->necesidad_material_lineas = new ArrayCollection();
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
     * Set numero_documento.
     *
     * @param string $numeroDocumento
     *
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
     * Add necesidad_material_lineas.
     *
     * @param \Buseta\BodegaBundle\Entity\NecesidadMaterialLinea $necesidadMaterialLineas
     *
     * @return NecesidadMaterial
     */
    public function addNecesidadMaterialLinea(\Buseta\BodegaBundle\Entity\NecesidadMaterialLinea $necesidadMaterialLineas)
    {
        $necesidadMaterialLineas->setNecesidadMaterial($this);

        $this->necesidad_material_lineas[] = $necesidadMaterialLineas;

        return $this;
    }

    /**
     * Remove necesidad_material_lineas.
     *
     * @param \Buseta\BodegaBundle\Entity\NecesidadMaterialLinea $necesidadMaterialLineas
     */
    public function removeNecesidadMaterialLinea(\Buseta\BodegaBundle\Entity\NecesidadMaterialLinea $necesidadMaterialLineas)
    {
        $this->necesidad_material_lineas->removeElement($necesidadMaterialLineas);
    }

    /**
     * Get necesidad_material_lineas.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNecesidadMaterialLineas()
    {
        return $this->necesidad_material_lineas;
    }

    /**
     * Set condiciones_pago.
     *
     * @param \Buseta\TallerBundle\Entity\CondicionesPago $condicionesPago
     *
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
     * @return NecesidadMaterial
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
