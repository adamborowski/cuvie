<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ResourceRepository")
 * @ORM\Table(name="resource")
 */
class Resource
{
    /**
     * @ORM\Column(type="string", length=32)
     * @ORM\Id
     * na przykład kajak, sniadanieSobota
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $label;
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $longLabel;
    /**
     * @ORM\Column(type="string", length=100, name="description", nullable=true)
     */
    protected $desc;
    /**
     * @ORM\Column(type="float", nullable=true)
     */
    protected $unitPrice;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $available;
    /**
     * @ORM\Column(type="integer", name="_order", nullable=true)
     */
    protected $order;
    private $remaining;

    /**
     * @return mixed
     */
    public function getDesc()
    {
        return $this->desc;
    }

    /**
     * @param mixed $desc
     */
    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    /**
     * @return mixed
     */
    public function getRemaining()
    {
        return $this->remaining;
    }

    /**
     * @param mixed $remaining
     */
    public function setRemaining($remaining)
    {
        $this->remaining = $remaining;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
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
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param mixed $unitPrice
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return mixed
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @param mixed $available
     */
    public function setAvailable($available)
    {
        $this->available = $available;
    }

    /**
     * @return mixed
     */
    public function getLongLabel()
    {
        return $this->longLabel;
    }

    /**
     * @param mixed $longLabel
     */
    public function setLongLabel($longLabel)
    {
        $this->longLabel = $longLabel;
    }
}