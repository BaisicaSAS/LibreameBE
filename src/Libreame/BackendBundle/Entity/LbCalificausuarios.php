<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbCalificausuarios
 *
 * @ORM\Table(name="lb_calificausuarios", indexes={@ORM\Index(name="fk_table1_lb_usuarios2_idx", columns={"inCalUsuCalificado"}), @ORM\Index(name="fk_lb_calificausuarios_lb_usuarios3_idx", columns={"inCalUsuCalifica"}), @ORM\Index(name="fk_lb_calificausuarios_lb_histEjemplar1_idx", columns={"inCalHisEjemplar"})})
 * @ORM\Entity
 */
class LbCalificausuarios
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inIDCalifica", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inidcalifica;

    /**
     * @var integer
     *
     * @ORM\Column(name="inCalCalificacion", type="integer", nullable=false)
     */
    private $incalcalificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="txCalComentario", type="string", length=500, nullable=false)
     */
    private $txcalcomentario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feCalFecha", type="datetime", nullable=false)
     */
    private $fecalfecha;

    /**
     * @var \Libreame\BackendBundle\Entity\LbHistejemplar
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbHistejemplar")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inCalHisEjemplar", referencedColumnName="inHistEjemplar")
     * })
     */
    private $incalhisejemplar;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inCalUsuCalifica", referencedColumnName="inUsuario")
     * })
     */
    private $incalusucalifica;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inCalUsuCalificado", referencedColumnName="inUsuario")
     * })
     */
    private $incalusucalificado;



    /**
     * Get inidcalifica
     *
     * @return integer 
     */
    public function getInidcalifica()
    {
        return $this->inidcalifica;
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
     * Set txcalcomentario
     *
     * @param string $txcalcomentario
     * @return LbCalificausuarios
     */
    public function setTxcalcomentario($txcalcomentario)
    {
        $this->txcalcomentario = $txcalcomentario;

        return $this;
    }

    /**
     * Get txcalcomentario
     *
     * @return string 
     */
    public function getTxcalcomentario()
    {
        return $this->txcalcomentario;
    }

    /**
     * Set fecalfecha
     *
     * @param \DateTime $fecalfecha
     * @return LbCalificausuarios
     */
    public function setFecalfecha($fecalfecha)
    {
        $this->fecalfecha = $fecalfecha;

        return $this;
    }

    /**
     * Get fecalfecha
     *
     * @return \DateTime 
     */
    public function getFecalfecha()
    {
        return $this->fecalfecha;
    }

    /**
     * Set incalhisejemplar
     *
     * @param \Libreame\BackendBundle\Entity\LbHistejemplar $incalhisejemplar
     * @return LbCalificausuarios
     */
    public function setIncalhisejemplar(\Libreame\BackendBundle\Entity\LbHistejemplar $incalhisejemplar = null)
    {
        $this->incalhisejemplar = $incalhisejemplar;

        return $this;
    }

    /**
     * Get incalhisejemplar
     *
     * @return \Libreame\BackendBundle\Entity\LbHistejemplar 
     */
    public function getIncalhisejemplar()
    {
        return $this->incalhisejemplar;
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
