<?php

namespace Buseta\BodegaBundle\Entity;

use Buseta\BodegaBundle\Form\Model\ProveedorModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Proveedor.
 *
 * @ORM\Table(name="d_proveedor")
 * @ORM\Entity(repositoryClass="")
 */
class Proveedor
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
     * @var \Buseta\BodegaBundle\Entity\Tercero
     *
     * @ORM\OneToOne(targetEntity="Buseta\BodegaBundle\Entity\Tercero", inversedBy="proveedor")
     */
    private $tercero;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Moneda
     *
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Moneda")
     */
    private $moneda;

    /**
     * @var string
     *
     * @ORM\Column(name="creditoLimite", type="decimal", nullable=true)
     */
    private $creditoLimite;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255, nullable=true)
     */
    private $observaciones;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Buseta\NomencladorBundle\Entity\MarcaProveedor", inversedBy="proveedores", cascade={"persist","remove"})
     */
    private $marcas;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->marcas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Establece los valores desde el modelo en la entidad.
     *
     * @param ProveedorModel $model
     *
     * @return $this
     */
    public function setModelData(ProveedorModel $model)
    {
        $this->setMoneda($model->getMoneda());
        $this->setCreditoLimite($model->getCreditoLimite());
        $this->setObservaciones($model->getObservaciones());

        $marcas = $model->getMarcas();
        foreach ($marcas as $marca) {
            $this->addMarca($marca);
        }

        return $this;
    }

    /**
     * Set id.
     *
     * @param integer $id
     *
     * @return Proveedor
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * Set creditoLimite.
     *
     * @param string $creditoLimite
     *
     * @return Proveedor
     */
    public function setCreditoLimite($creditoLimite)
    {
        $this->creditoLimite = $creditoLimite;

        return $this;
    }

    /**
     * Get creditoLimite.
     *
     * @return string
     */
    public function getCreditoLimite()
    {
        return $this->creditoLimite;
    }

    /**
     * Set observaciones.
     *
     * @param string $observaciones
     *
     * @return Proveedor
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones.
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set tercero.
     *
     * @param \Buseta\BodegaBundle\Entity\Tercero $tercero
     *
     * @return Proveedor
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
     * Set moneda.
     *
     * @param \Buseta\NomencladorBundle\Entity\Moneda $moneda
     *
     * @return Proveedor
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
     * Add marcas
     *
     * @param \Buseta\NomencladorBundle\Entity\MarcaProveedor $marcas
     * @return Proveedor
     */
    public function addMarca(\Buseta\NomencladorBundle\Entity\MarcaProveedor $marca)
    {
        $marca->addProveedore($this);
        $this->marcas[] = $marca;

        return $this;
    }

    /**
     * Remove marcas
     *
     * @param \Buseta\NomencladorBundle\Entity\MarcaProveedor $marcas
     */
    public function removeMarca(\Buseta\NomencladorBundle\Entity\MarcaProveedor $marca)
    {

        $this->marcas->removeElement($marca);
    }

    /**
     * Get marcas
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getMarcas()
    {
        return $this->marcas;
    }

    public function __toString()
    {
        return $this->tercero->getNombres();
    }
}
