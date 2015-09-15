<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbHistoriaejemplar
 *
 * @ORM\Table(name="lb_historiaejemplar", indexes={@ORM\Index(name="fk_lb_historiaejemplar_lb_ejemplares1_idx", columns={"inHEjEjemplar"}), @ORM\Index(name="fk_lb_historiaejemplar_lb_usuarios1_idx", columns={"inHEjUsuario"})})
 * @ORM\Entity
 */
class LbHistoriaejemplar
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inHistEjemplar", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $inhistejemplar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inHEjFechaHora", type="datetime", nullable=false)
     */
    protected $inhejfechahora;

    /**
     * @var integer
     *
     * @ORM\Column(name="inHEjModo", type="integer", nullable=false)
     */
    protected $inhejmodo;

    /**
     * @var \Libreame\BackendBundle\Entity\LbEjemplares
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbEjemplares")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inHEjEjemplar", referencedColumnName="inEjemplar")
     * })
     */
    protected $inhejejemplar;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inHEjUsuario", referencedColumnName="inUsuario")
     * })
     */
    protected $inhejusuario;



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
