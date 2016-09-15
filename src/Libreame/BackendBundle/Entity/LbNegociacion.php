<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbNegociacion
 *
 * @ORM\Table(name="lb_negociacion", indexes={@ORM\Index(name="fk_lb_negociacion_lb_ejemplares1_idx", columns={"inNegEjemplar"}), @ORM\Index(name="fk_lb_negociacion_lb_usuarios1_idx", columns={"inNegUsuDuenho"}), @ORM\Index(name="fk_lb_negociacion_lb_usuarios2_idx", columns={"inNegUsuSolicita"}), @ORM\Index(name="fk_lb_negociacion_lb_usuarios3_idx", columns={"inNegUsuEscribe"})})
 * @ORM\Entity
 */
class LbNegociacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inIDNegociacion", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inidnegociacion;

    /**
     * @var string
     *
     * @ORM\Column(name="txNegMensaje", type="text", nullable=false)
     */
    private $txnegmensaje;

    /**
     * @var integer
     *
     * @ORM\Column(name="inNegMensLeidoSol", type="integer", nullable=false)
     */
    private $innegmensleidosol;

    /**
     * @var integer
     *
     * @ORM\Column(name="inNegMensLeidoDue", type="integer", nullable=false)
     */
    private $innegmensleidodue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feNegFechaMens", type="datetime", nullable=false)
     */
    private $fenegfechamens;

    /**
     * @var integer
     *
     * @ORM\Column(name="inNegMensEliminado", type="integer", nullable=true)
     */
    private $innegmenseliminado;

    /**
     * @var \Libreame\BackendBundle\Entity\LbEjemplares
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbEjemplares")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inNegEjemplar", referencedColumnName="inEjemplar")
     * })
     */
    private $innegejemplar;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inNegUsuDuenho", referencedColumnName="inUsuario")
     * })
     */
    private $innegusuduenho;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inNegUsuSolicita", referencedColumnName="inUsuario")
     * })
     */
    private $innegususolicita;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inNegUsuEscribe", referencedColumnName="inUsuario")
     * })
     */
    private $innegusuescribe;

    /**
     * @var string
     *
     * @ORM\Column(name="txNegIdConversacion",  type="string", length=50, nullable=false)
     */
    private $txnegidconversacion;

    /**
     * Get inidnegociacion
     *
     * @return integer 
     */
    public function getInidnegociacion()
    {
        return $this->inidnegociacion;
    }

    /**
     * Set txnegmensaje
     *
     * @param string $txnegmensaje
     * @return LbNegociacion
     */
    public function setTxnegmensaje($txnegmensaje)
    {
        $this->txnegmensaje = $txnegmensaje;

        return $this;
    }

    /**
     * Get txnegmensaje
     *
     * @return string 
     */
    public function getTxnegmensaje()
    {
        return $this->txnegmensaje;
    }

    /**
     * Set innegmensleidosol
     *
     * @param integer $innegmensleidosol
     * @return LbNegociacion
     */
    public function setInnegmensleidosol($innegmensleidosol)
    {
        $this->innegmensleidosol = $innegmensleidosol;

        return $this;
    }

    /**
     * Get innegmensleidosol
     *
     * @return integer 
     */
    public function getInnegmensleidosol()
    {
        return $this->innegmensleidosol;
    }

    /**
     * Set innegmensleidodue
     *
     * @param integer $innegmensleidodue
     * @return LbNegociacion
     */
    public function setInnegmensleidodue($innegmensleidodue)
    {
        $this->innegmensleidodue = $innegmensleidodue;

        return $this;
    }

        /**
     * Get innegmensleidodue
     *
     * @return integer 
     */
    public function getInnegmensleidodue()
    {
        return $this->innegmensleidodue;
    }


    /**
     * Set fenegfechamens
     *
     * @param \DateTime $fenegfechamens
     * @return LbNegociacion
     */
    public function setFenegfechamens($fenegfechamens)
    {
        $this->fenegfechamens = $fenegfechamens;

        return $this;
    }

    /**
     * Get fenegfechamens
     *
     * @return \DateTime 
     */
    public function getFenegfechamens()
    {
        return $this->fenegfechamens;
    }

    /**
     * Set innegmenseliminado
     *
     * @param integer $innegmenseliminado
     * @return LbNegociacion
     */
    public function setInnegmenseliminado($innegmenseliminado)
    {
        $this->innegmenseliminado = $innegmenseliminado;

        return $this;
    }

    /**
     * Get innegmenseliminado
     *
     * @return integer 
     */
    public function getInnegmenseliminado()
    {
        return $this->innegmenseliminado;
    }

    /**
     * Set innegejemplar
     *
     * @param \Libreame\BackendBundle\Entity\LbEjemplares $innegejemplar
     * @return LbNegociacion
     */
    public function setInnegejemplar(\Libreame\BackendBundle\Entity\LbEjemplares $innegejemplar = null)
    {
        $this->innegejemplar = $innegejemplar;

        return $this;
    }

    /**
     * Get innegejemplar
     *
     * @return \Libreame\BackendBundle\Entity\LbEjemplares 
     */
    public function getInnegejemplar()
    {
        return $this->innegejemplar;
    }

    /**
     * Set innegusuduenho
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $innegusuduenho
     * @return LbNegociacion
     */
    public function setInnegusuduenho(\Libreame\BackendBundle\Entity\LbUsuarios $innegusuduenho = null)
    {
        $this->innegusuduenho = $innegusuduenho;

        return $this;
    }

    /**
     * Get innegusuduenho
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInnegusuduenho()
    {
        return $this->innegusuduenho;
    }

    /**
     * Set innegususolicita
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $innegususolicita
     * @return LbNegociacion
     */
    public function setInnegususolicita(\Libreame\BackendBundle\Entity\LbUsuarios $innegususolicita = null)
    {
        $this->innegususolicita = $innegususolicita;

        return $this;
    }

    /**
     * Get innegususolicita
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInnegususolicita()
    {
        return $this->innegususolicita;
    }

    /**
     * Set innegusuescribe
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $innegusuescribe
     * @return LbNegociacion
     */
    public function setInnegusuescribe(\Libreame\BackendBundle\Entity\LbUsuarios $innegusuescribe = null)
    {
        $this->innegusuescribe = $innegusuescribe;

        return $this;
    }

    /**
     * Get innegusuescribe
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInnegusuescribe()
    {
        return $this->innegusuescribe;
    }
    
    /**
     * Set txnegidconversacion
     *
     * @param string $txnegidconversacion
     * @return LbNegociacion
     */
    public function setTxnegidconversacion($txnegidconversacion)
    {
        $this->txnegidconversacion = $txnegidconversacion;

        return $this;
    }

    /**
     * Get txnegidconversacion
     *
     * @return string 
     */
    public function getTxnegidconversacion()
    {
        return $this->txnegidconversacion;
    }

    
}
