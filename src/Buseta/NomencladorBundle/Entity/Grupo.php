<?php

namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grupo
 *
 * @ORM\Table(name="n_grupo")
 * @ORM\Entity
 */
class Grupo extends BaseNomenclador
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=255)
     */
    protected $valor;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buseta\NomencladorBundle\Entity\Subgrupo", mappedBy="grupo", cascade={"all"})
     */
    private $subgrupos;



    public function __toString()
    {
        return $this->valor;
    }

    /**
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subgrupos = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set valor
     *
     * @param string $valor
     * @return Grupo
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    
        return $this;
    }

    /**
     * Get valor
     *
     * @return string 
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Add subgrupos
     *
     * @param \Buseta\NomencladorBundle\Entity\Subgrupo $subgrupos
     * @return Grupo
     */
    public function addSubgrupo(\Buseta\NomencladorBundle\Entity\Subgrupo $subgrupos)
    {
        $subgrupos->setGrupo($this);

        $this->subgrupos[] = $subgrupos;
    
        return $this;
    }

    /**
     * Remove subgrupos
     *
     * @param \Buseta\NomencladorBundle\Entity\Subgrupo $subgrupos
     */
    public function removeSubgrupo(\Buseta\NomencladorBundle\Entity\Subgrupo $subgrupos)
    {
        $this->subgrupos->removeElement($subgrupos);
    }

    /**
     * Get subgrupos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubgrupos()
    {
        return $this->subgrupos;
    }
}