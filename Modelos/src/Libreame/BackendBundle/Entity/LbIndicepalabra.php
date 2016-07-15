<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbIndicepalabra
 *
 * @ORM\Table(name="lb_indicepalabra", indexes={@ORM\Index(name="fk_lb_indicepalabra_lb_libros1_idx", columns={"lbIndPalLibro"}), @ORM\Index(name="idx_palabra", columns={"lbIndPalPalabra"}), @ORM\Index(name="idx_palabraidioma", columns={"lbIndPalPalabra", "lbIndPalIdioma"}), @ORM\Index(name="idx_idiomapalabra", columns={"lbIndPalIdioma", "lbIndPalPalabra"})})
 * @ORM\Entity
 */
class LbIndicepalabra
{
    /**
     * @var integer
     *
     * @ORM\Column(name="lbIndPalId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $lbindpalid;

    /**
     * @var string
     *
     * @ORM\Column(name="lbIndPalPalabra", type="string", length=100, nullable=false)
     */
    protected $lbindpalpalabra;

    /**
     * @var string
     *
     * @ORM\Column(name="lbIndPalIdioma", type="string", length=45, nullable=false)
     */
    protected $lbindpalidioma;

    /**
     * @var \LbLibros
     *
     * @ORM\ManyToOne(targetEntity="LbLibros")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lbIndPalLibro", referencedColumnName="inLibro")
     * })
     */
    protected $lbindpallibro;



    /**
     * Get lbindpalid
     *
     * @return integer 
     */
    public function getLbindpalid()
    {
        return $this->lbindpalid;
    }

    /**
     * Set lbindpalpalabra
     *
     * @param string $lbindpalpalabra
     * @return LbIndicepalabra
     */
    public function setLbindpalpalabra($lbindpalpalabra)
    {
        $this->lbindpalpalabra = $lbindpalpalabra;

        return $this;
    }

    /**
     * Get lbindpalpalabra
     *
     * @return string 
     */
    public function getLbindpalpalabra()
    {
        return $this->lbindpalpalabra;
    }

    /**
     * Set lbindpalidioma
     *
     * @param string $lbindpalidioma
     * @return LbIndicepalabra
     */
    public function setLbindpalidioma($lbindpalidioma)
    {
        $this->lbindpalidioma = $lbindpalidioma;

        return $this;
    }

    /**
     * Get lbindpalidioma
     *
     * @return string 
     */
    public function getLbindpalidioma()
    {
        return $this->lbindpalidioma;
    }

    /**
     * Set lbindpallibro
     *
     * @param \Libreame\BackendBundle\Entity\LbLibros $lbindpallibro
     * @return LbIndicepalabra
     */
    public function setLbindpallibro(\Libreame\BackendBundle\Entity\LbLibros $lbindpallibro = null)
    {
        $this->lbindpallibro = $lbindpallibro;

        return $this;
    }

    /**
     * Get lbindpallibro
     *
     * @return \Libreame\BackendBundle\Entity\LbLibros 
     */
    public function getLbindpallibro()
    {
        return $this->lbindpallibro;
    }
}
