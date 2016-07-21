<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbEditorialeslibros
 *
 * @ORM\Table(name="lb_editorialeslibros", indexes={@ORM\Index(name="fk_table1_lb_libros_idx", columns={"inEdiLibLibro"}), @ORM\Index(name="fk_table1_lb_editoriales1_idx", columns={"inEdiLibroEditorial"})})
 * @ORM\Entity
 */
class LbEditorialeslibros
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inEdiLId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inedilid;

    /**
     * @var \Libreame\BackendBundle\Entity\LbEditoriales
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbEditoriales")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inEdiLibroEditorial", referencedColumnName="inIdEditorial")
     * })
     */
    private $inedilibroeditorial;

    /**
     * @var \Libreame\BackendBundle\Entity\LbLibros
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbLibros")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inEdiLibLibro", referencedColumnName="inLibro")
     * })
     */
    private $inediliblibro;



    /**
     * Get inedilid
     *
     * @return integer 
     */
    public function getInedilid()
    {
        return $this->inedilid;
    }

    /**
     * Set inedilibroeditorial
     *
     * @param \Libreame\BackendBundle\Entity\LbEditoriales $inedilibroeditorial
     * @return LbEditorialeslibros
     */
    public function setInedilibroeditorial(\Libreame\BackendBundle\Entity\LbEditoriales $inedilibroeditorial = null)
    {
        $this->inedilibroeditorial = $inedilibroeditorial;

        return $this;
    }

    /**
     * Get inedilibroeditorial
     *
     * @return \Libreame\BackendBundle\Entity\LbEditoriales 
     */
    public function getInedilibroeditorial()
    {
        return $this->inedilibroeditorial;
    }

    /**
     * Set inediliblibro
     *
     * @param \Libreame\BackendBundle\Entity\LbLibros $inediliblibro
     * @return LbEditorialeslibros
     */
    public function setInediliblibro(\Libreame\BackendBundle\Entity\LbLibros $inediliblibro = null)
    {
        $this->inediliblibro = $inediliblibro;

        return $this;
    }

    /**
     * Get inediliblibro
     *
     * @return \Libreame\BackendBundle\Entity\LbLibros 
     */
    public function getInediliblibro()
    {
        return $this->inediliblibro;
    }
}
