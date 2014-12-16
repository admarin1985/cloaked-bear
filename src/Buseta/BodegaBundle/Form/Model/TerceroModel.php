<?php

namespace Buseta\BodegaBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Buseta\BodegaBundle\Entity\Tercero;

/**
 * TerceroModel
 */
class TerceroModel
{
    private $id;

    private $compras;

    private $codigo;

    private $nombres;

    private $apellidos;

    private $alias;

    private $direccion;

    private $direccionId;

    private $mecanismoscontacto;

    /**
     * @var boolean
     */
    private $cliente;

    /**
     * @var boolean
     */
    private $institucion;

    /**
     * @var boolean
     */
    private $proveedor;

    /**
     * @var boolean
     */
    private $activo;

    function __construct(Tercero $tercero = null)
    {
        if ($tercero !== null) {
            $this->id = $tercero->getId();
            $this->compras = $tercero->getCompras();
            $this->codigo = $tercero->getCodigo();
            $this->nombres = $tercero->getNombres();
            $this->apellidos = $tercero->getApellidos();
            $this->alias = $tercero->getAlias();

            if ($tercero->getDireccion() !== null) {
                $this->direccion = $tercero->getDireccion()->__toString();
                $this->direccionId = $tercero->getDireccion()->getId();
            }

            $this->mecanismoscontacto = $tercero->getMecanismoscontacto();
            $this->cliente = $tercero->getCliente();
            $this->institucion = $tercero->getInstitucion();
            $this->proveedor = $tercero->getProveedor();
            $this->activo = $tercero->getActivo();
        }
    }


    /**
     * @return boolean
     */
    public function getActivo()
    {
        return $this->activo;
    }

    /**
     * @param boolean $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * @param mixed $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return boolean
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param boolean $cliente
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * @return mixed
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param mixed $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return mixed
     */
    public function getCompras()
    {
        return $this->compras;
    }

    /**
     * @param mixed $compras
     */
    public function setCompras($compras)
    {
        $this->compras = $compras;
    }

    /**
     * @return mixed
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * @param mixed $direccion
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    /**
     * @return mixed
     */
    public function getDireccionId()
    {
        return $this->direccionId;
    }

    /**
     * @param mixed $direccionId
     */
    public function setDireccionId($direccionId)
    {
        $this->direccionId = $direccionId;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return boolean
     */
    public function getInstitucion()
    {
        return $this->institucion;
    }

    /**
     * @param boolean $institucion
     */
    public function setInstitucion($institucion)
    {
        $this->institucion = $institucion;
    }

    /**
     * @return mixed
     */
    public function getMecanismoscontacto()
    {
        return $this->mecanismoscontacto;
    }

    /**
     * @param mixed $mecanismoscontacto
     */
    public function setMecanismoscontacto($mecanismoscontacto)
    {
        $this->mecanismoscontacto = $mecanismoscontacto;
    }

    /**
     * @return mixed
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * @param mixed $nombres
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    /**
     * @return boolean
     */
    public function getProveedor()
    {
        return $this->proveedor;
    }

    /**
     * @param boolean $proveedor
     */
    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;
    }


}