<?php
/**
 * Created by PhpStorm.
 * User: julio
 * Date: 3/03/15
 * Time: 20:38
 */

namespace Buseta\TallerBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reporte
 *
 */
class Reporte
{
    /**
     * @var integer
     *
     */
    private $id;

    /**
     * @var string
     *
     */
    private $numero;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @Assert\NotNull
     */
    private $autobus;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     */
    private $observaciones;

    /**
     *
     * @Assert\NotNull
     */
    private $medioReporte;

    /**
     * @var \Buseta\BodegaBundle\Entity\Tercero
     *
     */
    private $reporta;

    /**
     */
    private $esUsuario;

    /**
     * @var string
     *
     */
    private $nombrePersona;

    /**
     * @var string
     *
     */
    private $emailPersona;

    /**
     * @var string
     *
     */
    private $telefonoPersona;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->observaciones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAutobus()
    {
        return $this->autobus;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $autobus
     */
    public function setAutobus($autobus)
    {
        $this->autobus = $autobus;
    }

    /**
     * @return string
     */
    public function getEmailPersona()
    {
        return $this->emailPersona;
    }

    /**
     * @param string $emailPersona
     */
    public function setEmailPersona($emailPersona)
    {
        $this->emailPersona = $emailPersona;
    }

    /**
     * @return mixed
     */
    public function getEsUsuario()
    {
        return $this->esUsuario;
    }

    /**
     * @param mixed $esUsuario
     */
    public function setEsUsuario($esUsuario)
    {
        $this->esUsuario = $esUsuario;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMedioReporte()
    {
        return $this->medioReporte;
    }

    /**
     * @param mixed $medioReporte
     */
    public function setMedioReporte($medioReporte)
    {
        $this->medioReporte = $medioReporte;
    }

    /**
     * @return string
     */
    public function getNombrePersona()
    {
        return $this->nombrePersona;
    }

    /**
     * @param string $nombrePersona
     */
    public function setNombrePersona($nombrePersona)
    {
        $this->nombrePersona = $nombrePersona;
    }

    /**
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $observaciones
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    /**
     * @return \Buseta\BodegaBundle\Entity\Tercero
     */
    public function getReporta()
    {
        return $this->reporta;
    }

    /**
     * @param \Buseta\BodegaBundle\Entity\Tercero $reporta
     */
    public function setReporta($reporta)
    {
        $this->reporta = $reporta;
    }

    /**
     * @return string
     */
    public function getTelefonoPersona()
    {
        return $this->telefonoPersona;
    }

    /**
     * @param string $telefonoPersona
     */
    public function setTelefonoPersona($telefonoPersona)
    {
        $this->telefonoPersona = $telefonoPersona;
    }
}