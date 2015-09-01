<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbGenerosofrecidos
 *
 * @ORM\Table(name="lb_generosofrecidos", indexes={@ORM\Index(name="fk_lb_generosofrecidos_lb_generos1_idx", columns={"inGOfGenero"}), @ORM\Index(name="fk_lb_generosofrecidos_lb_ofrecidos1_idx", columns={"inGOfOfrecido"})})
 * @ORM\Entity
 */
class LbGenerosofrecidos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inGeneroOfrecido", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ingeneroofrecido;

    /**
     * @var \Libreame\BackendBundle\Entity\LbGeneros
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbGeneros")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inGOfGenero", referencedColumnName="inGenero")
     * })
     */
    private $ingofgenero;

    /**
     * @var \Libreame\BackendBundle\Entity\LbOfrecidos
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbOfrecidos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inGOfOfrecido", referencedColumnName="inOfrecido")
     * })
     */
    private $ingofofrecido;



    /**
     * Get ingeneroofrecido
     *
     * @return integer 
     */
    public function getIngeneroofrecido()
    {
        return $this->ingeneroofrecido;
    }

    /**
     * Set ingofgenero
     *
     * @param \Libreame\BackendBundle\Entity\LbGeneros $ingofgenero
     * @return LbGenerosofrecidos
     */
    public function setIngofgenero(\Libreame\BackendBundle\Entity\LbGeneros $ingofgenero = null)
    {
        $this->ingofgenero = $ingofgenero;

        return $this;
    }

    /**
     * Get ingofgenero
     *
     * @return \Libreame\BackendBundle\Entity\LbGeneros 
     */
    public function getIngofgenero()
    {
        return $this->ingofgenero;
    }

    /**
     * Set ingofofrecido
     *
     * @param \Libreame\BackendBundle\Entity\LbOfrecidos $ingofofrecido
     * @return LbGenerosofrecidos
     */
    public function setIngofofrecido(\Libreame\BackendBundle\Entity\LbOfrecidos $ingofofrecido = null)
    {
        $this->ingofofrecido = $ingofofrecido;

        return $this;
    }

    /**
     * Get ingofofrecido
     *
     * @return \Libreame\BackendBundle\Entity\LbOfrecidos 
     */
    public function getIngofofrecido()
    {
        return $this->ingofofrecido;
    }
}
