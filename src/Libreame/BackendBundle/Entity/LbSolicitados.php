<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbSolicitados
 */
class LbSolicitados
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $insoltransac;

    /**
     * @var string
     */
    private $txsolobservacion;

    /**
     * @var float
     */
    private $dbsolvaloferta;

    /**
     * @var float
     */
    private $dbsolvaladic;

    /**
     * @var \Libreame\BackendBundle\Entity\LbEjemplares
     */
    private $insolejemplar;

    /**
     * @var \Libreame\BackendBundle\Entity\LbOfertas
     */
    private $insoloferta;


    /**
     * Get insolicitado
     *
     * @return integer 
     */
    public function getInsolicitado()
    {
        return $this->id;
    }

    /**
     * Set insoltransac
     *
     * @param integer $insoltransac
     * @return LbSolicitados
     */
    public function setInsoltransac($insoltransac)
    {
        $this->insoltransac = $insoltransac;

        return $this;
    }

    /**
     * Get insoltransac
     *
     * @return integer 
     */
    public function getInsoltransac()
    {
        return $this->insoltransac;
    }

    /**
     * Set txsolobservacion
     *
     * @param string $txsolobservacion
     * @return LbSolicitados
     */
    public function setTxsolobservacion($txsolobservacion)
    {
        $this->txsolobservacion = $txsolobservacion;

        return $this;
    }

    /**
     * Get txsolobservacion
     *
     * @return string 
     */
    public function getTxsolobservacion()
    {
        return $this->txsolobservacion;
    }

    /**
     * Set dbsolvaloferta
     *
     * @param float $dbsolvaloferta
     * @return LbSolicitados
     */
    public function setDbsolvaloferta($dbsolvaloferta)
    {
        $this->dbsolvaloferta = $dbsolvaloferta;

        return $this;
    }

    /**
     * Get dbsolvaloferta
     *
     * @return float 
     */
    public function getDbsolvaloferta()
    {
        return $this->dbsolvaloferta;
    }

    /**
     * Set dbsolvaladic
     *
     * @param float $dbsolvaladic
     * @return LbSolicitados
     */
    public function setDbsolvaladic($dbsolvaladic)
    {
        $this->dbsolvaladic = $dbsolvaladic;

        return $this;
    }

    /**
     * Get dbsolvaladic
     *
     * @return float 
     */
    public function getDbsolvaladic()
    {
        return $this->dbsolvaladic;
    }

    /**
     * Set insolejemplar
     *
     * @param \Libreame\BackendBundle\Entity\LbEjemplares $insolejemplar
     * @return LbSolicitados
     */
    public function setInsolejemplar(\Libreame\BackendBundle\Entity\LbEjemplares $insolejemplar = null)
    {
        $this->insolejemplar = $insolejemplar;

        return $this;
    }

    /**
     * Get insolejemplar
     *
     * @return \Libreame\BackendBundle\Entity\LbEjemplares 
     */
    public function getInsolejemplar()
    {
        return $this->insolejemplar;
    }

    /**
     * Set insoloferta
     *
     * @param \Libreame\BackendBundle\Entity\LbOfertas $insoloferta
     * @return LbSolicitados
     */
    public function setInsoloferta(\Libreame\BackendBundle\Entity\LbOfertas $insoloferta = null)
    {
        $this->insoloferta = $insoloferta;

        return $this;
    }

    /**
     * Get insoloferta
     *
     * @return \Libreame\BackendBundle\Entity\LbOfertas 
     */
    public function getInsoloferta()
    {
        return $this->insoloferta;
    }
}
