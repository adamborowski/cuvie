<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Property
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PropertyRepository")
 */
class Property
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="string")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="_label", type="string", length=100, nullable=true)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    private $value;
    /**
     * @ORM\Column(type="integer", name="_order", nullable=true)
     */
    protected $order;

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
     * Set label
     *
     * @param string $label
     * @return Property
     */
    public function setlabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getlabel()
    {
        return $this->label;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Property
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }
}
