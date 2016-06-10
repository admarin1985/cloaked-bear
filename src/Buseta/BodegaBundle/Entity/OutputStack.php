<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OutputStack.
 *
 * @ORM\Table(name="d_output_stack")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\OutputStackRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class OutputStack
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
     * @var \Buseta\BodegaBundle\Entity\BitacoraAlmacen
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\BitacoraAlmacen")
     * @ORM\JoinColumn(name="bitacora_id")
     */
    private $bitacora;

    /**
     * @var \Buseta\BodegaBundle\Entity\InputStack
     *
     * @ORM\ManyToOne(targetEntity="Buseta\BodegaBundle\Entity\InputStack")
     * @ORM\JoinColumn(name="input_stack_id")
     */
    private $inputStack;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="decimal", scale=2)
     */
    private $cost;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\Date()
     */
    private $date;


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
     * Set bitacora
     *
     * @param \Buseta\BodegaBundle\Entity\BitacoraAlmacen $bitacora
     * @return OutputStack
     */
    public function setBitacora(\Buseta\BodegaBundle\Entity\BitacoraAlmacen $bitacora = null)
    {
        $this->bitacora = $bitacora;

        return $this;
    }

    /**
     * Get bitacora
     *
     * @return \Buseta\BodegaBundle\Entity\BitacoraAlmacen
     */
    public function getBitacora()
    {
        return $this->bitacora;
    }

    /**
     * Set inputStack
     *
     * @param \Buseta\BodegaBundle\Entity\InputStack $inputStack
     * @return OutputStack
     */
    public function setInputStack(\Buseta\BodegaBundle\Entity\InputStack $inputStack = null)
    {
        $this->inputStack = $inputStack;

        return $this;
    }

    /**
     * Get inputStack
     *
     * @return \Buseta\BodegaBundle\Entity\InputStack
     */
    public function getInputStack()
    {
        return $this->inputStack;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return OutputStack
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set cost
     *
     * @param float $cost
     * @return OutputStack
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get cost
     *
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return OutputStack
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @ORM\PrePersist
     */
    public function PrePersist()
    {
        $this->cost = $this->bitacora->getPrecioUnitario() * $this->quantity;
        $this->date = new \DateTime();
    }

}