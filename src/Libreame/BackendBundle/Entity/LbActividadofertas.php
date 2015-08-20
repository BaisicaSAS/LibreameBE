<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbActividadofertas
 */
class LbActividadofertas
{
    /**
     * @var integer
     */
    private $inactividadoferta;

    /**
     * @var \DateTime
     */
    private $feactfechahora;

    /**
     * @var string
     */
    private $txactdescripcion;

    /**
     * @var integer
     */
    private $inactestado;

    /**
     * @var \Libreame\BackendBundle\Entity\LbActividadofertas
     */
    private $inactpadreact;

    /**
     * @var \Libreame\BackendBundle\Entity\LbOfertas
     */
    private $inactoferta;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     */
    private $inactusuario;


    /**
     * Get inactividadoferta
     *
     * @return integer 
     */
    public function getInactividadoferta()
    {
        return $this->inactividadoferta;
    }

    /**
     * Set feactfechahora
     *
     * @param \DateTime $feactfechahora
     * @return LbActividadofertas
     */
    public function setFeactfechahora($feactfechahora)
    {
        $this->feactfechahora = $feactfechahora;

        return $this;
    }

    /**
     * Get feactfechahora
     *
     * @return \DateTime 
     */
    public function getFeactfechahora()
    {
        return $this->feactfechahora;
    }

    /**
     * Set txactdescripcion
     *
     * @param string $txactdescripcion
     * @return LbActividadofertas
     */
    public function setTxactdescripcion($txactdescripcion)
    {
        $this->txactdescripcion = $txactdescripcion;

        return $this;
    }

    /**
     * Get txactdescripcion
     *
     * @return string 
     */
    public function getTxactdescripcion()
    {
        return $this->txactdescripcion;
    }

    /**
     * Set inactestado
     *
     * @param integer $inactestado
     * @return LbActividadofertas
     */
    public function setInactestado($inactestado)
    {
        $this->inactestado = $inactestado;

        return $this;
    }

    /**
     * Get inactestado
     *
     * @return integer 
     */
    public function getInactestado()
    {
        return $this->inactestado;
    }

    /**
     * Set inactpadreact
     *
     * @param \Libreame\BackendBundle\Entity\LbActividadofertas $inactpadreact
     * @return LbActividadofertas
     */
    public function setInactpadreact(\Libreame\BackendBundle\Entity\LbActividadofertas $inactpadreact = null)
    {
        $this->inactpadreact = $inactpadreact;

        return $this;
    }

    /**
     * Get inactpadreact
     *
     * @return \Libreame\BackendBundle\Entity\LbActividadofertas 
     */
    public function getInactpadreact()
    {
        return $this->inactpadreact;
    }

    /**
     * Set inactoferta
     *
     * @param \Libreame\BackendBundle\Entity\LbOfertas $inactoferta
     * @return LbActividadofertas
     */
    public function setInactoferta(\Libreame\BackendBundle\Entity\LbOfertas $inactoferta = null)
    {
        $this->inactoferta = $inactoferta;

        return $this;
    }

    /**
     * Get inactoferta
     *
     * @return \Libreame\BackendBundle\Entity\LbOfertas 
     */
    public function getInactoferta()
    {
        return $this->inactoferta;
    }

    /**
     * Set inactusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inactusuario
     * @return LbActividadofertas
     */
    public function setInactusuario(\Libreame\BackendBundle\Entity\LbUsuarios $inactusuario = null)
    {
        $this->inactusuario = $inactusuario;

        return $this;
    }

    /**
     * Get inactusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInactusuario()
    {
        return $this->inactusuario;
    }
}
