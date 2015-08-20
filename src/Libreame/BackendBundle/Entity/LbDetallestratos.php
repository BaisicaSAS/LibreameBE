<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbDetallestratos
 */
class LbDetallestratos
{
    /**
     * @var integer
     */
    private $indetalletrato;

    /**
     * @var float
     */
    private $indetvalorusr;

    /**
     * @var float
     */
    private $indetvalorotro;

    /**
     * @var \Libreame\BackendBundle\Entity\LbEjemplares
     */
    private $indetejemplarusr;

    /**
     * @var \Libreame\BackendBundle\Entity\LbEjemplares
     */
    private $indetejemplarotro;

    /**
     * @var \Libreame\BackendBundle\Entity\LbTratos
     */
    private $indettrato;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     */
    private $indetusuario;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     */
    private $indetusuariootro;


    /**
     * Get indetalletrato
     *
     * @return integer 
     */
    public function getIndetalletrato()
    {
        return $this->indetalletrato;
    }

    /**
     * Set indetvalorusr
     *
     * @param float $indetvalorusr
     * @return LbDetallestratos
     */
    public function setIndetvalorusr($indetvalorusr)
    {
        $this->indetvalorusr = $indetvalorusr;

        return $this;
    }

    /**
     * Get indetvalorusr
     *
     * @return float 
     */
    public function getIndetvalorusr()
    {
        return $this->indetvalorusr;
    }

    /**
     * Set indetvalorotro
     *
     * @param float $indetvalorotro
     * @return LbDetallestratos
     */
    public function setIndetvalorotro($indetvalorotro)
    {
        $this->indetvalorotro = $indetvalorotro;

        return $this;
    }

    /**
     * Get indetvalorotro
     *
     * @return float 
     */
    public function getIndetvalorotro()
    {
        return $this->indetvalorotro;
    }

    /**
     * Set indetejemplarusr
     *
     * @param \Libreame\BackendBundle\Entity\LbEjemplares $indetejemplarusr
     * @return LbDetallestratos
     */
    public function setIndetejemplarusr(\Libreame\BackendBundle\Entity\LbEjemplares $indetejemplarusr = null)
    {
        $this->indetejemplarusr = $indetejemplarusr;

        return $this;
    }

    /**
     * Get indetejemplarusr
     *
     * @return \Libreame\BackendBundle\Entity\LbEjemplares 
     */
    public function getIndetejemplarusr()
    {
        return $this->indetejemplarusr;
    }

    /**
     * Set indetejemplarotro
     *
     * @param \Libreame\BackendBundle\Entity\LbEjemplares $indetejemplarotro
     * @return LbDetallestratos
     */
    public function setIndetejemplarotro(\Libreame\BackendBundle\Entity\LbEjemplares $indetejemplarotro = null)
    {
        $this->indetejemplarotro = $indetejemplarotro;

        return $this;
    }

    /**
     * Get indetejemplarotro
     *
     * @return \Libreame\BackendBundle\Entity\LbEjemplares 
     */
    public function getIndetejemplarotro()
    {
        return $this->indetejemplarotro;
    }

    /**
     * Set indettrato
     *
     * @param \Libreame\BackendBundle\Entity\LbTratos $indettrato
     * @return LbDetallestratos
     */
    public function setIndettrato(\Libreame\BackendBundle\Entity\LbTratos $indettrato = null)
    {
        $this->indettrato = $indettrato;

        return $this;
    }

    /**
     * Get indettrato
     *
     * @return \Libreame\BackendBundle\Entity\LbTratos 
     */
    public function getIndettrato()
    {
        return $this->indettrato;
    }

    /**
     * Set indetusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $indetusuario
     * @return LbDetallestratos
     */
    public function setIndetusuario(\Libreame\BackendBundle\Entity\LbUsuarios $indetusuario = null)
    {
        $this->indetusuario = $indetusuario;

        return $this;
    }

    /**
     * Get indetusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getIndetusuario()
    {
        return $this->indetusuario;
    }

    /**
     * Set indetusuariootro
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $indetusuariootro
     * @return LbDetallestratos
     */
    public function setIndetusuariootro(\Libreame\BackendBundle\Entity\LbUsuarios $indetusuariootro = null)
    {
        $this->indetusuariootro = $indetusuariootro;

        return $this;
    }

    /**
     * Get indetusuariootro
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getIndetusuariootro()
    {
        return $this->indetusuariootro;
    }
}
