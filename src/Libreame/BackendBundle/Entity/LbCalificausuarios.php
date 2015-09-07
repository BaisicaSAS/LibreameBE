<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbCalificausuarios
 *
 * @ORM\Table(name="lb_calificausuarios", indexes={@ORM\Index(name="fk_lb_calificausuarios_lb_usuarios1_idx", columns={"inCalUsuCalifica"}), @ORM\Index(name="fk_lb_calificausuarios_lb_usuarios2_idx", columns={"inCalUsuCalificado"})})
 * @ORM\Entity
 */
class LbCalificausuarios
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inCalificacion", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $incalificacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="inCalCalificacion", type="integer", nullable=false)
     */
    protected $incalcalificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="txCalObservacion", type="string", length=100, nullable=true)
     */
    protected $txcalobservacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="inCalReporteAbuso", type="integer", nullable=false)
     */
    protected $incalreporteabuso;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inCalUsuCalifica", referencedColumnName="inUsuario")
     * })
     */
    protected $incalusucalifica;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inCalUsuCalificado", referencedColumnName="inUsuario")
     * })
     */
    protected $incalusucalificado;



    /**
     * Get incalificacion
     *
     * @return integer 
     */
    public function getIncalificacion()
    {
        return $this->incalificacion;
    }

    /**
     * Set incalcalificacion
     *
     * @param integer $incalcalificacion
     * @return LbCalificausuarios
     */
    public function setIncalcalificacion($incalcalificacion)
    {
        $this->incalcalificacion = $incalcalificacion;

        return $this;
    }

    /**
     * Get incalcalificacion
     *
     * @return integer 
     */
    public function getIncalcalificacion()
    {
        return $this->incalcalificacion;
    }

    /**
     * Set txcalobservacion
     *
     * @param string $txcalobservacion
     * @return LbCalificausuarios
     */
    public function setTxcalobservacion($txcalobservacion)
    {
        $this->txcalobservacion = $txcalobservacion;

        return $this;
    }

    /**
     * Get txcalobservacion
     *
     * @return string 
     */
    public function getTxcalobservacion()
    {
        return $this->txcalobservacion;
    }

    /**
     * Set incalreporteabuso
     *
     * @param integer $incalreporteabuso
     * @return LbCalificausuarios
     */
    public function setIncalreporteabuso($incalreporteabuso)
    {
        $this->incalreporteabuso = $incalreporteabuso;

        return $this;
    }

    /**
     * Get incalreporteabuso
     *
     * @return integer 
     */
    public function getIncalreporteabuso()
    {
        return $this->incalreporteabuso;
    }

    /**
     * Set incalusucalifica
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $incalusucalifica
     * @return LbCalificausuarios
     */
    public function setIncalusucalifica(\Libreame\BackendBundle\Entity\LbUsuarios $incalusucalifica = null)
    {
        $this->incalusucalifica = $incalusucalifica;

        return $this;
    }

    /**
     * Get incalusucalifica
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getIncalusucalifica()
    {
        return $this->incalusucalifica;
    }

    /**
     * Set incalusucalificado
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $incalusucalificado
     * @return LbCalificausuarios
     */
    public function setIncalusucalificado(\Libreame\BackendBundle\Entity\LbUsuarios $incalusucalificado = null)
    {
        $this->incalusucalificado = $incalusucalificado;

        return $this;
    }

    /**
     * Get incalusucalificado
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getIncalusucalificado()
    {
        return $this->incalusucalificado;
    }
}
