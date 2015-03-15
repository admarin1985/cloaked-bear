<?php

namespace Buseta\BusesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Autobus.
 *
 * @ORM\Table(name="d_autobus")
 * @ORM\Entity(repositoryClass="Buseta\BusesBundle\Entity\Repository\AutobusRepository")
 */
class Autobus
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
     * @ORM\Column(name="imagen_frontal", type="string", nullable=true)
     * @Assert\Image()
     */
    private $imagen_frontal;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen_lateral_d", type="string", nullable=true)
     * @Assert\Image()
     */
    private $imagen_lateral_d;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen_lateral_i", type="string", nullable=true)
     * @Assert\Image()
     */
    private $imagen_lateral_i;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen_trasera", type="string", nullable=true)
     * @Assert\Image()
     */
    private $imagen_trasera;

    /**
     * @ORM\OneToMany(targetEntity="Buseta\BusesBundle\Entity\ArchivoAdjunto", mappedBy="autobuses", cascade={"persist"})
     * @Assert\File()
     */
    private $archivo_adjunto;

    /**
     * @var string
     *
     * @ORM\Column(name="matricula", type="string", length=32)
     */
    private $matricula;

    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=32)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="marca_cajacambio", type="string", nullable=true)
     */
    private $marca_cajacambio;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_cajacambio", type="string", nullable=true)
     */
    private $tipo_cajacambio;

    /**
     * @var string
     *
     * @ORM\Column(name="bateria_1", type="string", nullable=true)
     */
    private $bateria_1;

    /**
     * @var string
     *
     * @ORM\Column(name="bateria_2", type="string", nullable=true)
     */
    private $bateria_2;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_chasis", type="string", length=32)
     */
    private $numero_chasis;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_motor", type="string", length=32)
     */
    private $numero_motor;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\FiltroAceite", mappedBy="autobus", cascade={"all"})
     */
    private $filtro_aceite;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\FiltroAgua", mappedBy="autobus", cascade={"all"})
     */
    private $filtro_agua;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\FiltroDiesel", mappedBy="autobus", cascade={"all"})
     */
    private $filtro_diesel;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\FiltroHidraulico", mappedBy="autobus", cascade={"all"})
     */
    private $filtro_hidraulico;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\FiltroTransmision", mappedBy="autobus", cascade={"all"})
     */
    private $filtro_transmision;

    /**
     * @ORM\OneToOne(targetEntity="Buseta\BusesBundle\Entity\FiltroCaja", mappedBy="autobus", cascade={"all"})
     */
    private $filtro_caja;

    /**
     * @var string
     *
     * @ORM\Column(name="carter_capacidadlitros", type="string", nullable=true)
     */
    private $carter_capacidadlitros;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Marca")
     */
    private $marca;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\AceiteCajaCambios")
     */
    private $aceitecajacambios;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\AceiteHidraulico")
     */
    private $aceitehidraulico;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\AceiteMotor")
     */
    private $aceitemotor;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\AceiteTransmision")
     */
    private $aceitetransmision;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Modelo")
     */
    private $modelo;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Estilo")
     */
    private $estilo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\TallerBundle\Entity\Compra", mappedBy="centro_costo", cascade={"all"})
     */
    private $compras;

    /**
     * @var integer
     *
     * @ORM\Column(name="peso_tara", type="integer")
     * @Assert\Type(type="integer")
     */
    private $peso_tara;

    /**
     * @var integer
     *
     * @ORM\Column(name="peso_bruto", type="integer")
     * @Assert\Type("integer")
     */
    private $peso_bruto;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Color")
     */
    private $color;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_plazas", type="integer")
     * @Assert\Type("integer")
     */
    private $numero_plazas;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\MarcaMotor")
     */
    private $marca_motor;

    /**
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\Combustible")
     */
    private $combustible;

    /**
     * @var integer
     *
     * @ORM\Column(name="anno", type="integer", nullable=true)
     * @Assert\Type("integer")
     */
    private $anno;

    /**
     * @var integer
     *
     * @ORM\Column(name="valor_unidad", type="integer", nullable=true)
     * @Assert\Type("integer")
     */
    private $valor_unidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="capacidad_tanque", type="integer")
     * @Assert\Type("integer")
     */
    private $capacidad_tanque;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_unidad", type="integer", nullable=true)
     * @Assert\Type("integer")
     */
    private $numero_unidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="numero_cilindros", type="integer")
     * @Assert\Type("integer")
     */
    private $numero_cilindros;

    /**
     * @var integer
     *
     * @ORM\Column(name="cilindrada", type="integer")
     * @Assert\Type("integer")
     */
    private $cilindrada;

    /**
     * @var integer
     *
     * @ORM\Column(name="potencia", type="integer")
     * @Assert\Type("integer")
     */
    private $potencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="valido_hasta", type="date")
     * @Assert\Date()
     */
    private $valido_hasta;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_rtv_1", type="string")
     */
    private $fecha_rtv_1;

    /**
     * @var string
     *
     * @ORM\Column(name="fecha_rtv_2", type="string")
     */
    private $fecha_rtv_2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ingreso", type="date")
     * @Assert\Date()
     */
    private $fecha_ingreso;

    /**
     * @var string
     *
     * @ORM\Column(name="rampas", type="string", nullable=true)
     */
    private $rampas;

    /**
     * @var string
     *
     * @ORM\Column(name="barras", type="string", nullable=true)
     */
    private $barras;

    /**
     * @var string
     *
     * @ORM\Column(name="camaras", type="string", nullable=true)
     */
    private $camaras;

    /**
     * @var string
     *
     * @ORM\Column(name="lector_cedulas", type="string", nullable=true)
     */
    private $lector_cedulas;

    /**
     * @var string
     *
     * @ORM\Column(name="publicidad", type="string", nullable=true)
     */
    private $publicidad;

    /**
     * @var string
     *
     * @ORM\Column(name="gps", type="string", nullable=true)
     */
    private $gps;

    /**
     * @var string
     *
     * @ORM\Column(name="wifi", type="string", nullable=true)
     */
    private $wifi;

    /**
     * @var integer
     *
     * @ORM\Column(name="kilometraje", type="integer", columnDefinition="INT( 11 ) NOT NULL DEFAULT '0'")
     * @Assert\Type("integer")
     */
    private $kilometraje;

    /**
     * @ORM\Column(name="activo", type="boolean", nullable=true)
     */
    private $activo;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="horas", type="integer", columnDefinition="INT( 11 ) NOT NULL DEFAULT '0'")
     */
    private $horas;

    
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
     * Set imagen_frontal.
     *
     * @param string $imagenFrontal
     *
     * @return Autobus
     */
    public function setImagenFrontal($imagenFrontal)
    {
        $this->imagen_frontal = $imagenFrontal;

        return $this;
    }

    /**
     * Get imagen_frontal.
     *
     * @return string
     */
    public function getImagenFrontal()
    {
        return $this->imagen_frontal;
    }

    /**
     * Set imagen_lateral_d.
     *
     * @param string $imagenLateralD
     *
     * @return Autobus
     */
    public function setImagenLateralD($imagenLateralD)
    {
        $this->imagen_lateral_d = $imagenLateralD;

        return $this;
    }

    /**
     * Get imagen_lateral_d.
     *
     * @return string
     */
    public function getImagenLateralD()
    {
        return $this->imagen_lateral_d;
    }

    /**
     * Set imagen_lateral_i.
     *
     * @param string $imagenLateralI
     *
     * @return Autobus
     */
    public function setImagenLateralI($imagenLateralI)
    {
        $this->imagen_lateral_i = $imagenLateralI;

        return $this;
    }

    /**
     * Get imagen_lateral_i.
     *
     * @return string
     */
    public function getImagenLateralI()
    {
        return $this->imagen_lateral_i;
    }

    /**
     * Set imagen_trasera.
     *
     * @param string $imagenTrasera
     *
     * @return Autobus
     */
    public function setImagenTrasera($imagenTrasera)
    {
        $this->imagen_trasera = $imagenTrasera;

        return $this;
    }

    /**
     * Get imagen_trasera.
     *
     * @return string
     */
    public function getImagenTrasera()
    {
        return $this->imagen_trasera;
    }

    /**
     * Set matricula.
     *
     * @param string $matricula
     *
     * @return Autobus
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get matricula.
     *
     * @return string
     */
    public function getMatricula()
    {
        return $this->matricula;
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
     * Set marca_cajacambio.
     *
     * @param string $marcaCajacambio
     *
     * @return Autobus
     */
    public function setMarcaCajacambio($marcaCajacambio)
    {
        $this->marca_cajacambio = $marcaCajacambio;

        return $this;
    }

    /**
     * Get marca_cajacambio.
     *
     * @return string
     */
    public function getMarcaCajacambio()
    {
        return $this->marca_cajacambio;
    }

    /**
     * Set tipo_cajacambio.
     *
     * @param string $tipoCajacambio
     *
     * @return Autobus
     */
    public function setTipoCajacambio($tipoCajacambio)
    {
        $this->tipo_cajacambio = $tipoCajacambio;

        return $this;
    }

    /**
     * Get tipo_cajacambio.
     *
     * @return string
     */
    public function getTipoCajacambio()
    {
        return $this->tipo_cajacambio;
    }

    /**
     * Set bateria_1.
     *
     * @param string $bateria1
     *
     * @return Autobus
     */
    public function setBateria1($bateria1)
    {
        $this->bateria_1 = $bateria1;

        return $this;
    }

    /**
     * Get bateria_1.
     *
     * @return string
     */
    public function getBateria1()
    {
        return $this->bateria_1;
    }

    /**
     * Set bateria_2.
     *
     * @param string $bateria2
     *
     * @return Autobus
     */
    public function setBateria2($bateria2)
    {
        $this->bateria_2 = $bateria2;

        return $this;
    }

    /**
     * Get bateria_2.
     *
     * @return string
     */
    public function getBateria2()
    {
        return $this->bateria_2;
    }

    /**
     * Set numero_chasis.
     *
     * @param string $numeroChasis
     *
     * @return Autobus
     */
    public function setNumeroChasis($numeroChasis)
    {
        $this->numero_chasis = $numeroChasis;

        return $this;
    }

    /**
     * Get numero_chasis.
     *
     * @return string
     */
    public function getNumeroChasis()
    {
        return $this->numero_chasis;
    }

    /**
     * Set numero_motor.
     *
     * @param string $numeroMotor
     *
     * @return Autobus
     */
    public function setNumeroMotor($numeroMotor)
    {
        $this->numero_motor = $numeroMotor;

        return $this;
    }

    /**
     * Get numero_motor.
     *
     * @return string
     */
    public function getNumeroMotor()
    {
        return $this->numero_motor;
    }

    /**
     * Set carter_capacidadlitros.
     *
     * @param string $carterCapacidadlitros
     *
     * @return Autobus
     */
    public function setCarterCapacidadlitros($carterCapacidadlitros)
    {
        $this->carter_capacidadlitros = $carterCapacidadlitros;

        return $this;
    }

    /**
     * Get carter_capacidadlitros.
     *
     * @return string
     */
    public function getCarterCapacidadlitros()
    {
        return $this->carter_capacidadlitros;
    }

    /**
     * Set peso_tara.
     *
     * @param integer $pesoTara
     *
     * @return Autobus
     */
    public function setPesoTara($pesoTara)
    {
        $this->peso_tara = $pesoTara;

        return $this;
    }

    /**
     * Get peso_tara.
     *
     * @return integer
     */
    public function getPesoTara()
    {
        return $this->peso_tara;
    }

    /**
     * Set peso_bruto.
     *
     * @param integer $pesoBruto
     *
     * @return Autobus
     */
    public function setPesoBruto($pesoBruto)
    {
        $this->peso_bruto = $pesoBruto;

        return $this;
    }

    /**
     * Get peso_bruto.
     *
     * @return integer
     */
    public function getPesoBruto()
    {
        return $this->peso_bruto;
    }

    /**
     * Set numero_plazas.
     *
     * @param integer $numeroPlazas
     *
     * @return Autobus
     */
    public function setNumeroPlazas($numeroPlazas)
    {
        $this->numero_plazas = $numeroPlazas;

        return $this;
    }

    /**
     * Get numero_plazas.
     *
     * @return integer
     */
    public function getNumeroPlazas()
    {
        return $this->numero_plazas;
    }

    /**
     * Set anno.
     *
     * @param integer $anno
     *
     * @return Autobus
     */
    public function setAnno($anno)
    {
        $this->anno = $anno;

        return $this;
    }

    /**
     * Get anno.
     *
     * @return integer
     */
    public function getAnno()
    {
        return $this->anno;
    }

    /**
     * Set valor_unidad.
     *
     * @param integer $valorUnidad
     *
     * @return Autobus
     */
    public function setValorUnidad($valorUnidad)
    {
        $this->valor_unidad = $valorUnidad;

        return $this;
    }

    /**
     * Get valor_unidad.
     *
     * @return integer
     */
    public function getValorUnidad()
    {
        return $this->valor_unidad;
    }

    /**
     * Set capacidad_tanque.
     *
     * @param integer $capacidadTanque
     *
     * @return Autobus
     */
    public function setCapacidadTanque($capacidadTanque)
    {
        $this->capacidad_tanque = $capacidadTanque;

        return $this;
    }

    /**
     * Get capacidad_tanque.
     *
     * @return integer
     */
    public function getCapacidadTanque()
    {
        return $this->capacidad_tanque;
    }

    /**
     * Set numero_unidad.
     *
     * @param integer $numeroUnidad
     *
     * @return Autobus
     */
    public function setNumeroUnidad($numeroUnidad)
    {
        $this->numero_unidad = $numeroUnidad;

        return $this;
    }

    /**
     * Get numero_unidad.
     *
     * @return integer
     */
    public function getNumeroUnidad()
    {
        return $this->numero_unidad;
    }

    /**
     * Set numero_cilindros.
     *
     * @param integer $numeroCilindros
     *
     * @return Autobus
     */
    public function setNumeroCilindros($numeroCilindros)
    {
        $this->numero_cilindros = $numeroCilindros;

        return $this;
    }

    /**
     * Get numero_cilindros.
     *
     * @return integer
     */
    public function getNumeroCilindros()
    {
        return $this->numero_cilindros;
    }

    /**
     * Set cilindrada.
     *
     * @param integer $cilindrada
     *
     * @return Autobus
     */
    public function setCilindrada($cilindrada)
    {
        $this->cilindrada = $cilindrada;

        return $this;
    }

    /**
     * Get cilindrada.
     *
     * @return integer
     */
    public function getCilindrada()
    {
        return $this->cilindrada;
    }

    /**
     * Set potencia.
     *
     * @param integer $potencia
     *
     * @return Autobus
     */
    public function setPotencia($potencia)
    {
        $this->potencia = $potencia;

        return $this;
    }

    /**
     * Get potencia.
     *
     * @return integer
     */
    public function getPotencia()
    {
        return $this->potencia;
    }

    /**
     * Set valido_hasta.
     *
     * @param \DateTime $validoHasta
     *
     * @return Autobus
     */
    public function setValidoHasta($validoHasta)
    {
        $this->valido_hasta = $validoHasta;

        return $this;
    }

    /**
     * Get valido_hasta.
     *
     * @return \DateTime
     */
    public function getValidoHasta()
    {
        return $this->valido_hasta;
    }

    /**
     * Set fecha_rtv_1.
     *
     * @param string $fechaRtv1
     *
     * @return Autobus
     */
    public function setFechaRtv1($fechaRtv1)
    {
        $this->fecha_rtv_1 = $fechaRtv1;

        return $this;
    }

    /**
     * Get fecha_rtv_1.
     *
     * @return string
     */
    public function getFechaRtv1()
    {
        return $this->fecha_rtv_1;
    }

    /**
     * Set fecha_rtv_2.
     *
     * @param string $fechaRtv2
     *
     * @return Autobus
     */
    public function setFechaRtv2($fechaRtv2)
    {
        $this->fecha_rtv_2 = $fechaRtv2;

        return $this;
    }

    /**
     * Get fecha_rtv_2.
     *
     * @return string
     */
    public function getFechaRtv2()
    {
        return $this->fecha_rtv_2;
    }

    /**
     * Set fecha_ingreso.
     *
     * @param \DateTime $fechaIngreso
     *
     * @return Autobus
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fecha_ingreso = $fechaIngreso;

        return $this;
    }

    /**
     * Get fecha_ingreso.
     *
     * @return \DateTime
     */
    public function getFechaIngreso()
    {
        return $this->fecha_ingreso;
    }

    /**
     * Set rampas.
     *
     * @param string $rampas
     *
     * @return Autobus
     */
    public function setRampas($rampas)
    {
        $this->rampas = $rampas;

        return $this;
    }

    /**
     * Get rampas.
     *
     * @return string
     */
    public function getRampas()
    {
        return $this->rampas;
    }

    /**
     * Set barras.
     *
     * @param string $barras
     *
     * @return Autobus
     */
    public function setBarras($barras)
    {
        $this->barras = $barras;

        return $this;
    }

    /**
     * Get barras.
     *
     * @return string
     */
    public function getBarras()
    {
        return $this->barras;
    }

    /**
     * Set camaras.
     *
     * @param string $camaras
     *
     * @return Autobus
     */
    public function setCamaras($camaras)
    {
        $this->camaras = $camaras;

        return $this;
    }

    /**
     * Get camaras.
     *
     * @return string
     */
    public function getCamaras()
    {
        return $this->camaras;
    }

    /**
     * Set lector_cedulas.
     *
     * @param string $lectorCedulas
     *
     * @return Autobus
     */
    public function setLectorCedulas($lectorCedulas)
    {
        $this->lector_cedulas = $lectorCedulas;

        return $this;
    }

    /**
     * Get lector_cedulas.
     *
     * @return string
     */
    public function getLectorCedulas()
    {
        return $this->lector_cedulas;
    }

    /**
     * Set publicidad.
     *
     * @param string $publicidad
     *
     * @return Autobus
     */
    public function setPublicidad($publicidad)
    {
        $this->publicidad = $publicidad;

        return $this;
    }

    /**
     * Get publicidad.
     *
     * @return string
     */
    public function getPublicidad()
    {
        return $this->publicidad;
    }

    /**
     * Set gps.
     *
     * @param string $gps
     *
     * @return Autobus
     */
    public function setGps($gps)
    {
        $this->gps = $gps;

        return $this;
    }

    /**
     * Get gps.
     *
     * @return string
     */
    public function getGps()
    {
        return $this->gps;
    }

    /**
     * Set wifi.
     *
     * @param string $wifi
     *
     * @return Autobus
     */
    public function setWifi($wifi)
    {
        $this->wifi = $wifi;

        return $this;
    }

    /**
     * Get wifi.
     *
     * @return string
     */
    public function getWifi()
    {
        return $this->wifi;
    }

    /**
     * Set filtro_aceite.
     *
     * @param \Buseta\BusesBundle\Entity\FiltroAceite $filtroAceite
     *
     * @return Autobus
     */
    public function setFiltroAceite(\Buseta\BusesBundle\Entity\FiltroAceite $filtroAceite = null)
    {
        $filtroAceite->setAutobus($this);
        $this->filtro_aceite = $filtroAceite;

        return $this;
    }

    /**
     * Get filtro_aceite.
     *
     * @return \Buseta\BusesBundle\Entity\FiltroAceite
     */
    public function getFiltroAceite()
    {
        return $this->filtro_aceite;
    }

    /**
     * Set filtro_agua.
     *
     * @param \Buseta\BusesBundle\Entity\FiltroAgua $filtroAgua
     *
     * @return Autobus
     */
    public function setFiltroAgua(\Buseta\BusesBundle\Entity\FiltroAgua $filtroAgua = null)
    {
        $filtroAgua->setAutobus($this);
        $this->filtro_agua = $filtroAgua;

        return $this;
    }

    /**
     * Get filtro_agua.
     *
     * @return \Buseta\BusesBundle\Entity\FiltroAgua
     */
    public function getFiltroAgua()
    {
        return $this->filtro_agua;
    }

    /**
     * Set filtro_diesel.
     *
     * @param \Buseta\BusesBundle\Entity\FiltroDiesel $filtroDiesel
     *
     * @return Autobus
     */
    public function setFiltroDiesel(\Buseta\BusesBundle\Entity\FiltroDiesel $filtroDiesel = null)
    {
        $filtroDiesel->setAutobus($this);
        $this->filtro_diesel = $filtroDiesel;

        return $this;
    }

    /**
     * Get filtro_diesel.
     *
     * @return \Buseta\BusesBundle\Entity\FiltroDiesel
     */
    public function getFiltroDiesel()
    {
        return $this->filtro_diesel;
    }

    /**
     * Set filtro_hidraulico.
     *
     * @param \Buseta\BusesBundle\Entity\FiltroHidraulico $filtroHidraulico
     *
     * @return Autobus
     */
    public function setFiltroHidraulico(\Buseta\BusesBundle\Entity\FiltroHidraulico $filtroHidraulico = null)
    {
        $filtroHidraulico->setAutobus($this);
        $this->filtro_hidraulico = $filtroHidraulico;

        return $this;
    }

    /**
     * Get filtro_hidraulico.
     *
     * @return \Buseta\BusesBundle\Entity\FiltroHidraulico
     */
    public function getFiltroHidraulico()
    {
        return $this->filtro_hidraulico;
    }

    /**
     * Set filtro_transmision.
     *
     * @param \Buseta\BusesBundle\Entity\FiltroTransmision $filtroTransmision
     *
     * @return Autobus
     */
    public function setFiltroTransmision(\Buseta\BusesBundle\Entity\FiltroTransmision $filtroTransmision = null)
    {
        $filtroTransmision->setAutobus($this);
        $this->filtro_transmision = $filtroTransmision;

        return $this;
    }

    /**
     * Get filtro_transmision.
     *
     * @return \Buseta\BusesBundle\Entity\FiltroTransmision
     */
    public function getFiltroTransmision()
    {
        return $this->filtro_transmision;
    }

    /**
     * Set filtro_caja.
     *
     * @param \Buseta\BusesBundle\Entity\FiltroCaja $filtroCaja
     *
     * @return Autobus
     */
    public function setFiltroCaja(\Buseta\BusesBundle\Entity\FiltroCaja $filtroCaja = null)
    {
        $filtroCaja->setAutobus($this);
        $this->filtro_caja = $filtroCaja;

        return $this;
    }

    /**
     * Get filtro_caja.
     *
     * @return \Buseta\BusesBundle\Entity\FiltroCaja
     */
    public function getFiltroCaja()
    {
        return $this->filtro_caja;
    }

    /**
     * @return mixed
     */
    public function getAceitecajacambios()
    {
        return $this->aceitecajacambios;
    }

    /**
     * @param mixed $aceitecajacambios
     */
    public function setAceitecajacambios($aceitecajacambios)
    {
        $this->aceitecajacambios = $aceitecajacambios;
    }

    /**
     * @return mixed
     */
    public function getAceitehidraulico()
    {
        return $this->aceitehidraulico;
    }

    /**
     * @param mixed $aceitehidraulico
     */
    public function setAceitehidraulico($aceitehidraulico)
    {
        $this->aceitehidraulico = $aceitehidraulico;
    }

    /**
     * @param mixed $archivo_adjunto
     */
    public function setArchivoAdjunto($archivo_adjunto)
    {
        $this->archivo_adjunto = $archivo_adjunto;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->archivo_adjunto = new \Doctrine\Common\Collections\ArrayCollection();
        $this->kilometraje = 0;
        $this->horas = 0;
    }

    /**
     * Add archivo_adjunto.
     *
     * @param \Buseta\BusesBundle\Entity\ArchivoAdjunto $archivoAdjunto
     *
     * @return Autobus
     */
    public function addArchivoAdjunto(\Buseta\BusesBundle\Entity\ArchivoAdjunto $archivoAdjunto)
    {
        $archivoAdjunto->setAutobuses($this);

        $this->archivo_adjunto[] = $archivoAdjunto;

        return $this;
    }

    /**
     * Remove archivo_adjunto.
     *
     * @param \Buseta\BusesBundle\Entity\ArchivoAdjunto $archivoAdjunto
     */
    public function removeArchivoAdjunto(\Buseta\BusesBundle\Entity\ArchivoAdjunto $archivoAdjunto)
    {
        $this->archivo_adjunto->removeElement($archivoAdjunto);
    }

    /**
     * Get archivo_adjunto.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArchivoAdjunto()
    {
        return $this->archivo_adjunto;
    }

    public function __toString()
    {
        return sprintf('%d (%s)', $this->numero, $this->matricula);
    }

    /**
     * Add compras.
     *
     * @param \Buseta\TallerBundle\Entity\Compra $compras
     *
     * @return Autobus
     */
    public function addCompra(\Buseta\TallerBundle\Entity\Compra $compras)
    {
        $compras->setCentroCosto($this);

        $this->compras[] = $compras;

        return $this;
    }

    /**
     * Remove compras.
     *
     * @param \Buseta\TallerBundle\Entity\Compra $compras
     */
    public function removeCompra(\Buseta\TallerBundle\Entity\Compra $compras)
    {
        $this->compras->removeElement($compras);
    }

    /**
     * Get compras.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompras()
    {
        return $this->compras;
    }

    /**
     * @return mixed
     */
    public function getAceitemotor()
    {
        return $this->aceitemotor;
    }

    /**
     * @param mixed $aceitemotor
     */
    public function setAceitemotor($aceitemotor)
    {
        $this->aceitemotor = $aceitemotor;
    }

    /**
     * @return mixed
     */
    public function getAceitetransmision()
    {
        return $this->aceitetransmision;
    }

    /**
     * @param mixed $aceitetransmision
     */
    public function setAceitetransmision($aceitetransmision)
    {
        $this->aceitetransmision = $aceitetransmision;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getCombustible()
    {
        return $this->combustible;
    }

    /**
     * @param mixed $combustible
     */
    public function setCombustible($combustible)
    {
        $this->combustible = $combustible;
    }

    /**
     * @return mixed
     */
    public function getEstilo()
    {
        return $this->estilo;
    }

    /**
     * @param mixed $estilo
     */
    public function setEstilo($estilo)
    {
        $this->estilo = $estilo;
    }

    /**
     * @return mixed
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param mixed $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    /**
     * @return mixed
     */
    public function getMarcaMotor()
    {
        return $this->marca_motor;
    }

    /**
     * @param mixed $marca_motor
     */
    public function setMarcaMotor($marca_motor)
    {
        $this->marca_motor = $marca_motor;
    }

    /**
     * @return mixed
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * @param mixed $modelo
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * Set kilometraje.
     *
     * @param integer $kilometraje
     *
     * @return Autobus
     */
    public function setKilometraje($kilometraje)
    {
        $this->kilometraje = $kilometraje;
    
        return $this;
    }

    /**
     * Get kilometraje.
     *
     * @return integer
     */
    public function getKilometraje()
    {
        return $this->kilometraje;
    }

    /**
     * @return mixed
     */
    public function getActivo()
    {
        return $this->activo;
    }
    
    /**
     * @param mixed $activo
     */
    public function setActivo($activo)
    {
        $this->activo = $activo;
    }

    /**
     * Set horas.
     *
     * @param integer $horas
     *
     * @return Autobus
     */
    public function setHoras($horas)
    {
        $this->horas = $horas;

        return $this;
    }

    /**
     * Get horas.
     *
     * @return integer
     */
    public function getHoras()
    {
        return $this->horas;
    }
}
