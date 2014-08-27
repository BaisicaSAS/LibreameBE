<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbOfrecidos
 */
class LbOfrecidos
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $inofrtransac;

    /**
     * @var string
     */
    private $txofrobservacion;

    /**
     * @var float
     */
    private $dbofrvaloferta;

    /**
     * @var float
     */
    private $dbofrvaladic;

    /**
     * @var \Libreame\BackendBundle\Entity\LbEjemplares
     */
    private $inofrejemplar;

    /**
     * @var \Libreame\BackendBundle\Entity\LbOfertas
     */
    private $inofroferta;


    /**
     * Get inofrecido
     *
     * @return integer 
     */
    public function getInofrecido()
    {
        return $this->id;
    }

    /**
     * Set inofrtransac
     *
     * @param integer $inofrtransac
     * @return LbOfrecidos
     */
    public function setInofrtransac($inofrtransac)
    {
        $this->inofrtransac = $inofrtransac;

        return $this;
    }

    /**
     * Get inofrtransac
     *
     * @return integer 
     */
    public function getInofrtransac()
    {
        return $this->inofrtransac;
    }

    /**
     * Set txofrobservacion
     *
     * @param string $txofrobservacion
     * @return LbOfrecidos
     */
    public function setTxofrobservacion($txofrobservacion)
    {
        $this->txofrobservacion = $txofrobservacion;

        return $this;
    }

    /**
     * Get txofrobservacion
     *
     * @return string 
     */
    public function getTxofrobservacion()
    {
        return $this->txofrobservacion;
    }

    /**
     * Set dbofrvaloferta
     *
     * @param float $dbofrvaloferta
     * @return LbOfrecidos
     */
    public function setDbofrvaloferta($dbofrvaloferta)
    {
        $this->dbofrvaloferta = $dbofrvaloferta;

        return $this;
    }

    /**
     * Get dbofrvaloferta
     *
     * @return float 
     */
    public function getDbofrvaloferta()
    {
        return $this->dbofrvaloferta;
    }

    /**
     * Set dbofrvaladic
     *
     * @param float $dbofrvaladic
     * @return LbOfrecidos
     */
    public function setDbofrvaladic($dbofrvaladic)
    {
        $this->dbofrvaladic = $dbofrvaladic;

        return $this;
    }

    /**
     * Get dbofrvaladic
     *
     * @return float 
     */
    public function getDbofrvaladic()
    {
        return $this->dbofrvaladic;
    }

    /**
     * Set inofrejemplar
     *
     * @param \Libreame\BackendBundle\Entity\LbEjemplares $inofrejemplar
     * @return LbOfrecidos
     */
    public function setInofrejemplar(\Libreame\BackendBundle\Entity\LbEjemplares $inofrejemplar = null)
    {
        $this->inofrejemplar = $inofrejemplar;

        return $this;
    }

    /**
     * Get inofrejemplar
     *
     * @return \Libreame\BackendBundle\Entity\LbEjemplares 
     */
    public function getInofrejemplar()
    {
        return $this->inofrejemplar;
    }

    /**
     * Set inofroferta
     *
     * @param \Libreame\BackendBundle\Entity\LbOfertas $inofroferta
     * @return LbOfrecidos
     */
    public function setInofroferta(\Libreame\BackendBundle\Entity\LbOfertas $inofroferta = null)
    {
        $this->inofroferta = $inofroferta;

        return $this;
    }

    /**
     * Get inofroferta
     *
     * @return \Libreame\BackendBundle\Entity\LbOfertas 
     */
    public function getInofroferta()
    {
        return $this->inofroferta;
    }
}
