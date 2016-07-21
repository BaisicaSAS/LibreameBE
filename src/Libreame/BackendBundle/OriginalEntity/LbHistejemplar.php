<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbHistejemplar
 *
 * @ORM\Table(name="lb_histejemplar", indexes={@ORM\Index(name="fk_table1_lb_ejemplares2_idx", columns={"inHisEjeEjemplar"}), @ORM\Index(name="fk_lb_histEjemplar_lb_usuarios1_idx", columns={"inHisEjeUsuario"}), @ORM\Index(name="fk_lb_histEjemplar_lb_histEjemplar1_idx", columns={"inHisEjePadre"})})
 * @ORM\Entity
 */
class LbHistejemplar
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inHistEjemplar", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inhistejemplar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feHisEjeRegistro", type="datetime", nullable=false)
     */
    private $fehisejeregistro;

    /**
     * @var integer
     *
     * @ORM\Column(name="inHisEjeMovimiento", type="integer", nullable=false)
     */
    private $inhisejemovimiento;

    /**
     * @var integer
     *
     * @ORM\Column(name="inHisEjeModoEntrega", type="integer", nullable=true)
     */
    private $inhisejemodoentrega;

    /**
     * @var \Libreame\BackendBundle\Entity\LbHistejemplar
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbHistejemplar")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inHisEjePadre", referencedColumnName="inHistEjemplar")
     * })
     */
    private $inhisejepadre;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inHisEjeUsuario", referencedColumnName="inUsuario")
     * })
     */
    private $inhisejeusuario;

    /**
     * @var \Libreame\BackendBundle\Entity\LbEjemplares
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbEjemplares")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inHisEjeEjemplar", referencedColumnName="inEjemplar")
     * })
     */
    private $inhisejeejemplar;



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
     * Set fehisejeregistro
     *
     * @param \DateTime $fehisejeregistro
     * @return LbHistejemplar
     */
    public function setFehisejeregistro($fehisejeregistro)
    {
        $this->fehisejeregistro = $fehisejeregistro;

        return $this;
    }

    /**
     * Get fehisejeregistro
     *
     * @return \DateTime 
     */
    public function getFehisejeregistro()
    {
        return $this->fehisejeregistro;
    }

    /**
     * Set inhisejemovimiento
     *
     * @param integer $inhisejemovimiento
     * @return LbHistejemplar
     */
    public function setInhisejemovimiento($inhisejemovimiento)
    {
        $this->inhisejemovimiento = $inhisejemovimiento;

        return $this;
    }

    /**
     * Get inhisejemovimiento
     *
     * @return integer 
     */
    public function getInhisejemovimiento()
    {
        return $this->inhisejemovimiento;
    }

    /**
     * Set inhisejemodoentrega
     *
     * @param integer $inhisejemodoentrega
     * @return LbHistejemplar
     */
    public function setInhisejemodoentrega($inhisejemodoentrega)
    {
        $this->inhisejemodoentrega = $inhisejemodoentrega;

        return $this;
    }

    /**
     * Get inhisejemodoentrega
     *
     * @return integer 
     */
    public function getInhisejemodoentrega()
    {
        return $this->inhisejemodoentrega;
    }

    /**
     * Set inhisejepadre
     *
     * @param \Libreame\BackendBundle\Entity\LbHistejemplar $inhisejepadre
     * @return LbHistejemplar
     */
    public function setInhisejepadre(\Libreame\BackendBundle\Entity\LbHistejemplar $inhisejepadre = null)
    {
        $this->inhisejepadre = $inhisejepadre;

        return $this;
    }

    /**
     * Get inhisejepadre
     *
     * @return \Libreame\BackendBundle\Entity\LbHistejemplar 
     */
    public function getInhisejepadre()
    {
        return $this->inhisejepadre;
    }

    /**
     * Set inhisejeusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inhisejeusuario
     * @return LbHistejemplar
     */
    public function setInhisejeusuario(\Libreame\BackendBundle\Entity\LbUsuarios $inhisejeusuario = null)
    {
        $this->inhisejeusuario = $inhisejeusuario;

        return $this;
    }

    /**
     * Get inhisejeusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInhisejeusuario()
    {
        return $this->inhisejeusuario;
    }

    /**
     * Set inhisejeejemplar
     *
     * @param \Libreame\BackendBundle\Entity\LbEjemplares $inhisejeejemplar
     * @return LbHistejemplar
     */
    public function setInhisejeejemplar(\Libreame\BackendBundle\Entity\LbEjemplares $inhisejeejemplar = null)
    {
        $this->inhisejeejemplar = $inhisejeejemplar;

        return $this;
    }

    /**
     * Get inhisejeejemplar
     *
     * @return \Libreame\BackendBundle\Entity\LbEjemplares 
     */
    public function getInhisejeejemplar()
    {
        return $this->inhisejeejemplar;
    }
}
