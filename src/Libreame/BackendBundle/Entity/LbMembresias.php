<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbMembresias
 */
class LbMembresias
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $inmemcreador;

    /**
     * @var integer
     */
    private $inmemactiva;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     */
    private $inmemusuario;

    /**
     * @var \Libreame\BackendBundle\Entity\LbGrupos
     */
    private $inmemgrupo;


    /**
     * Get inmembresia
     *
     * @return integer 
     */
    public function getInmembresia()
    {
        return $this->id;
    }

    /**
     * Set inmemcreador
     *
     * @param integer $inmemcreador
     * @return LbMembresias
     */
    public function setInmemcreador($inmemcreador)
    {
        $this->inmemcreador = $inmemcreador;

        return $this;
    }

    /**
     * Get inmemcreador
     *
     * @return integer 
     */
    public function getInmemcreador()
    {
        return $this->inmemcreador;
    }

    /**
     * Set inmemactiva
     *
     * @param integer $inmemactiva
     * @return LbMembresias
     */
    public function setInmemactiva($inmemactiva)
    {
        $this->inmemactiva = $inmemactiva;

        return $this;
    }

    /**
     * Get inmemactiva
     *
     * @return integer 
     */
    public function getInmemactiva()
    {
        return $this->inmemactiva;
    }

    /**
     * Set inmemusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inmemusuario
     * @return LbMembresias
     */
    public function setInmemusuario(\Libreame\BackendBundle\Entity\LbUsuarios $inmemusuario = null)
    {
        $this->inmemusuario = $inmemusuario;

        return $this;
    }

    /**
     * Get inmemusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInmemusuario()
    {
        return $this->inmemusuario;
    }

    /**
     * Set inmemgrupo
     *
     * @param \Libreame\BackendBundle\Entity\LbGrupos $inmemgrupo
     * @return LbMembresias
     */
    public function setInmemgrupo(\Libreame\BackendBundle\Entity\LbGrupos $inmemgrupo = null)
    {
        $this->inmemgrupo = $inmemgrupo;

        return $this;
    }

    /**
     * Get inmemgrupo
     *
     * @return \Libreame\BackendBundle\Entity\LbGrupos 
     */
    public function getInmemgrupo()
    {
        return $this->inmemgrupo;
    }
}
