<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbActividadofertas
 *
 * @ORM\Table(name="lb_actividadofertas", indexes={@ORM\Index(name="fk_lb_ActividadOfertas_lb_usuarios1_idx", columns={"inActUsuario"}), @ORM\Index(name="fk_lb_ActividadOfertas_lb_ofertas1_idx", columns={"inActOferta"}), @ORM\Index(name="fk_lb_ActividadOfertas_lb_ActividadOfertas1_idx", columns={"inActPadreAct"})})
 * @ORM\Entity
 */
class LbActividadofertas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inActividadOferta", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $inactividadoferta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feActFechaHora", type="datetime", nullable=false)
     */
    protected $feactfechahora;

    /**
     * @var string
     *
     * @ORM\Column(name="txActDescripcion", type="string", length=300, nullable=true)
     */
    protected $txactdescripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="inActEstado", type="integer", nullable=true)
     */
    protected $inactestado = '0';

    /**
     * @var \LbActividadofertas
     *
     * @ORM\ManyToOne(targetEntity="LbActividadofertas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inActPadreAct", referencedColumnName="inActividadOferta")
     * })
     */
    protected $inactpadreact;

    /**
     * @var \LbOfertas
     *
     * @ORM\ManyToOne(targetEntity="LbOfertas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inActOferta", referencedColumnName="inOferta")
     * })
     */
    protected $inactoferta;

    /**
     * @var \LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inActUsuario", referencedColumnName="inUsuario")
     * })
     */
    protected $inactusuario;



    /**
     * Get inactividadoferta
     *
     * @return integer 
     */
    public function getInactividadoferta()
    {
        return $this->inactividadoferta;
    }

    /**
     * Set feactfechahora
     *
     * @param \DateTime $feactfechahora
     * @return LbActividadofertas
     */
    public function setFeactfechahora($feactfechahora)
    {
        $this->feactfechahora = $feactfechahora;

        return $this;
    }

    /**
     * Get feactfechahora
     *
     * @return \DateTime 
     */
    public function getFeactfechahora()
    {
        return $this->feactfechahora;
    }

    /**
     * Set txactdescripcion
     *
     * @param string $txactdescripcion
     * @return LbActividadofertas
     */
    public function setTxactdescripcion($txactdescripcion)
    {
        $this->txactdescripcion = $txactdescripcion;

        return $this;
    }

    /**
     * Get txactdescripcion
     *
     * @return string 
     */
    public function getTxactdescripcion()
    {
        return $this->txactdescripcion;
    }

    /**
     * Set inactestado
     *
     * @param integer $inactestado
     * @return LbActividadofertas
     */
    public function setInactestado($inactestado)
    {
        $this->inactestado = $inactestado;

        return $this;
    }

    /**
     * Get inactestado
     *
     * @return integer 
     */
    public function getInactestado()
    {
        return $this->inactestado;
    }

    /**
     * Set inactpadreact
     *
     * @param \Libreame\BackendBundle\Entity\LbActividadofertas $inactpadreact
     * @return LbActividadofertas
     */
    public function setInactpadreact(\Libreame\BackendBundle\Entity\LbActividadofertas $inactpadreact = null)
    {
        $this->inactpadreact = $inactpadreact;

        return $this;
    }

    /**
     * Get inactpadreact
     *
     * @return \Libreame\BackendBundle\Entity\LbActividadofertas 
     */
    public function getInactpadreact()
    {
        return $this->inactpadreact;
    }

    /**
     * Set inactoferta
     *
     * @param \Libreame\BackendBundle\Entity\LbOfertas $inactoferta
     * @return LbActividadofertas
     */
    public function setInactoferta(\Libreame\BackendBundle\Entity\LbOfertas $inactoferta = null)
    {
        $this->inactoferta = $inactoferta;

        return $this;
    }

    /**
     * Get inactoferta
     *
     * @return \Libreame\BackendBundle\Entity\LbOfertas 
     */
    public function getInactoferta()
    {
        return $this->inactoferta;
    }

    /**
     * Set inactusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inactusuario
     * @return LbActividadofertas
     */
    public function setInactusuario(\Libreame\BackendBundle\Entity\LbUsuarios $inactusuario = null)
    {
        $this->inactusuario = $inactusuario;

        return $this;
    }

    /**
     * Get inactusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInactusuario()
    {
        return $this->inactusuario;
    }
}
