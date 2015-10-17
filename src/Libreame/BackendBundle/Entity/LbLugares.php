<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbLugares
 *
 * @ORM\Table(name="lb_lugares", indexes={@ORM\Index(name="fk_lb_lugares_lb_lugares1_idx", columns={"inLugPadre"})})
 * @ORM\Entity
 */
class LbLugares
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inLugar", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $inlugar;

    /**
     * @var string
     *
     * @ORM\Column(name="txLugCodigo", type="string", length=45, nullable=false)
     */
    protected $txlugcodigo;

    /**
     * @var string
     *
     * @ORM\Column(name="txLugNombre", type="string", length=100, nullable=false)
     */
    protected $txlugnombre;

    /**
     * @var \LbLugares
     *
     * @ORM\ManyToOne(targetEntity="LbLugares")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inLugPadre", referencedColumnName="inLugar")
     * })
     */
    protected $inlugpadre;



    /**
     * Get inlugar
     *
     * @return integer 
     */
    public function getInlugar()
    {
        return $this->inlugar;
    }

    /**
     * Set txlugcodigo
     *
     * @param string $txlugcodigo
     * @return LbLugares
     */
    public function setTxlugcodigo($txlugcodigo)
    {
        $this->txlugcodigo = $txlugcodigo;

        return $this;
    }

    /**
     * Get txlugcodigo
     *
     * @return string 
     */
    public function getTxlugcodigo()
    {
        return $this->txlugcodigo;
    }

    /**
     * Set txlugnombre
     *
     * @param string $txlugnombre
     * @return LbLugares
     */
    public function setTxlugnombre($txlugnombre)
    {
        $this->txlugnombre = $txlugnombre;

        return $this;
    }

    /**
     * Get txlugnombre
     *
     * @return string 
     */
    public function getTxlugnombre()
    {
        return $this->txlugnombre;
    }

    /**
     * Set inlugpadre
     *
     * @param \Libreame\BackendBundle\Entity\LbLugares $inlugpadre
     * @return LbLugares
     */
    public function setInlugpadre(\Libreame\BackendBundle\Entity\LbLugares $inlugpadre = null)
    {
        $this->inlugpadre = $inlugpadre;

        return $this;
    }

    /**
     * Get inlugpadre
     *
     * @return \Libreame\BackendBundle\Entity\LbLugares 
     */
    public function getInlugpadre()
    {
        return $this->inlugpadre;
    }
}
