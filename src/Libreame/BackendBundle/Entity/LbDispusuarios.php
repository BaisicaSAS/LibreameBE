<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbDispusuarios
 */
class LbDispusuarios
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $txdisid;

    /**
     * @var string
     */
    private $txdisnombre;

    /**
     * @var string
     */
    private $txdismarca;

    /**
     * @var string
     */
    private $txdismodelo;

    /**
     * @var string
     */
    private $txdisso;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     */
    private $indisusuario;


    /**
     * Get indispusuario
     *
     * @return integer 
     */
    public function getIndispusuario()
    {
        return $this->id;
    }

    /**
     * Set txdisid
     *
     * @param string $txdisid
     * @return LbDispusuarios
     */
    public function setTxdisid($txdisid)
    {
        $this->txdisid = $txdisid;

        return $this;
    }

    /**
     * Get txdisid
     *
     * @return string 
     */
    public function getTxdisid()
    {
        return $this->txdisid;
    }

    /**
     * Set txdisnombre
     *
     * @param string $txdisnombre
     * @return LbDispusuarios
     */
    public function setTxdisnombre($txdisnombre)
    {
        $this->txdisnombre = $txdisnombre;

        return $this;
    }

    /**
     * Get txdisnombre
     *
     * @return string 
     */
    public function getTxdisnombre()
    {
        return $this->txdisnombre;
    }

    /**
     * Set txdismarca
     *
     * @param string $txdismarca
     * @return LbDispusuarios
     */
    public function setTxdismarca($txdismarca)
    {
        $this->txdismarca = $txdismarca;

        return $this;
    }

    /**
     * Get txdismarca
     *
     * @return string 
     */
    public function getTxdismarca()
    {
        return $this->txdismarca;
    }

    /**
     * Set txdismodelo
     *
     * @param string $txdismodelo
     * @return LbDispusuarios
     */
    public function setTxdismodelo($txdismodelo)
    {
        $this->txdismodelo = $txdismodelo;

        return $this;
    }

    /**
     * Get txdismodelo
     *
     * @return string 
     */
    public function getTxdismodelo()
    {
        return $this->txdismodelo;
    }

    /**
     * Set txdisso
     *
     * @param string $txdisso
     * @return LbDispusuarios
     */
    public function setTxdisso($txdisso)
    {
        $this->txdisso = $txdisso;

        return $this;
    }

    /**
     * Get txdisso
     *
     * @return string 
     */
    public function getTxdisso()
    {
        return $this->txdisso;
    }

    /**
     * Set indisusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $indisusuario
     * @return LbDispusuarios
     */
    public function setIndisusuario(\Libreame\BackendBundle\Entity\LbUsuarios $indisusuario = null)
    {
        $this->indisusuario = $indisusuario;

        return $this;
    }

    /**
     * Get indisusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getIndisusuario()
    {
        return $this->indisusuario;
    }
}
