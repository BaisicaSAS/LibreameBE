<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbPuntosusuario
 *
 * @ORM\Table(name="lb_puntosusuario", indexes={@ORM\Index(name="fk_lb_puntosusuario_lb_usuarios1_idx", columns={"inPuUsUsuario"}), @ORM\Index(name="fk_lb_puntosusuario_lb_histEjemplar1_idx", columns={"inPuUsHisEje"})})
 * @ORM\Entity
 */
class LbPuntosusuario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inIDPuUs", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inidpuus;

    /**
     * @var integer
     *
     * @ORM\Column(name="inPuUsCantPuntos", type="integer", nullable=false)
     */
    private $inpuuscantpuntos;

    /**
     * @var string
     *
     * @ORM\Column(name="txPuUsMotivo", type="string", length=250, nullable=false)
     */
    private $txpuusmotivo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fePuUsFechaPuntos", type="datetime", nullable=false)
     */
    private $fepuusfechapuntos;

    /**
     * @var \Libreame\BackendBundle\Entity\LbHistejemplar
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbHistejemplar")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inPuUsHisEje", referencedColumnName="inHistEjemplar")
     * })
     */
    private $inpuushiseje;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inPuUsUsuario", referencedColumnName="inUsuario")
     * })
     */
    private $inpuususuario;



    /**
     * Get inidpuus
     *
     * @return integer 
     */
    public function getInidpuus()
    {
        return $this->inidpuus;
    }

    /**
     * Set inpuuscantpuntos
     *
     * @param integer $inpuuscantpuntos
     * @return LbPuntosusuario
     */
    public function setInpuuscantpuntos($inpuuscantpuntos)
    {
        $this->inpuuscantpuntos = $inpuuscantpuntos;

        return $this;
    }

    /**
     * Get inpuuscantpuntos
     *
     * @return integer 
     */
    public function getInpuuscantpuntos()
    {
        return $this->inpuuscantpuntos;
    }

    /**
     * Set txpuusmotivo
     *
     * @param string $txpuusmotivo
     * @return LbPuntosusuario
     */
    public function setTxpuusmotivo($txpuusmotivo)
    {
        $this->txpuusmotivo = $txpuusmotivo;

        return $this;
    }

    /**
     * Get txpuusmotivo
     *
     * @return string 
     */
    public function getTxpuusmotivo()
    {
        return $this->txpuusmotivo;
    }

    /**
     * Set fepuusfechapuntos
     *
     * @param \DateTime $fepuusfechapuntos
     * @return LbPuntosusuario
     */
    public function setFepuusfechapuntos($fepuusfechapuntos)
    {
        $this->fepuusfechapuntos = $fepuusfechapuntos;

        return $this;
    }

    /**
     * Get fepuusfechapuntos
     *
     * @return \DateTime 
     */
    public function getFepuusfechapuntos()
    {
        return $this->fepuusfechapuntos;
    }

    /**
     * Set inpuushiseje
     *
     * @param \Libreame\BackendBundle\Entity\LbHistejemplar $inpuushiseje
     * @return LbPuntosusuario
     */
    public function setInpuushiseje(\Libreame\BackendBundle\Entity\LbHistejemplar $inpuushiseje = null)
    {
        $this->inpuushiseje = $inpuushiseje;

        return $this;
    }

    /**
     * Get inpuushiseje
     *
     * @return \Libreame\BackendBundle\Entity\LbHistejemplar 
     */
    public function getInpuushiseje()
    {
        return $this->inpuushiseje;
    }

    /**
     * Set inpuususuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inpuususuario
     * @return LbPuntosusuario
     */
    public function setInpuususuario(\Libreame\BackendBundle\Entity\LbUsuarios $inpuususuario = null)
    {
        $this->inpuususuario = $inpuususuario;

        return $this;
    }

    /**
     * Get inpuususuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInpuususuario()
    {
        return $this->inpuususuario;
    }
}
