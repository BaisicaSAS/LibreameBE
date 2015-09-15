<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbOfrecidos
 *
 * @ORM\Table(name="lb_ofrecidos", indexes={@ORM\Index(name="fk_lb_ofrecidos_lb_ejemplares1_idx", columns={"inOfrEjemplar"}), @ORM\Index(name="fk_lb_ofrecidos_lb_ofertas1_idx", columns={"inOfrOferta"})})
 * @ORM\Entity
 */
class LbOfrecidos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inOfrecido", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $inofrecido;

    /**
     * @var integer
     *
     * @ORM\Column(name="inOfrTransac", type="integer", nullable=false)
     */
    protected $inofrtransac;

    /**
     * @var string
     *
     * @ORM\Column(name="txOfrObservacion", type="string", length=100, nullable=true)
     */
    protected $txofrobservacion;

    /**
     * @var float
     *
     * @ORM\Column(name="dbOfrValOferta", type="float", precision=10, scale=0, nullable=false)
     */
    protected $dbofrvaloferta;

    /**
     * @var float
     *
     * @ORM\Column(name="dbOfrValAdic", type="float", precision=10, scale=0, nullable=false)
     */
    protected $dbofrvaladic;

    /**
     * @var \Libreame\BackendBundle\Entity\LbEjemplares
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbEjemplares")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inOfrEjemplar", referencedColumnName="inEjemplar")
     * })
     */
    protected $inofrejemplar;

    /**
     * @var \Libreame\BackendBundle\Entity\LbOfertas
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbOfertas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inOfrOferta", referencedColumnName="inOferta")
     * })
     */
    protected $inofroferta;



    /**
     * Get inofrecido
     *
     * @return integer 
     */
    public function getInofrecido()
    {
        return $this->inofrecido;
    }

    /**
     * Set inofrtransac
     *
     * @param integer $inofrtransac
     * @return LbOfrecidos
     */
    public function setInofrtransac($inofrtransac)
    {
        $this->inofrtransac = $inofrtransac;

        return $this;
    }

    /**
     * Get inofrtransac
     *
     * @return integer 
     */
    public function getInofrtransac()
    {
        return $this->inofrtransac;
    }

    /**
     * Set txofrobservacion
     *
     * @param string $txofrobservacion
     * @return LbOfrecidos
     */
    public function setTxofrobservacion($txofrobservacion)
    {
        $this->txofrobservacion = $txofrobservacion;

        return $this;
    }

    /**
     * Get txofrobservacion
     *
     * @return string 
     */
    public function getTxofrobservacion()
    {
        return $this->txofrobservacion;
    }

    /**
     * Set dbofrvaloferta
     *
     * @param float $dbofrvaloferta
     * @return LbOfrecidos
     */
    public function setDbofrvaloferta($dbofrvaloferta)
    {
        $this->dbofrvaloferta = $dbofrvaloferta;

        return $this;
    }

    /**
     * Get dbofrvaloferta
     *
     * @return float 
     */
    public function getDbofrvaloferta()
    {
        return $this->dbofrvaloferta;
    }

    /**
     * Set dbofrvaladic
     *
     * @param float $dbofrvaladic
     * @return LbOfrecidos
     */
    public function setDbofrvaladic($dbofrvaladic)
    {
        $this->dbofrvaladic = $dbofrvaladic;

        return $this;
    }

    /**
     * Get dbofrvaladic
     *
     * @return float 
     */
    public function getDbofrvaladic()
    {
        return $this->dbofrvaladic;
    }

    /**
     * Set inofrejemplar
     *
     * @param \Libreame\BackendBundle\Entity\LbEjemplares $inofrejemplar
     * @return LbOfrecidos
     */
    public function setInofrejemplar(\Libreame\BackendBundle\Entity\LbEjemplares $inofrejemplar = null)
    {
        $this->inofrejemplar = $inofrejemplar;

        return $this;
    }

    /**
     * Get inofrejemplar
     *
     * @return \Libreame\BackendBundle\Entity\LbEjemplares 
     */
    public function getInofrejemplar()
    {
        return $this->inofrejemplar;
    }

    /**
     * Set inofroferta
     *
     * @param \Libreame\BackendBundle\Entity\LbOfertas $inofroferta
     * @return LbOfrecidos
     */
    public function setInofroferta(\Libreame\BackendBundle\Entity\LbOfertas $inofroferta = null)
    {
        $this->inofroferta = $inofroferta;

        return $this;
    }

    /**
     * Get inofroferta
     *
     * @return \Libreame\BackendBundle\Entity\LbOfertas 
     */
    public function getInofroferta()
    {
        return $this->inofroferta;
    }
}
