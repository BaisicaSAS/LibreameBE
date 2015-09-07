<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbGenerossolicitados
 *
 * @ORM\Table(name="lb_generossolicitados", indexes={@ORM\Index(name="fk_lb_generossolicitados_lb_generos1_idx", columns={"inSolGenero"}), @ORM\Index(name="fk_lb_generossolicitados_lb_solicitados1_idx", columns={"inSolSolicitado"})})
 * @ORM\Entity
 */
class LbGenerossolicitados
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inGeneroSolicitado", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $ingenerosolicitado;

    /**
     * @var \Libreame\BackendBundle\Entity\LbGeneros
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbGeneros")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inSolGenero", referencedColumnName="inGenero")
     * })
     */
    protected $insolgenero;

    /**
     * @var \Libreame\BackendBundle\Entity\LbSolicitados
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbSolicitados")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inSolSolicitado", referencedColumnName="IdSolicitado")
     * })
     */
    protected $insolsolicitado;



    /**
     * Get ingenerosolicitado
     *
     * @return integer 
     */
    public function getIngenerosolicitado()
    {
        return $this->ingenerosolicitado;
    }

    /**
     * Set insolgenero
     *
     * @param \Libreame\BackendBundle\Entity\LbGeneros $insolgenero
     * @return LbGenerossolicitados
     */
    public function setInsolgenero(\Libreame\BackendBundle\Entity\LbGeneros $insolgenero = null)
    {
        $this->insolgenero = $insolgenero;

        return $this;
    }

    /**
     * Get insolgenero
     *
     * @return \Libreame\BackendBundle\Entity\LbGeneros 
     */
    public function getInsolgenero()
    {
        return $this->insolgenero;
    }

    /**
     * Set insolsolicitado
     *
     * @param \Libreame\BackendBundle\Entity\LbSolicitados $insolsolicitado
     * @return LbGenerossolicitados
     */
    public function setInsolsolicitado(\Libreame\BackendBundle\Entity\LbSolicitados $insolsolicitado = null)
    {
        $this->insolsolicitado = $insolsolicitado;

        return $this;
    }

    /**
     * Get insolsolicitado
     *
     * @return \Libreame\BackendBundle\Entity\LbSolicitados 
     */
    public function getInsolsolicitado()
    {
        return $this->insolsolicitado;
    }
}
