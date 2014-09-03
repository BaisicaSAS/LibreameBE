<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbHistoriaejemplar
 */
class LbHistoriaejemplar
{
    /**
     * @var integer
     */
    private $inhistejemplar;

    /**
     * @var \DateTime
     */
    private $inhejfechahora;

    /**
     * @var integer
     */
    private $inhejmodo;

    /**
     * @var \Libreame\BackendBundle\Entity\LbEjemplares
     */
    private $inhejejemplar;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     */
    private $inhejusuario;


    /**
     * Get inhistejemplar
     *
     * @return integer 
     */
    public function getInhistejemplar()
    {
        return $this->inhistejemplar;
    }

    /**
     * Set inhejfechahora
     *
     * @param \DateTime $inhejfechahora
     * @return LbHistoriaejemplar
     */
    public function setInhejfechahora($inhejfechahora)
    {
        $this->inhejfechahora = $inhejfechahora;

        return $this;
    }

    /**
     * Get inhejfechahora
     *
     * @return \DateTime 
     */
    public function getInhejfechahora()
    {
        return $this->inhejfechahora;
    }

    /**
     * Set inhejmodo
     *
     * @param integer $inhejmodo
     * @return LbHistoriaejemplar
     */
    public function setInhejmodo($inhejmodo)
    {
        $this->inhejmodo = $inhejmodo;

        return $this;
    }

    /**
     * Get inhejmodo
     *
     * @return integer 
     */
    public function getInhejmodo()
    {
        return $this->inhejmodo;
    }

    /**
     * Set inhejejemplar
     *
     * @param \Libreame\BackendBundle\Entity\LbEjemplares $inhejejemplar
     * @return LbHistoriaejemplar
     */
    public function setInhejejemplar(\Libreame\BackendBundle\Entity\LbEjemplares $inhejejemplar = null)
    {
        $this->inhejejemplar = $inhejejemplar;

        return $this;
    }

    /**
     * Get inhejejemplar
     *
     * @return \Libreame\BackendBundle\Entity\LbEjemplares 
     */
    public function getInhejejemplar()
    {
        return $this->inhejejemplar;
    }

    /**
     * Set inhejusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inhejusuario
     * @return LbHistoriaejemplar
     */
    public function setInhejusuario(\Libreame\BackendBundle\Entity\LbUsuarios $inhejusuario = null)
    {
        $this->inhejusuario = $inhejusuario;

        return $this;
    }

    /**
     * Get inhejusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInhejusuario()
    {
        return $this->inhejusuario;
    }
}
