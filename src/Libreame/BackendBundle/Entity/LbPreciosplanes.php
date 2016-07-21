<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbPreciosplanes
 *
 * @ORM\Table(name="lb_preciosplanes", indexes={@ORM\Index(name="fk_lb_preciosplanes_lb_planes1_idx", columns={"inIdPrePIdPlan"})})
 * @ORM\Entity
 */
class LbPreciosplanes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inIdPrePId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inidprepid;

    /**
     * @var string
     *
     * @ORM\Column(name="dbPrePPrecioplanMes", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $dbprepprecioplanmes;

    /**
     * @var string
     *
     * @ORM\Column(name="dbPrePPrecioplanAnio", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $dbprepprecioplananio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fePrePInicioVigencia", type="datetime", nullable=false)
     */
    private $feprepiniciovigencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fePrePFinVigencia", type="datetime", nullable=false)
     */
    private $feprepfinvigencia;

    /**
     * @var \Libreame\BackendBundle\Entity\LbPlanes
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbPlanes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inIdPrePIdPlan", referencedColumnName="inPlan")
     * })
     */
    private $inidprepidplan;



    /**
     * Get inidprepid
     *
     * @return integer 
     */
    public function getInidprepid()
    {
        return $this->inidprepid;
    }

    /**
     * Set dbprepprecioplanmes
     *
     * @param string $dbprepprecioplanmes
     * @return LbPreciosplanes
     */
    public function setDbprepprecioplanmes($dbprepprecioplanmes)
    {
        $this->dbprepprecioplanmes = $dbprepprecioplanmes;

        return $this;
    }

    /**
     * Get dbprepprecioplanmes
     *
     * @return string 
     */
    public function getDbprepprecioplanmes()
    {
        return $this->dbprepprecioplanmes;
    }

    /**
     * Set dbprepprecioplananio
     *
     * @param string $dbprepprecioplananio
     * @return LbPreciosplanes
     */
    public function setDbprepprecioplananio($dbprepprecioplananio)
    {
        $this->dbprepprecioplananio = $dbprepprecioplananio;

        return $this;
    }

    /**
     * Get dbprepprecioplananio
     *
     * @return string 
     */
    public function getDbprepprecioplananio()
    {
        return $this->dbprepprecioplananio;
    }

    /**
     * Set feprepiniciovigencia
     *
     * @param \DateTime $feprepiniciovigencia
     * @return LbPreciosplanes
     */
    public function setFeprepiniciovigencia($feprepiniciovigencia)
    {
        $this->feprepiniciovigencia = $feprepiniciovigencia;

        return $this;
    }

    /**
     * Get feprepiniciovigencia
     *
     * @return \DateTime 
     */
    public function getFeprepiniciovigencia()
    {
        return $this->feprepiniciovigencia;
    }

    /**
     * Set feprepfinvigencia
     *
     * @param \DateTime $feprepfinvigencia
     * @return LbPreciosplanes
     */
    public function setFeprepfinvigencia($feprepfinvigencia)
    {
        $this->feprepfinvigencia = $feprepfinvigencia;

        return $this;
    }

    /**
     * Get feprepfinvigencia
     *
     * @return \DateTime 
     */
    public function getFeprepfinvigencia()
    {
        return $this->feprepfinvigencia;
    }

    /**
     * Set inidprepidplan
     *
     * @param \Libreame\BackendBundle\Entity\LbPlanes $inidprepidplan
     * @return LbPreciosplanes
     */
    public function setInidprepidplan(\Libreame\BackendBundle\Entity\LbPlanes $inidprepidplan = null)
    {
        $this->inidprepidplan = $inidprepidplan;

        return $this;
    }

    /**
     * Get inidprepidplan
     *
     * @return \Libreame\BackendBundle\Entity\LbPlanes 
     */
    public function getInidprepidplan()
    {
        return $this->inidprepidplan;
    }
}
