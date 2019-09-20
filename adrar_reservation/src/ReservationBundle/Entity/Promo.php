<?php

namespace ReservationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promo
 *
 * @ORM\Table(name="promo")
 * @ORM\Entity(repositoryClass="ReservationBundle\Repository\PromoRepository")
 */
class Promo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="nbEleve", type="string", length=255)
     */
    private $nbEleve;
    /**
     * string
     *
     *
     * @return string
     */
    public function __toString()
    {

        return $this->name.' '.$this->nbEleve;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Promo
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nbEleve
     *
     * @param string $nbEleve
     *
     * @return Promo
     */
    public function setNbEleve($nbEleve)
    {
        $this->nbEleve = $nbEleve;

        return $this;
    }

    /**
     * Get nbEleve
     *
     * @return string
     */
    public function getNbEleve()
    {
        return $this->nbEleve;
    }
}
