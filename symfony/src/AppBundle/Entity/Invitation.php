<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Invitation
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\InvitationRepository")
 */
class Invitation
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
     * @ORM\Column(name="code", type="string", length=16)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="string", length=255)
     */
    private $template;

    /**
     * @var boolean
     *
     * @ORM\Column(name="onlyChurch", type="boolean")
     */
    private $onlyChurch;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="confrimDate", type="datetime")
     */
    private $confrimDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastGuestChangeDate", type="datetime")
     */
    private $lastGuestChangeDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastAdminChangeDate", type="datetime")
     */
    private $lastAdminChangeDate;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255)
     */
    private $adress;

    /**
     * @var integer
     *
     * @ORM\Column(name="numChildren", type="integer")
     */
    private $numChildren;
    /**
     * @ORM\OneToMany(targetEntity="Person", mappedBy="invitation")
     **/
    private $persons;
    /**
     * @ORM\OneToMany(targetEntity="Preference", mappedBy="invitation", cascade={"all"})
     */
    private $preferences;

    /**
     * Invitation constructor.
     */
    public function __construct()
    {
        $this->persons = new ArrayCollection();
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
    public function getPersons()
    {
        return $this->persons;
    }

    /**
     * @param mixed $persons
     */
    public function setPersons($persons)
    {
        $this->persons = $persons;
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
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Invitation
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set template
     *
     * @param string $template
     * @return Invitation
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get onlyChurch
     *
     * @return boolean
     */
    public function getOnlyChurch()
    {
        return $this->onlyChurch;
    }

    /**
     * Set onlyChurch
     *
     * @param boolean $onlyChurch
     * @return Invitation
     */
    public function setOnlyChurch($onlyChurch)
    {
        $this->onlyChurch = $onlyChurch;

        return $this;
    }

    /**
     * Get confrimDate
     *
     * @return \DateTime
     */
    public function getConfrimDate()
    {
        return $this->confrimDate;
    }

    /**
     * Set confrimDate
     *
     * @param \DateTime $confrimDate
     * @return Invitation
     */
    public function setConfrimDate($confrimDate)
    {
        $this->confrimDate = $confrimDate;

        return $this;
    }

    /**
     * Get lastGuestChangeDate
     *
     * @return \DateTime
     */
    public function getLastGuestChangeDate()
    {
        return $this->lastGuestChangeDate;
    }

    /**
     * Set lastGuestChangeDate
     *
     * @param \DateTime $lastGuestChangeDate
     * @return Invitation
     */
    public function setLastGuestChangeDate($lastGuestChangeDate)
    {
        $this->lastGuestChangeDate = $lastGuestChangeDate;

        return $this;
    }

    /**
     * Get lastAdminChangeDate
     *
     * @return \DateTime
     */
    public function getLastAdminChangeDate()
    {
        return $this->lastAdminChangeDate;
    }

    /**
     * Set lastAdminChangeDate
     *
     * @param \DateTime $lastAdminChangeDate
     * @return Invitation
     */
    public function setLastAdminChangeDate($lastAdminChangeDate)
    {
        $this->lastAdminChangeDate = $lastAdminChangeDate;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set adress
     *
     * @param string $adress
     * @return Invitation
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get numChildren
     *
     * @return integer
     */
    public function getNumChildren()
    {
        return $this->numChildren;
    }

    /**
     * Set numChildren
     *
     * @param integer $numChildren
     * @return Invitation
     */
    public function setNumChildren($numChildren)
    {
        $this->numChildren = $numChildren;

        return $this;
    }
}
