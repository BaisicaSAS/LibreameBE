<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbActsesion
 */
class LbActsesion
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $inactaccion;

    /**
     * @var string
     */
    private $txactmensaje;

    /**
     * @var \DateTime
     */
    private $feactfecha;

    /**
     * @var integer
     */
    private $inactfinalizada;

    /**
     * @var \Libreame\BackendBundle\Entity\LbSesiones
     */
    private $inactsesiondisus;


    /**
     * Get inactsesion
     *
     * @return integer 
     */
    public function getInactsesion()
    {
        return $this->id;
    }

    /**
     * Set inactaccion
     *
     * @param integer $inactaccion
     * @return LbActsesion
     */
    public function setInactaccion($inactaccion)
    {
        $this->inactaccion = $inactaccion;

        return $this;
    }

    /**
     * Get inactaccion
     *
     * @return integer 
     */
    public function getInactaccion()
    {
        return $this->inactaccion;
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
