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
    private $id;

    /**
     * @var \DateTime
     */
    private $feactfechahora;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     */
    private $inactusuario;

    /**
     * @var \Libreame\BackendBundle\Entity\LbOfertas
     */
    private $inactoferta;

    /**
     * @var \Libreame\BackendBundle\Entity\LbActividadofertas
     */
    private $inactpadreact;


    /**
     * Get inactividadoferta
     *
     * @return integer 
     */
    public function getInactividadoferta()
    {
        return $this->id;
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
}
