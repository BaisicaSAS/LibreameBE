<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbTratos
 */
class LbTratos
{
    /**
     * @var integer
     */
    private $intrato;

    /**
     * @var \DateTime
     */
    private $intrafecha;

    /**
     * @var integer
     */
    private $intraestado;

    /**
     * @var string
     */
    private $txtraacuentrega;

    /**
     * @var \DateTime
     */
    private $fetrafecentrega;

    /**
     * @var \Libreame\BackendBundle\Entity\LbOfertas
     */
    private $intraoferta;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     */
    private $intrausuofrecio;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     */
    private $intrausuacepto;


    /**
     * Get intrato
     *
     * @return integer 
     */
    public function getIntrato()
    {
        return $this->intrato;
    }

    /**
     * Set intrafecha
     *
     * @param \DateTime $intrafecha
     * @return LbTratos
     */
    public function setIntrafecha($intrafecha)
    {
        $this->intrafecha = $intrafecha;

        return $this;
    }

    /**
     * Get intrafecha
     *
     * @return \DateTime 
     */
    public function getIntrafecha()
    {
        return $this->intrafecha;
    }

    /**
     * Set intraestado
     *
     * @param integer $intraestado
     * @return LbTratos
     */
    public function setIntraestado($intraestado)
    {
        $this->intraestado = $intraestado;

        return $this;
    }

    /**
     * Get intraestado
     *
     * @return integer 
     */
    public function getIntraestado()
    {
        return $this->intraestado;
    }

    /**
     * Set txtraacuentrega
     *
     * @param string $txtraacuentrega
     * @return LbTratos
     */
    public function setTxtraacuentrega($txtraacuentrega)
    {
        $this->txtraacuentrega = $txtraacuentrega;

        return $this;
    }

    /**
     * Get txtraacuentrega
     *
     * @return string 
     */
    public function getTxtraacuentrega()
    {
        return $this->txtraacuentrega;
    }

    /**
     * Set fetrafecentrega
     *
     * @param \DateTime $fetrafecentrega
     * @return LbTratos
     */
    public function setFetrafecentrega($fetrafecentrega)
    {
        $this->fetrafecentrega = $fetrafecentrega;

        return $this;
    }

    /**
     * Get fetrafecentrega
     *
     * @return \DateTime 
     */
    public function getFetrafecentrega()
    {
        return $this->fetrafecentrega;
    }

    /**
     * Set intraoferta
     *
     * @param \Libreame\BackendBundle\Entity\LbOfertas $intraoferta
     * @return LbTratos
     */
    public function setIntraoferta(\Libreame\BackendBundle\Entity\LbOfertas $intraoferta = null)
    {
        $this->intraoferta = $intraoferta;

        return $this;
    }

    /**
     * Get intraoferta
     *
     * @return \Libreame\BackendBundle\Entity\LbOfertas 
     */
    public function getIntraoferta()
    {
        return $this->intraoferta;
    }

    /**
     * Set intrausuofrecio
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $intrausuofrecio
     * @return LbTratos
     */
    public function setIntrausuofrecio(\Libreame\BackendBundle\Entity\LbUsuarios $intrausuofrecio = null)
    {
        $this->intrausuofrecio = $intrausuofrecio;

        return $this;
    }

    /**
     * Get intrausuofrecio
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getIntrausuofrecio()
    {
        return $this->intrausuofrecio;
    }

    /**
     * Set intrausuacepto
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $intrausuacepto
     * @return LbTratos
     */
    public function setIntrausuacepto(\Libreame\BackendBundle\Entity\LbUsuarios $intrausuacepto = null)
    {
        $this->intrausuacepto = $intrausuacepto;

        return $this;
    }

    /**
     * Get intrausuacepto
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getIntrausuacepto()
    {
        return $this->intrausuacepto;
    }
}
