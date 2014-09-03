<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbSesiones
 */
class LbSesiones
{
    /**
     * @var integer
     */
    private $insesion;

    /**
     * @var string
     */
    private $txsesnumero;

    /**
     * @var integer
     */
    private $insesactiva;

    /**
     * @var \DateTime
     */
    private $fesesfechaini;

    /**
     * @var \DateTime
     */
    private $fesesfechafin;

    /**
     * @var string
     */
    private $txipaddr;

    /**
     * @var \Libreame\BackendBundle\Entity\LbDispusuarios
     */
    private $insesdispusuario;


    /**
     * Get insesion
     *
     * @return integer 
     */
    public function getInsesion()
    {
        return $this->insesion;
    }

    /**
     * Set txsesnumero
     *
     * @param string $txsesnumero
     * @return LbSesiones
     */
    public function setTxsesnumero($txsesnumero)
    {
        $this->txsesnumero = $txsesnumero;

        return $this;
    }

    /**
     * Get txsesnumero
     *
     * @return string 
     */
    public function getTxsesnumero()
    {
        return $this->txsesnumero;
    }

    /**
     * Set insesactiva
     *
     * @param integer $insesactiva
     * @return LbSesiones
     */
    public function setInsesactiva($insesactiva)
    {
        $this->insesactiva = $insesactiva;

        return $this;
    }

    /**
     * Get insesactiva
     *
     * @return integer 
     */
    public function getInsesactiva()
    {
        return $this->insesactiva;
    }

    /**
     * Set fesesfechaini
     *
     * @param \DateTime $fesesfechaini
     * @return LbSesiones
     */
    public function setFesesfechaini($fesesfechaini)
    {
        $this->fesesfechaini = $fesesfechaini;

        return $this;
    }

    /**
     * Get fesesfechaini
     *
     * @return \DateTime 
     */
    public function getFesesfechaini()
    {
        return $this->fesesfechaini;
    }

    /**
     * Set fesesfechafin
     *
     * @param \DateTime $fesesfechafin
     * @return LbSesiones
     */
    public function setFesesfechafin($fesesfechafin)
    {
        $this->fesesfechafin = $fesesfechafin;

        return $this;
    }

    /**
     * Get fesesfechafin
     *
     * @return \DateTime 
     */
    public function getFesesfechafin()
    {
        return $this->fesesfechafin;
    }

    /**
     * Set txipaddr
     *
     * @param string $txipaddr
     * @return LbSesiones
     */
    public function setTxipaddr($txipaddr)
    {
        $this->txipaddr = $txipaddr;

        return $this;
    }

    /**
     * Get txipaddr
     *
     * @return string 
     */
    public function getTxipaddr()
    {
        return $this->txipaddr;
    }

    /**
     * Set insesdispusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbDispusuarios $insesdispusuario
     * @return LbSesiones
     */
    public function setInsesdispusuario(\Libreame\BackendBundle\Entity\LbDispusuarios $insesdispusuario = null)
    {
        $this->insesdispusuario = $insesdispusuario;

        return $this;
    }

    /**
     * Get insesdispusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbDispusuarios 
     */
    public function getInsesdispusuario()
    {
        return $this->insesdispusuario;
    }
}
