<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customerOrder")
 */
class Order
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $firstName;
    /**
     * @ORM\Column(type="datetime", length=100)
     */
    protected $creationDate;
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $lastName;
    /**
     * @ORM\Column(type="string", length=256)
     */
    protected $email;
    /**
     * @ORM\Column(type="object")
     */
    protected $details;
    /**
     * @ORM\Column(type="float")
     */
    protected $totalPrice;

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @param mixed $totalPrice
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;
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

    public function setDetail($name, $value)
    {
        if (is_null($value)) {
            $this->removeDetail($name);
        } else {
            $this->details[$name] = $value;
        }
    }

    public function removeDetail($name)
    {
        unset($this->details[$name]);
    }

    public function getDetail($name)
    {
        if ($this->isDetailSet($name)) {
            return $this->details[$name];
        }
        return null;
    }

    public function  isDetailSet($name)
    {
        return isset($this->details[$name]);
    }
}