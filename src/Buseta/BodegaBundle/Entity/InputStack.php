<?php

namespace Buseta\BodegaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * InputStack.
 *
 * @ORM\Table(name="d_input_stack")
 * @ORM\Entity(repositoryClass="Buseta\BodegaBundle\Entity\Repository\InputStackRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class InputStack
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
     * @ORM\OneToOne(targetEntity="Buseta\BodegaBundle\Entity\BitacoraAlmacen")
     * @ORM\JoinColumn(name="bitacora_id")
     */
    private $bitacora;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private $quantity;

    /**
     * @var float
     *
     * @ORM\Column(name="transaction_cost", type="decimal", scale=2)
     */
    private $transactionCost;


    /**
     * @var integer
     *
     * @ORM\Column(name="remaining_quantity", type="integer", nullable=false)
     */
    private $remainingQuantity;

    /**
     * @var float
     *
     * @ORM\Column(name="remaining_cost", type="decimal", scale=2)
     */
    private $remainingCost;

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
     * @return InputStack
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
     * Set quantity
     *
     * @param integer $quantity
     * @return InputStack
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
     * Set transactionCost
     *
     * @param float $transactionCost
     * @return InputStack
     */
    public function setTransactionCost($transactionCost)
    {
        $this->transactionCost = $transactionCost;

        return $this;
    }

    /**
     * Get transactionCost
     *
     * @return float
     */
    public function getTransactionCost()
    {
        return $this->transactionCost;
    }

    /**
     * Set remainingQuantity
     *
     * @param integer $remainingQuantity
     * @return InputStack
     */
    public function setRemainingQuantity($remainingQuantity)
    {
        $this->remainingQuantity = $remainingQuantity;

        return $this;
    }

    /**
     * Get remainingQuantity
     *
     * @return integer
     */
    public function getRemainingQuantity()
    {
        return $this->remainingQuantity;
    }

    /**
     * Set remainingCost
     *
     * @param float $remainingCost
     * @return InputStack
     */
    public function setRemainingCost($remainingCost)
    {
        $this->remainingCost = remainingCost;

        return $this;
    }

    /**
     * Get remainingCost
     *
     * @return float
     */
    public function getRemainingCost()
    {
        return $this->remainingCost;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return InputStack
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
        $this->transactionCost = $this->bitacora->getPrecioUnitario() * $this->quantity;
        $this->remainingCost = $this->bitacora->getPrecioUnitario() * $this->quantity;
        $this->date = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->remainingCost = $this->bitacora->getPrecioUnitario() * $this->remainingQuantity;
    }

}