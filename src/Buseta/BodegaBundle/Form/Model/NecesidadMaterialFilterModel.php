<?php

namespace Buseta\BodegaBundle\Form\Model;

use Buseta\BodegaBundle\Entity\NecesidadMaterial;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * NecesidadMaterial Model
 *
 */
class NecesidadMaterialFilterModel
{
    /**
     * @var string
     */
    private $numero_documento;

    /**
     * @var string
     */
    private $estado_documento;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     */
    private $tercero;

    /**
     * @var \Buseta\BodegaBundle\Entity\Bodega
     */
    private $almacen;

    /**
     * @var \Buseta\NomencladorBundle\Entity\Moneda
     */
    private $moneda;

    /**
     * @var \Buseta\NomencladorBundle\Entity\FormaPago
     */
    private $forma_pago;

    /**
     * @var \Buseta\TallerBundle\Entity\CondicionesPago
     */
    private $condiciones_pago;

    /**
     * @var float
     */
    private $importe_total_lineas;

    /**
     * @var float
     */
    private $importe_total;

    /**
     * @return \Buseta\BodegaBundle\Entity\Bodega
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }

    /**
     * @return string
     */
    public function getEstadoDocumento()
    {
        return $this->estado_documento;
    }

    /**
     * @param string $estado_documento
     */
    public function setEstadoDocumento($estado_documento)
    {
        $this->estado_documento = $estado_documento;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Bodega $almacen
     */
    public function setAlmacen($almacen)
    {
        $this->almacen = $almacen;
    }

    /**
     * @return \Buseta\TallerBundle\Entity\CondicionesPago
     */
    public function getCondicionesPago()
    {
        return $this->condiciones_pago;
    }

    /**
     * @param \Buseta\TallerBundle\Entity\CondicionesPago $condiciones_pago
     */
    public function setCondicionesPago($condiciones_pago)
    {
        $this->condiciones_pago = $condiciones_pago;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\FormaPago
     */
    public function getFormaPago()
    {
        return $this->forma_pago;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\FormaPago $forma_pago
     */
    public function setFormaPago($forma_pago)
    {
        $this->forma_pago = $forma_pago;
    }

    /**
     * @return float
     */
    public function getImporteTotal()
    {
        return $this->importe_total;
    }

    /**
     * @param float $importe_total
     */
    public function setImporteTotal($importe_total)
    {
        $this->importe_total = $importe_total;
    }

    /**
     * @return float
     */
    public function getImporteTotalLineas()
    {
        return $this->importe_total_lineas;
    }

    /**
     * @param float $importe_total_lineas
     */
    public function setImporteTotalLineas($importe_total_lineas)
    {
        $this->importe_total_lineas = $importe_total_lineas;
    }

    /**
     * @return \Buseta\NomencladorBundle\Entity\Moneda
     */
    public function getMoneda()
    {
        return $this->moneda;
    }

    /**
     * @param \Buseta\NomencladorBundle\Entity\Moneda $moneda
     */
    public function setMoneda($moneda)
    {
        $this->moneda = $moneda;
    }

    /**
     * @return string
     */
    public function getNumeroDocumento()
    {
        return $this->numero_documento;
    }

    /**
     * @param string $numero_documento
     */
    public function setNumeroDocumento($numero_documento)
    {
        $this->numero_documento = $numero_documento;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\Tercero
     */
    public function getTercero()
    {
        return $this->tercero;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Tercero $tercero
     */
    public function setTercero($tercero)
    {
        $this->tercero = $tercero;
    }
}
