<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MecanismoContacto
 *
 * @ORM\Table(name="d_mecanismocontacto")
 * @ORM\Entity
 */
class MecanismoContacto
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
     * @ORM\ManyToOne(targetEntity="Buseta\NomencladorBundle\Entity\TipoContacto", inversedBy="mecanismocontacto")
     */
    private $tipocontacto;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string")
     */
    private $valor;

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
     * @param mixed $tipocontacto
     */
    public function setTipocontacto($tipocontacto)
    {
        $this->tipocontacto = $tipocontacto;
    }

    /**
     * @return mixed
     */
    public function getTipocontacto()
    {
        return $this->tipocontacto;
    }

    /**
     * @param string $valor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    /**
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

}