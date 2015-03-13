<?php
namespace Buseta\NomencladorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

abstract class BaseNomenclador
{
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="valor", type="string", length=32)
     */
    protected $valor;

    /**
     * Set valor.
     *
     * @param string $valor
     *
     * @return Color
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor.
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    public function __toString()
    {
        return (string) $this->valor;
    }
}
