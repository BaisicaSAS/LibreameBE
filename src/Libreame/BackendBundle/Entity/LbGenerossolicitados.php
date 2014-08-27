<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbGenerossolicitados
 */
class LbGenerossolicitados
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Libreame\BackendBundle\Entity\LbGeneros
     */
    private $insolgenero;

    /**
     * @var \Libreame\BackendBundle\Entity\LbSolicitados
     */
    private $insolsolicitado;


    /**
     * Get ingenerosolicitado
     *
     * @return integer 
     */
    public function getIngenerosolicitado()
    {
        return $this->id;
    }

    /**
     * Set insolgenero
     *
     * @param \Libreame\BackendBundle\Entity\LbGeneros $insolgenero
     * @return LbGenerossolicitados
     */
    public function setInsolgenero(\Libreame\BackendBundle\Entity\LbGeneros $insolgenero = null)
    {
        $this->insolgenero = $insolgenero;

        return $this;
    }

    /**
     * Get insolgenero
     *
     * @return \Libreame\BackendBundle\Entity\LbGeneros 
     */
    public function getInsolgenero()
    {
        return $this->insolgenero;
    }

    /**
     * Set insolsolicitado
     *
     * @param \Libreame\BackendBundle\Entity\LbSolicitados $insolsolicitado
     * @return LbGenerossolicitados
     */
    public function setInsolsolicitado(\Libreame\BackendBundle\Entity\LbSolicitados $insolsolicitado = null)
    {
        $this->insolsolicitado = $insolsolicitado;

        return $this;
    }

    /**
     * Get insolsolicitado
     *
     * @return \Libreame\BackendBundle\Entity\LbSolicitados 
     */
    public function getInsolsolicitado()
    {
        return $this->insolsolicitado;
    }
}
