<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Person
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PersonRepository")
 */
class Person
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
     * @ORM\Column(name="firstName", type="string", length=64)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="altFirstName", type="string", length=64)
     */
    private $altFirstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=128)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="altLastName", type="string", length=128)
     */
    private $altLastName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isMale", type="boolean")
     */
    private $isMale;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isAnonymous", type="boolean")
     */
    private $isAnonymous;

    /**
     * @var integer
     *
     * @ORM\Column(name="ord", type="integer")
     */
    private $ord;

    /**
     * @var boolean
     *
     * @ORM\Column(name="showOnInvitation", type="boolean")
     */
    private $showOnInvitation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isConfirmed", type="boolean")
     */
    private $isConfirmed;

    /**
     * @ORM\OneToOne(targetEntity="Person")
     **/
    private $partner;
    /**
     * @ORM\ManyToOne(targetEntity="Invitation", inversedBy="persons")
     */
    private $invitation;
    /**
     * @ORM\OneToMany(targetEntity="Preference", mappedBy="person", cascade={"all"})
     */
    private $preferences;

    /**
     * Person constructor.
     */
    public function __construct()
    {
        $this->preferences = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPreferences()
    {
        return $this->preferences;
    }

    /**
     * @param mixed $preferences
     */
    public function setPreferences($preferences)
    {
        $this->preferences = $preferences;
    }

    /**
     * @return mixed
     */
    public function getInvitation()
    {
        return $this->invitation;
    }

    /**
     * @param mixed $invitation
     */
    public function setInvitation($invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * @return mixed
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * @param mixed $partner
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;
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
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get altFirstName
     *
     * @return string
     */
    public function getAltFirstName()
    {
        return $this->altFirstName;
    }

    /**
     * Set altFirstName
     *
     * @param string $altFirstName
     * @return Person
     */
    public function setAltFirstName($altFirstName)
    {
        $this->altFirstName = $altFirstName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Person
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get altLastName
     *
     * @return string
     */
    public function getAltLastName()
    {
        return $this->altLastName;
    }

    /**
     * Set altLastName
     *
     * @param string $altLastName
     * @return Person
     */
    public function setAltLastName($altLastName)
    {
        $this->altLastName = $altLastName;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get isMale
     *
     * @return boolean
     */
    public function getIsMale()
    {
        return $this->isMale;
    }

    /**
     * Set isMale
     *
     * @param boolean $isMale
     * @return Person
     */
    public function setIsMale($isMale)
    {
        $this->isMale = $isMale;

        return $this;
    }

    /**
     * Get isAnonymous
     *
     * @return boolean
     */
    public function getIsAnonymous()
    {
        return $this->isAnonymous;
    }

    /**
     * Set isAnonymous
     *
     * @param boolean $isAnonymous
     * @return Person
     */
    public function setIsAnonymous($isAnonymous)
    {
        $this->isAnonymous = $isAnonymous;

        return $this;
    }

    /**
     * Get ord
     *
     * @return integer
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * Set ord
     *
     * @param integer $ord
     * @return Person
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;

        return $this;
    }

    /**
     * Get showOnInvitation
     *
     * @return boolean
     */
    public function getShowOnInvitation()
    {
        return $this->showOnInvitation;
    }

    /**
     * Set showOnInvitation
     *
     * @param boolean $showOnInvitation
     * @return Person
     */
    public function setShowOnInvitation($showOnInvitation)
    {
        $this->showOnInvitation = $showOnInvitation;

        return $this;
    }

    /**
     * Get isConfirmed
     *
     * @return boolean
     */
    public function getIsConfirmed()
    {
        return $this->isConfirmed;
    }

    /**
     * Set isConfirmed
     *
     * @param boolean $isConfirmed
     * @return Person
     */
    public function setIsConfirmed($isConfirmed)
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }
}
