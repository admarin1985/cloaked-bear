<?php

namespace Buseta\TallerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Linea
 *
 * @ORM\Table(name="d_tarea_adicional")
 * @ORM\Entity(repositoryClass="Buseta\TallerBundle\Entity\TareaAdicionalRepository")
 */
class TareaAdicional
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
     * @ORM\ManyToOne(targetEntity="Buseta\TallerBundle\Entity\OrdenTrabajo", inversedBy="tarea_adicional")
     */
    private $orden_trabajo;

    /**
     * @var string
     *
     * @ORM\Column(name="tarea", type="string", nullable=false)
     */
    private $tarea;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_estimada", type="date")
     * @Assert\Date()
     */
    private $fecha_estimada;

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
     * Set tarea
     *
     * @param string $tarea
     * @return TareaAdicional
     */
    public function setTarea($tarea)
    {
        $this->tarea = $tarea;
    
        return $this;
    }

    /**
     * Get tarea
     *
     * @return string 
     */
    public function getTarea()
    {
        return $this->tarea;
    }

    /**
     * Set fecha_estimada
     *
     * @param \DateTime $fechaEstimada
     * @return TareaAdicional
     */
    public function setFechaEstimada($fechaEstimada)
    {
        $this->fecha_estimada = $fechaEstimada;
    
        return $this;
    }

    /**
     * Get fecha_estimada
     *
     * @return \DateTime 
     */
    public function getFechaEstimada()
    {
        return $this->fecha_estimada;
    }

    /**
     * Set grupos
     *
     * @param \Buseta\NomencladorBundle\Entity\Grupo $grupos
     * @return TareaAdicional
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
     * @return TareaAdicional
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
     * Set orden_trabajo
     *
     * @param \Buseta\TallerBundle\Entity\OrdenTrabajo $ordenTrabajo
     * @return TareaAdicional
     */
    public function setOrdenTrabajo(\Buseta\TallerBundle\Entity\OrdenTrabajo $ordenTrabajo = null)
    {
        $this->orden_trabajo = $ordenTrabajo;
    
        return $this;
    }

    /**
     * Get orden_trabajo
     *
     * @return \Buseta\TallerBundle\Entity\OrdenTrabajo 
     */
    public function getOrdenTrabajo()
    {
        return $this->orden_trabajo;
    }
}