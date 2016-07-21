<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbAutores
 *
 * @ORM\Table(name="lb_autores")
 * @ORM\Entity
 */
class LbAutores
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inIdAutor", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inidautor;

    /**
     * @var string
     *
     * @ORM\Column(name="txAutNombre", type="string", length=100, nullable=false)
     */
    private $txautnombre;

    /**
     * @var string
     *
     * @ORM\Column(name="txAutPais", type="string", length=100, nullable=true)
     */
    private $txautpais;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Libreame\BackendBundle\Entity\LbLibros", inversedBy="lbAutoresInidautor")
     * @ORM\JoinTable(name="lb_autoreslibros",
     *   joinColumns={
     *     @ORM\JoinColumn(name="lb_autores_inIdAutor", referencedColumnName="inIdAutor")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="lb_libros_inLibro", referencedColumnName="inLibro")
     *   }
     * )
     */
    private $lbLibrosInlibro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lbLibrosInlibro = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get inidautor
     *
     * @return integer 
     */
    public function getInidautor()
    {
        return $this->inidautor;
    }

    /**
     * Set txautnombre
     *
     * @param string $txautnombre
     * @return LbAutores
     */
    public function setTxautnombre($txautnombre)
    {
        $this->txautnombre = $txautnombre;

        return $this;
    }

    /**
     * Get txautnombre
     *
     * @return string 
     */
    public function getTxautnombre()
    {
        return $this->txautnombre;
    }

    /**
     * Set txautpais
     *
     * @param string $txautpais
     * @return LbAutores
     */
    public function setTxautpais($txautpais)
    {
        $this->txautpais = $txautpais;

        return $this;
    }

    /**
     * Get txautpais
     *
     * @return string 
     */
    public function getTxautpais()
    {
        return $this->txautpais;
    }

    /**
     * Add lbLibrosInlibro
     *
     * @param \Libreame\BackendBundle\Entity\LbLibros $lbLibrosInlibro
     * @return LbAutores
     */
    public function addLbLibrosInlibro(\Libreame\BackendBundle\Entity\LbLibros $lbLibrosInlibro)
    {
        $this->lbLibrosInlibro[] = $lbLibrosInlibro;

        return $this;
    }

    /**
     * Remove lbLibrosInlibro
     *
     * @param \Libreame\BackendBundle\Entity\LbLibros $lbLibrosInlibro
     */
    public function removeLbLibrosInlibro(\Libreame\BackendBundle\Entity\LbLibros $lbLibrosInlibro)
    {
        $this->lbLibrosInlibro->removeElement($lbLibrosInlibro);
    }

    /**
     * Get lbLibrosInlibro
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLbLibrosInlibro()
    {
        return $this->lbLibrosInlibro;
    }
}
