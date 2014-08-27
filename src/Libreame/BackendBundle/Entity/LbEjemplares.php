<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbEjemplares
 */
class LbEjemplares
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $inejecantidad;

    /**
     * @var float
     */
    private $dbejeavaluo;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     */
    private $inejeusudueno;

    /**
     * @var \Libreame\BackendBundle\Entity\LbLibros
     */
    private $inejelibro;

    /**
     * @var \Libreame\BackendBundle\Entity\LbGeneros
     */
    private $inejegenero;


    /**
     * Get inejemplar
     *
     * @return integer 
     */
    public function getInejemplar()
    {
        return $this->id;
    }

    /**
     * Set inejecantidad
     *
     * @param integer $inejecantidad
     * @return LbEjemplares
     */
    public function setInejecantidad($inejecantidad)
    {
        $this->inejecantidad = $inejecantidad;

        return $this;
    }

    /**
     * Get inejecantidad
     *
     * @return integer 
     */
    public function getInejecantidad()
    {
        return $this->inejecantidad;
    }

    /**
     * Set dbejeavaluo
     *
     * @param float $dbejeavaluo
     * @return LbEjemplares
     */
    public function setDbejeavaluo($dbejeavaluo)
    {
        $this->dbejeavaluo = $dbejeavaluo;

        return $this;
    }

    /**
     * Get dbejeavaluo
     *
     * @return float 
     */
    public function getDbejeavaluo()
    {
        return $this->dbejeavaluo;
    }

    /**
     * Set inejeusudueno
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inejeusudueno
     * @return LbEjemplares
     */
    public function setInejeusudueno(\Libreame\BackendBundle\Entity\LbUsuarios $inejeusudueno = null)
    {
        $this->inejeusudueno = $inejeusudueno;

        return $this;
    }

    /**
     * Get inejeusudueno
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInejeusudueno()
    {
        return $this->inejeusudueno;
    }

    /**
     * Set inejelibro
     *
     * @param \Libreame\BackendBundle\Entity\LbLibros $inejelibro
     * @return LbEjemplares
     */
    public function setInejelibro(\Libreame\BackendBundle\Entity\LbLibros $inejelibro = null)
    {
        $this->inejelibro = $inejelibro;

        return $this;
    }

    /**
     * Get inejelibro
     *
     * @return \Libreame\BackendBundle\Entity\LbLibros 
     */
    public function getInejelibro()
    {
        return $this->inejelibro;
    }

    /**
     * Set inejegenero
     *
     * @param \Libreame\BackendBundle\Entity\LbGeneros $inejegenero
     * @return LbEjemplares
     */
    public function setInejegenero(\Libreame\BackendBundle\Entity\LbGeneros $inejegenero = null)
    {
        $this->inejegenero = $inejegenero;

        return $this;
    }

    /**
     * Get inejegenero
     *
     * @return \Libreame\BackendBundle\Entity\LbGeneros 
     */
    public function getInejegenero()
    {
        return $this->inejegenero;
    }
}
