<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbTareas
 */
class LbTareas
{
    /**
     * @var integer
     */
    private $intarea;

    /**
     * @var \DateTime
     */
    private $fefechatarea;

    /**
     * @var \DateTime
     */
    private $fefechafinalizada;

    /**
     * @var integer
     */
    private $intipotarea;

    /**
     * @var integer
     */
    private $inestadotarea;

    /**
     * @var float
     */
    private $dbvalorejesugerido;

    /**
     * @var integer
     */
    private $inaprobadovaloreje;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     */
    private $inusuariotareaasi;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     */
    private $inusuariotareades;

    /**
     * @var \Libreame\BackendBundle\Entity\LbEjemplares
     */
    private $inejemplartareades;


    /**
     * Get intarea
     *
     * @return integer 
     */
    public function getIntarea()
    {
        return $this->intarea;
    }

    /**
     * Set fefechatarea
     *
     * @param \DateTime $fefechatarea
     * @return LbTareas
     */
    public function setFefechatarea($fefechatarea)
    {
        $this->fefechatarea = $fefechatarea;

        return $this;
    }

    /**
     * Get fefechatarea
     *
     * @return \DateTime 
     */
    public function getFefechatarea()
    {
        return $this->fefechatarea;
    }

    /**
     * Set fefechafinalizada
     *
     * @param \DateTime $fefechafinalizada
     * @return LbTareas
     */
    public function setFefechafinalizada($fefechafinalizada)
    {
        $this->fefechafinalizada = $fefechafinalizada;

        return $this;
    }

    /**
     * Get fefechafinalizada
     *
     * @return \DateTime 
     */
    public function getFefechafinalizada()
    {
        return $this->fefechafinalizada;
    }

    /**
     * Set intipotarea
     *
     * @param integer $intipotarea
     * @return LbTareas
     */
    public function setIntipotarea($intipotarea)
    {
        $this->intipotarea = $intipotarea;

        return $this;
    }

    /**
     * Get intipotarea
     *
     * @return integer 
     */
    public function getIntipotarea()
    {
        return $this->intipotarea;
    }

    /**
     * Set inestadotarea
     *
     * @param integer $inestadotarea
     * @return LbTareas
     */
    public function setInestadotarea($inestadotarea)
    {
        $this->inestadotarea = $inestadotarea;

        return $this;
    }

    /**
     * Get inestadotarea
     *
     * @return integer 
     */
    public function getInestadotarea()
    {
        return $this->inestadotarea;
    }

    /**
     * Set dbvalorejesugerido
     *
     * @param float $dbvalorejesugerido
     * @return LbTareas
     */
    public function setDbvalorejesugerido($dbvalorejesugerido)
    {
        $this->dbvalorejesugerido = $dbvalorejesugerido;

        return $this;
    }

    /**
     * Get dbvalorejesugerido
     *
     * @return float 
     */
    public function getDbvalorejesugerido()
    {
        return $this->dbvalorejesugerido;
    }

    /**
     * Set inaprobadovaloreje
     *
     * @param integer $inaprobadovaloreje
     * @return LbTareas
     */
    public function setInaprobadovaloreje($inaprobadovaloreje)
    {
        $this->inaprobadovaloreje = $inaprobadovaloreje;

        return $this;
    }

    /**
     * Get inaprobadovaloreje
     *
     * @return integer 
     */
    public function getInaprobadovaloreje()
    {
        return $this->inaprobadovaloreje;
    }

    /**
     * Set inusuariotareaasi
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inusuariotareaasi
     * @return LbTareas
     */
    public function setInusuariotareaasi(\Libreame\BackendBundle\Entity\LbUsuarios $inusuariotareaasi = null)
    {
        $this->inusuariotareaasi = $inusuariotareaasi;

        return $this;
    }

    /**
     * Get inusuariotareaasi
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInusuariotareaasi()
    {
        return $this->inusuariotareaasi;
    }

    /**
     * Set inusuariotareades
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inusuariotareades
     * @return LbTareas
     */
    public function setInusuariotareades(\Libreame\BackendBundle\Entity\LbUsuarios $inusuariotareades = null)
    {
        $this->inusuariotareades = $inusuariotareades;

        return $this;
    }

    /**
     * Get inusuariotareades
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInusuariotareades()
    {
        return $this->inusuariotareades;
    }

    /**
     * Set inejemplartareades
     *
     * @param \Libreame\BackendBundle\Entity\LbEjemplares $inejemplartareades
     * @return LbTareas
     */
    public function setInejemplartareades(\Libreame\BackendBundle\Entity\LbEjemplares $inejemplartareades = null)
    {
        $this->inejemplartareades = $inejemplartareades;

        return $this;
    }

    /**
     * Get inejemplartareades
     *
     * @return \Libreame\BackendBundle\Entity\LbEjemplares 
     */
    public function getInejemplartareades()
    {
        return $this->inejemplartareades;
    }
}
