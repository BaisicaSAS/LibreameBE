<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbPlanesusuarios
 *
 * @ORM\Table(name="lb_planesusuarios", indexes={@ORM\Index(name="fk_table1_lb_usuarios1_idx", columns={"inUsuPlan"}), @ORM\Index(name="fk_lb_planesusuarios_lb_planes1_idx", columns={"inPlUsPlanes"})})
 * @ORM\Entity
 */
class LbPlanesusuarios
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inPlanUsuario", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inplanusuario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fePlUsInicio", type="datetime", nullable=false)
     */
    private $feplusinicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fePlUsFin", type="datetime", nullable=false)
     */
    private $feplusfin;

    /**
     * @var \Libreame\BackendBundle\Entity\LbPlanes
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbPlanes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inPlUsPlanes", referencedColumnName="inPlan")
     * })
     */
    private $inplusplanes;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inUsuPlan", referencedColumnName="inUsuario")
     * })
     */
    private $inusuplan;



    /**
     * Get inplanusuario
     *
     * @return integer 
     */
    public function getInplanusuario()
    {
        return $this->inplanusuario;
    }

    /**
     * Set feplusinicio
     *
     * @param \DateTime $feplusinicio
     * @return LbPlanesusuarios
     */
    public function setFeplusinicio($feplusinicio)
    {
        $this->feplusinicio = $feplusinicio;

        return $this;
    }

    /**
     * Get feplusinicio
     *
     * @return \DateTime 
     */
    public function getFeplusinicio()
    {
        return $this->feplusinicio;
    }

    /**
     * Set feplusfin
     *
     * @param \DateTime $feplusfin
     * @return LbPlanesusuarios
     */
    public function setFeplusfin($feplusfin)
    {
        $this->feplusfin = $feplusfin;

        return $this;
    }

    /**
     * Get feplusfin
     *
     * @return \DateTime 
     */
    public function getFeplusfin()
    {
        return $this->feplusfin;
    }

    /**
     * Set inplusplanes
     *
     * @param \Libreame\BackendBundle\Entity\LbPlanes $inplusplanes
     * @return LbPlanesusuarios
     */
    public function setInplusplanes(\Libreame\BackendBundle\Entity\LbPlanes $inplusplanes = null)
    {
        $this->inplusplanes = $inplusplanes;

        return $this;
    }

    /**
     * Get inplusplanes
     *
     * @return \Libreame\BackendBundle\Entity\LbPlanes 
     */
    public function getInplusplanes()
    {
        return $this->inplusplanes;
    }

    /**
     * Set inusuplan
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inusuplan
     * @return LbPlanesusuarios
     */
    public function setInusuplan(\Libreame\BackendBundle\Entity\LbUsuarios $inusuplan = null)
    {
        $this->inusuplan = $inusuplan;

        return $this;
    }

    /**
     * Get inusuplan
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInusuplan()
    {
        return $this->inusuplan;
    }
}
