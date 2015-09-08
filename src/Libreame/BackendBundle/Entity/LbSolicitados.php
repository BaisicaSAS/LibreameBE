<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbSolicitados
 *
 * @ORM\Table(name="lb_solicitados", indexes={@ORM\Index(name="fk_lb_solicitados_lb_ejemplares1_idx", columns={"inSolEjemplar"}), @ORM\Index(name="fk_lb_solicitados_lb_ofertas1_idx", columns={"inSolOferta"}), @ORM\Index(name="fk_lb_solicitados_lb_libros1_idx", columns={"inSolLibro"})})
 * @ORM\Entity
 */
class LbSolicitados
{
    /**
     * @var integer
     *
     * @ORM\Column(name="IdSolicitado", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $idsolicitado;

    /**
     * @var integer
     *
     * @ORM\Column(name="inSolTransac", type="integer", nullable=false)
     */
    protected $insoltransac;

    /**
     * @var string
     *
     * @ORM\Column(name="txSolObservacion", type="string", length=100, nullable=true)
     */
    protected $txsolobservacion;

    /**
     * @var float
     *
     * @ORM\Column(name="dbSolValOferta", type="float", precision=10, scale=0, nullable=false)
     */
    protected $dbsolvaloferta;

    /**
     * @var float
     *
     * @ORM\Column(name="dbSolValAdic", type="float", precision=10, scale=0, nullable=false)
     */
    protected $dbsolvaladic;

    /**
     * @var \Libreame\BackendBundle\Entity\LbEjemplares
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbEjemplares")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inSolEjemplar", referencedColumnName="inEjemplar")
     * })
     */
    protected $insolejemplar;

    /**
     * @var \Libreame\BackendBundle\Entity\LbLibros
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbLibros")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inSolLibro", referencedColumnName="inLibro")
     * })
     */
    protected $insollibro;

    /**
     * @var \Libreame\BackendBundle\Entity\LbOfertas
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbOfertas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inSolOferta", referencedColumnName="inOferta")
     * })
     */
    protected $insoloferta;



    /**
     * Get idsolicitado
     *
     * @return integer 
     */
    public function getIdsolicitado()
    {
        return $this->idsolicitado;
    }

    /**
     * Set insoltransac
     *
     * @param integer $insoltransac
     * @return LbSolicitados
     */
    public function setInsoltransac($insoltransac)
    {
        $this->insoltransac = $insoltransac;

        return $this;
    }

    /**
     * Get insoltransac
     *
     * @return integer 
     */
    public function getInsoltransac()
    {
        return $this->insoltransac;
    }

    /**
     * Set txsolobservacion
     *
     * @param string $txsolobservacion
     * @return LbSolicitados
     */
    public function setTxsolobservacion($txsolobservacion)
    {
        $this->txsolobservacion = $txsolobservacion;

        return $this;
    }

    /**
     * Get txsolobservacion
     *
     * @return string 
     */
    public function getTxsolobservacion()
    {
        return $this->txsolobservacion;
    }

    /**
     * Set dbsolvaloferta
     *
     * @param float $dbsolvaloferta
     * @return LbSolicitados
     */
    public function setDbsolvaloferta($dbsolvaloferta)
    {
        $this->dbsolvaloferta = $dbsolvaloferta;

        return $this;
    }

    /**
     * Get dbsolvaloferta
     *
     * @return float 
     */
    public function getDbsolvaloferta()
    {
        return $this->dbsolvaloferta;
    }

    /**
     * Set dbsolvaladic
     *
     * @param float $dbsolvaladic
     * @return LbSolicitados
     */
    public function setDbsolvaladic($dbsolvaladic)
    {
        $this->dbsolvaladic = $dbsolvaladic;

        return $this;
    }

    /**
     * Get dbsolvaladic
     *
     * @return float 
     */
    public function getDbsolvaladic()
    {
        return $this->dbsolvaladic;
    }

    /**
     * Set insolejemplar
     *
     * @param \Libreame\BackendBundle\Entity\LbEjemplares $insolejemplar
     * @return LbSolicitados
     */
    public function setInsolejemplar(\Libreame\BackendBundle\Entity\LbEjemplares $insolejemplar = null)
    {
        $this->insolejemplar = $insolejemplar;

        return $this;
    }

    /**
     * Get insolejemplar
     *
     * @return \Libreame\BackendBundle\Entity\LbEjemplares 
     */
    public function getInsolejemplar()
    {
        return $this->insolejemplar;
    }

    /**
     * Set insollibro
     *
     * @param \Libreame\BackendBundle\Entity\LbLibros $insollibro
     * @return LbSolicitados
     */
    public function setInsollibro(\Libreame\BackendBundle\Entity\LbLibros $insollibro = null)
    {
        $this->insollibro = $insollibro;

        return $this;
    }

    /**
     * Get insollibro
     *
     * @return \Libreame\BackendBundle\Entity\LbLibros 
     */
    public function getInsollibro()
    {
        return $this->insollibro;
    }

    /**
     * Set insoloferta
     *
     * @param \Libreame\BackendBundle\Entity\LbOfertas $insoloferta
     * @return LbSolicitados
     */
    public function setInsoloferta(\Libreame\BackendBundle\Entity\LbOfertas $insoloferta = null)
    {
        $this->insoloferta = $insoloferta;

        return $this;
    }

    /**
     * Get insoloferta
     *
     * @return \Libreame\BackendBundle\Entity\LbOfertas 
     */
    public function getInsoloferta()
    {
        return $this->insoloferta;
    }
}
