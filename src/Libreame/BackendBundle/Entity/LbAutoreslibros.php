<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbAutoreslibros
 *
 * @ORM\Table(name="lb_autoreslibros", indexes={@ORM\Index(name="fk_table2_lb_autores1_idx", columns={"inAutLIdAutor"}), @ORM\Index(name="fk_table2_lb_libros1_idx", columns={"inAutLIdLibro"})})
 * @ORM\Entity
 */
class LbAutoreslibros
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inIdAutL", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inidautl;

    /**
     * @var \Libreame\BackendBundle\Entity\LbAutores
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbAutores")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inAutLIdAutor", referencedColumnName="inIdAutor")
     * })
     */
    private $inautlidautor;

    /**
     * @var \Libreame\BackendBundle\Entity\LbLibros
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbLibros")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inAutLIdLibro", referencedColumnName="inLibro")
     * })
     */
    private $inautlidlibro;



    /**
     * Get inidautl
     *
     * @return integer 
     */
    public function getInidautl()
    {
        return $this->inidautl;
    }

    /**
     * Set inautlidautor
     *
     * @param \Libreame\BackendBundle\Entity\LbAutores $inautlidautor
     * @return LbAutoreslibros
     */
    public function setInautlidautor(\Libreame\BackendBundle\Entity\LbAutores $inautlidautor = null)
    {
        $this->inautlidautor = $inautlidautor;

        return $this;
    }

    /**
     * Get inautlidautor
     *
     * @return \Libreame\BackendBundle\Entity\LbAutores 
     */
    public function getInautlidautor()
    {
        return $this->inautlidautor;
    }

    /**
     * Set inautlidlibro
     *
     * @param \Libreame\BackendBundle\Entity\LbLibros $inautlidlibro
     * @return LbAutoreslibros
     */
    public function setInautlidlibro(\Libreame\BackendBundle\Entity\LbLibros $inautlidlibro = null)
    {
        $this->inautlidlibro = $inautlidlibro;

        return $this;
    }

    /**
     * Get inautlidlibro
     *
     * @return \Libreame\BackendBundle\Entity\LbLibros 
     */
    public function getInautlidlibro()
    {
        return $this->inautlidlibro;
    }
}
