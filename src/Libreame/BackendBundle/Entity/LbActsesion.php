<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbActsesion
 *
 * @ORM\Table(name="lb_actsesion", indexes={@ORM\Index(name="fk_lb_ActSesion_lb_sesiones1_idx", columns={"inActSesionDisUs"})})
 * @ORM\Entity
 */
class LbActsesion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inActSesion", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inactsesion;

    /**
     * @var string
     *
     * @ORM\Column(name="txActAccion", type="string", length=5, nullable=false)
     */
    private $txactaccion;

    /**
     * @var string
     *
     * @ORM\Column(name="txActMensaje", type="string", length=50, nullable=false)
     */
    private $txactmensaje;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feActFecha", type="datetime", nullable=false)
     */
    private $feactfecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="inActFinalizada", type="integer", nullable=false)
     */
    private $inactfinalizada;

    /**
     * @var \Libreame\BackendBundle\Entity\LbSesiones
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbSesiones")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inActSesionDisUs", referencedColumnName="inSesion")
     * })
     */
    private $inactsesiondisus;



    /**
     * Get inactsesion
     *
     * @return integer 
     */
    public function getInactsesion()
    {
        return $this->inactsesion;
    }

    /**
     * Set txactaccion
     *
     * @param string $txactaccion
     * @return LbActsesion
     */
    public function setTxactaccion($txactaccion)
    {
        $this->txactaccion = $txactaccion;

        return $this;
    }

    /**
     * Get txactaccion
     *
     * @return string 
     */
    public function getTxactaccion()
    {
        return $this->txactaccion;
    }

    /**
     * Set txactmensaje
     *
     * @param string $txactmensaje
     * @return LbActsesion
     */
    public function setTxactmensaje($txactmensaje)
    {
        $this->txactmensaje = $txactmensaje;

        return $this;
    }

    /**
     * Get txactmensaje
     *
     * @return string 
     */
    public function getTxactmensaje()
    {
        return $this->txactmensaje;
    }

    /**
     * Set feactfecha
     *
     * @param \DateTime $feactfecha
     * @return LbActsesion
     */
    public function setFeactfecha($feactfecha)
    {
        $this->feactfecha = $feactfecha;

        return $this;
    }

    /**
     * Get feactfecha
     *
     * @return \DateTime 
     */
    public function getFeactfecha()
    {
        return $this->feactfecha;
    }

    /**
     * Set inactfinalizada
     *
     * @param integer $inactfinalizada
     * @return LbActsesion
     */
    public function setInactfinalizada($inactfinalizada)
    {
        $this->inactfinalizada = $inactfinalizada;

        return $this;
    }

    /**
     * Get inactfinalizada
     *
     * @return integer 
     */
    public function getInactfinalizada()
    {
        return $this->inactfinalizada;
    }

    /**
     * Set inactsesiondisus
     *
     * @param \Libreame\BackendBundle\Entity\LbSesiones $inactsesiondisus
     * @return LbActsesion
     */
    public function setInactsesiondisus(\Libreame\BackendBundle\Entity\LbSesiones $inactsesiondisus = null)
    {
        $this->inactsesiondisus = $inactsesiondisus;

        return $this;
    }

    /**
     * Get inactsesiondisus
     *
     * @return \Libreame\BackendBundle\Entity\LbSesiones 
     */
    public function getInactsesiondisus()
    {
        return $this->inactsesiondisus;
    }
}
