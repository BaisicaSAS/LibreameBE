<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbOfertas
 *
 * @ORM\Table(name="lb_ofertas", indexes={@ORM\Index(name="fk_lb_ofertas_lb_membresias1_idx", columns={"inOfeMembresia"})})
 * @ORM\Entity
 */
class LbOfertas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inOferta", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $inoferta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feOfeFecha", type="datetime", nullable=false)
     */
    protected $feofefecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="inOfeVigencia", type="integer", nullable=false)
     */
    protected $inofevigencia = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="inOfeActiva", type="integer", nullable=true)
     */
    protected $inofeactiva = '1';

    /**
     * @var integer
     *
     * @ORM\Column(name="inOfeAbierta", type="integer", nullable=true)
     */
    protected $inofeabierta = '0';

    /**
     * @var \LbMembresias
     *
     * @ORM\ManyToOne(targetEntity="LbMembresias")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inOfeMembresia", referencedColumnName="inMembresia")
     * })
     */
    protected $inofemembresia;



    /**
     * Get inoferta
     *
     * @return integer 
     */
    public function getInoferta()
    {
        return $this->inoferta;
    }

    /**
     * Set feofefecha
     *
     * @param \DateTime $feofefecha
     * @return LbOfertas
     */
    public function setFeofefecha($feofefecha)
    {
        $this->feofefecha = $feofefecha;

        return $this;
    }

    /**
     * Get feofefecha
     *
     * @return \DateTime 
     */
    public function getFeofefecha()
    {
        return $this->feofefecha;
    }

    /**
     * Set inofevigencia
     *
     * @param integer $inofevigencia
     * @return LbOfertas
     */
    public function setInofevigencia($inofevigencia)
    {
        $this->inofevigencia = $inofevigencia;

        return $this;
    }

    /**
     * Get inofevigencia
     *
     * @return integer 
     */
    public function getInofevigencia()
    {
        return $this->inofevigencia;
    }

    /**
     * Set inofeactiva
     *
     * @param integer $inofeactiva
     * @return LbOfertas
     */
    public function setInofeactiva($inofeactiva)
    {
        $this->inofeactiva = $inofeactiva;

        return $this;
    }

    /**
     * Get inofeactiva
     *
     * @return integer 
     */
    public function getInofeactiva()
    {
        return $this->inofeactiva;
    }

    /**
     * Set inofeabierta
     *
     * @param integer $inofeabierta
     * @return LbOfertas
     */
    public function setInofeabierta($inofeabierta)
    {
        $this->inofeabierta = $inofeabierta;

        return $this;
    }

    /**
     * Get inofeabierta
     *
     * @return integer 
     */
    public function getInofeabierta()
    {
        return $this->inofeabierta;
    }

    /**
     * Set inofemembresia
     *
     * @param \Libreame\BackendBundle\Entity\LbMembresias $inofemembresia
     * @return LbOfertas
     */
    public function setInofemembresia(\Libreame\BackendBundle\Entity\LbMembresias $inofemembresia = null)
    {
        $this->inofemembresia = $inofemembresia;

        return $this;
    }

    /**
     * Get inofemembresia
     *
     * @return \Libreame\BackendBundle\Entity\LbMembresias 
     */
    public function getInofemembresia()
    {
        return $this->inofemembresia;
    }
}
