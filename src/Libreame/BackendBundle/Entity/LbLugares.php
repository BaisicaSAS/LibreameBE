<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbLugares
 */
class LbLugares
{
    /**
     * @var integer
     */
    private $inlugar;

    /**
     * @var string
     */
    private $txlugcodigo;

    /**
     * @var string
     */
    private $txlugnombre;

    /**
     * @var \Libreame\BackendBundle\Entity\LbLugares
     */
    private $inlugpadre;


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
