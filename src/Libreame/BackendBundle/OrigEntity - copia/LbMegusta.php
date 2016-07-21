<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbMegusta
 *
 * @ORM\Table(name="lb_megusta", indexes={@ORM\Index(name="fk_table1_lb_ejemplares1_idx", columns={"inMegEjemplar"}), @ORM\Index(name="fk_lb_megusta_lb_usuarios1_idx", columns={"inMegUsuario"})})
 * @ORM\Entity
 */
class LbMegusta
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inIDMegusta", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inidmegusta;

    /**
     * @var integer
     *
     * @ORM\Column(name="inMegMegusta", type="integer", nullable=false)
     */
    private $inmegmegusta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feMegMegusta", type="datetime", nullable=false)
     */
    private $femegmegusta;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inMegUsuario", referencedColumnName="inUsuario")
     * })
     */
    private $inmegusuario;

    /**
     * @var \Libreame\BackendBundle\Entity\LbEjemplares
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbEjemplares")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inMegEjemplar", referencedColumnName="inEjemplar")
     * })
     */
    private $inmegejemplar;



    /**
     * Get inidmegusta
     *
     * @return integer 
     */
    public function getInidmegusta()
    {
        return $this->inidmegusta;
    }

    /**
     * Set inmegmegusta
     *
     * @param integer $inmegmegusta
     * @return LbMegusta
     */
    public function setInmegmegusta($inmegmegusta)
    {
        $this->inmegmegusta = $inmegmegusta;

        return $this;
    }

    /**
     * Get inmegmegusta
     *
     * @return integer 
     */
    public function getInmegmegusta()
    {
        return $this->inmegmegusta;
    }

    /**
     * Set femegmegusta
     *
     * @param \DateTime $femegmegusta
     * @return LbMegusta
     */
    public function setFemegmegusta($femegmegusta)
    {
        $this->femegmegusta = $femegmegusta;

        return $this;
    }

    /**
     * Get femegmegusta
     *
     * @return \DateTime 
     */
    public function getFemegmegusta()
    {
        return $this->femegmegusta;
    }

    /**
     * Set inmegusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inmegusuario
     * @return LbMegusta
     */
    public function setInmegusuario(\Libreame\BackendBundle\Entity\LbUsuarios $inmegusuario = null)
    {
        $this->inmegusuario = $inmegusuario;

        return $this;
    }

    /**
     * Get inmegusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInmegusuario()
    {
        return $this->inmegusuario;
    }

    /**
     * Set inmegejemplar
     *
     * @param \Libreame\BackendBundle\Entity\LbEjemplares $inmegejemplar
     * @return LbMegusta
     */
    public function setInmegejemplar(\Libreame\BackendBundle\Entity\LbEjemplares $inmegejemplar = null)
    {
        $this->inmegejemplar = $inmegejemplar;

        return $this;
    }

    /**
     * Get inmegejemplar
     *
     * @return \Libreame\BackendBundle\Entity\LbEjemplares 
     */
    public function getInmegejemplar()
    {
        return $this->inmegejemplar;
    }
}
