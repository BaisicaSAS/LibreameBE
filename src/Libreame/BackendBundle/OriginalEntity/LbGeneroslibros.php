<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbGeneroslibros
 *
 * @ORM\Table(name="lb_generoslibros", indexes={@ORM\Index(name="fk_lb_generosejemplares_lb_generos1_idx", columns={"inGLiGenero"}), @ORM\Index(name="fk_lb_generosejemplares_lb_libros1_idx", columns={"inGLiLibro"})})
 * @ORM\Entity
 */
class LbGeneroslibros
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inGeneroLibro", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ingenerolibro;

    /**
     * @var \Libreame\BackendBundle\Entity\LbGeneros
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbGeneros")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inGLiGenero", referencedColumnName="inGenero")
     * })
     */
    private $ingligenero;

    /**
     * @var \Libreame\BackendBundle\Entity\LbLibros
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbLibros")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inGLiLibro", referencedColumnName="inLibro")
     * })
     */
    private $inglilibro;



    /**
     * Get ingenerolibro
     *
     * @return integer 
     */
    public function getIngenerolibro()
    {
        return $this->ingenerolibro;
    }

    /**
     * Set ingligenero
     *
     * @param \Libreame\BackendBundle\Entity\LbGeneros $ingligenero
     * @return LbGeneroslibros
     */
    public function setIngligenero(\Libreame\BackendBundle\Entity\LbGeneros $ingligenero = null)
    {
        $this->ingligenero = $ingligenero;

        return $this;
    }

    /**
     * Get ingligenero
     *
     * @return \Libreame\BackendBundle\Entity\LbGeneros 
     */
    public function getIngligenero()
    {
        return $this->ingligenero;
    }

    /**
     * Set inglilibro
     *
     * @param \Libreame\BackendBundle\Entity\LbLibros $inglilibro
     * @return LbGeneroslibros
     */
    public function setInglilibro(\Libreame\BackendBundle\Entity\LbLibros $inglilibro = null)
    {
        $this->inglilibro = $inglilibro;

        return $this;
    }

    /**
     * Get inglilibro
     *
     * @return \Libreame\BackendBundle\Entity\LbLibros 
     */
    public function getInglilibro()
    {
        return $this->inglilibro;
    }
}
