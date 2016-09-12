<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbPlanes
 *
 * @ORM\Table(name="lb_planes")
 * @ORM\Entity
 */
class LbPlanes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inPlan", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inplan;

    /**
     * @var string
     *
     * @ORM\Column(name="txPlanNombr", type="string", length=100, nullable=false)
     */
    private $txplannombr;

    /**
     * @var string
     *
     * @ORM\Column(name="txPlanDescripcion", type="text", nullable=true)
     */
    private $txplandescripcion;

    /**
     * @var integer
     *
     * @ORM\Column(name="inPlanVigente", type="integer", nullable=false)
     */
    private $inplanvigente;

    /**
     * @var integer
     *
     * @ORM\Column(name="inPlanFree", type="integer", nullable=true)
     */
    private $inplanfree;

    /**
     * @var integer
     *
     * @ORM\Column(name="inPlanDiasFree", type="integer", nullable=true)
     */
    private $inplandiasfree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fePlanCreacion", type="datetime", nullable=false)
     */
    private $feplancreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fePlanIniVigencia", type="datetime", nullable=false)
     */
    private $feplaninivigencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fePlanFinVigencia", type="datetime", nullable=true)
     */
    private $feplanfinvigencia;

    /**
     * @var integer
     *
     * @ORM\Column(name="inPlanCantEjeMes", type="integer", nullable=false)
     */
    private $inplancantejemes;


    /**
     * Get inplan
     *
     * @return integer 
     */
    public function getInplan()
    {
        return $this->inplan;
    }

    /**
     * Set txplannombr
     *
     * @param string $txplannombr
     * @return LbPlanes
     */
    public function setTxplannombr($txplannombr)
    {
        $this->txplannombr = $txplannombr;

        return $this;
    }

    /**
     * Get txplannombr
     *
     * @return string 
     */
    public function getTxplannombr()
    {
        return $this->txplannombr;
    }

    /**
     * Set txplandescripcion
     *
     * @param string $txplandescripcion
     * @return LbPlanes
     */
    public function setTxplandescripcion($txplandescripcion)
    {
        $this->txplandescripcion = $txplandescripcion;

        return $this;
    }

    /**
     * Get txplandescripcion
     *
     * @return string 
     */
    public function getTxplandescripcion()
    {
        return $this->txplandescripcion;
    }

    /**
     * Set inplanvigente
     *
     * @param integer $inplanvigente
     * @return LbPlanes
     */
    public function setInplanvigente($inplanvigente)
    {
        $this->inplanvigente = $inplanvigente;

        return $this;
    }

    /**
     * Get inplanvigente
     *
     * @return integer 
     */
    public function getInplanvigente()
    {
        return $this->inplanvigente;
    }

    /**
     * Set inplanfree
     *
     * @param integer $inplanfree
     * @return LbPlanes
     */
    public function setInplanfree($inplanfree)
    {
        $this->inplanfree = $inplanfree;

        return $this;
    }

    /**
     * Get inplanfree
     *
     * @return integer 
     */
    public function getInplanfree()
    {
        return $this->inplanfree;
    }

    /**
     * Set inplandiasfree
     *
     * @param integer $inplandiasfree
     * @return LbPlanes
     */
    public function setInplandiasfree($inplandiasfree)
    {
        $this->inplandiasfree = $inplandiasfree;

        return $this;
    }

    /**
     * Get inplandiasfree
     *
     * @return integer 
     */
    public function getInplandiasfree()
    {
        return $this->inplandiasfree;
    }

    /**
     * Set feplancreacion
     *
     * @param \DateTime $feplancreacion
     * @return LbPlanes
     */
    public function setFeplancreacion($feplancreacion)
    {
        $this->feplancreacion = $feplancreacion;

        return $this;
    }

    /**
     * Get feplancreacion
     *
     * @return \DateTime 
     */
    public function getFeplancreacion()
    {
        return $this->feplancreacion;
    }

    /**
     * Set feplaninivigencia
     *
     * @param \DateTime $feplaninivigencia
     * @return LbPlanes
     */
    public function setFeplaninivigencia($feplaninivigencia)
    {
        $this->feplaninivigencia = $feplaninivigencia;

        return $this;
    }

    /**
     * Get feplaninivigencia
     *
     * @return \DateTime 
     */
    public function getFeplaninivigencia()
    {
        return $this->feplaninivigencia;
    }

    /**
     * Set feplanfinvigencia
     *
     * @param \DateTime $feplanfinvigencia
     * @return LbPlanes
     */
    public function setFeplanfinvigencia($feplanfinvigencia)
    {
        $this->feplanfinvigencia = $feplanfinvigencia;

        return $this;
    }

    /**
     * Get feplanfinvigencia
     *
     * @return \DateTime 
     */
    public function getFeplanfinvigencia()
    {
        return $this->feplanfinvigencia;
    }
    
    
    /**
     * Set inplancantejemes
     *
     * @param integer $inplancantejemes
     * @return LbPlanes
     */
    public function setInplancantejemes($inplancantejemes)
    {
        $this->inplancantejemes = $inplancantejemes;

        return $this;
    }

    /**
     * Get inplancantejemes
     *
     * @return integer 
     */
    public function getInplancantejemes()
    {
        return $this->inplancantejemes;
    }
    
}
