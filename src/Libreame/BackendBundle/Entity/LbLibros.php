<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbLibros
 *
 * @ORM\Table(name="lb_libros", indexes={@ORM\Index(name="idx_tipopublica", columns={"txLibTipoPublica"}), @ORM\Index(name="idx_titulo", columns={"txLibTitulo"}), @ORM\Index(name="idx_ISBN10", columns={"txLibCodigoOfic"}), @ORM\Index(name="idx_ISBN13", columns={"txLibCodigoOfic13"}), @ORM\Index(name="fk_lb_libros_lb_titulos1_idx", columns={"inLibTitTitulo"}), @ORM\Index(name="fk_lb_libros_lb_idiomas1_idx", columns={"inLibIdioma"}), @ORM\Index(name="indextxLibTitulo", columns={"txLibTitulo", "txLibEdicionPais", "txEdicionDescripcion", "txLibCodigoOfic", "txLibCodigoOfic13", "txLibResumen", "txLibVolumen"})})
 * @ORM\Entity
 */
class LbLibros
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inLibro", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inlibro;

    /**
     * @var integer
     *
     * @ORM\Column(name="txLibTipoPublica", type="integer", nullable=false)
     */
    private $txlibtipopublica;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibTitulo", type="string", length=200, nullable=false)
     */
    private $txlibtitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibEdicionAnio", type="string", length=10, nullable=true)
     */
    private $txlibedicionanio;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibEdicionNum", type="string", length=10, nullable=true)
     */
    private $txlibedicionnum;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibEdicionPais", type="string", length=100, nullable=true)
     */
    private $txlibedicionpais;

    /**
     * @var string
     *
     * @ORM\Column(name="txEdicionDescripcion", type="string", length=45, nullable=true)
     */
    private $txediciondescripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibCodigoOfic", type="string", length=45, nullable=true)
     */
    private $txlibcodigoofic;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibCodigoOfic13", type="string", length=45, nullable=true)
     */
    private $txlibcodigoofic13;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibResumen", type="text", nullable=true)
     */
    private $txlibresumen;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibTomo", type="string", length=45, nullable=true)
     */
    private $txlibtomo;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibVolumen", type="string", length=45, nullable=true)
     */
    private $txlibvolumen;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibPaginas", type="string", length=45, nullable=true)
     */
    private $txlibpaginas;

    /**
     * @var \Libreame\BackendBundle\Entity\LbIdiomas
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbIdiomas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inLibIdioma", referencedColumnName="inIdIdioma")
     * })
     */
    private $inlibidioma;

    /**
     * @var \Libreame\BackendBundle\Entity\LbTitulos
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbTitulos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inLibTitTitulo", referencedColumnName="inIdTitulo")
     * })
     */
    private $inlibtittitulo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Libreame\BackendBundle\Entity\LbAutores", mappedBy="lbLibrosInlibro")
     */
    private $lbAutoresInidautor;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Libreame\BackendBundle\Entity\LbEditoriales", inversedBy="inediliblibro")
     * @ORM\JoinTable(name="lb_editorialeslibros",
     *   joinColumns={
     *     @ORM\JoinColumn(name="inEdiLibLibro", referencedColumnName="inLibro")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="inEdiLibroEditorial", referencedColumnName="inIdEditorial")
     *   }
     * )
     */
    private $inedilibroeditorial;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lbAutoresInidautor = new \Doctrine\Common\Collections\ArrayCollection();
        $this->inedilibroeditorial = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get inlibro
     *
     * @return integer 
     */
    public function getInlibro()
    {
        return $this->inlibro;
    }

    /**
     * Set txlibtipopublica
     *
     * @param integer $txlibtipopublica
     * @return LbLibros
     */
    public function setTxlibtipopublica($txlibtipopublica)
    {
        $this->txlibtipopublica = $txlibtipopublica;

        return $this;
    }

    /**
     * Get txlibtipopublica
     *
     * @return integer 
     */
    public function getTxlibtipopublica()
    {
        return $this->txlibtipopublica;
    }

    /**
     * Set txlibtitulo
     *
     * @param string $txlibtitulo
     * @return LbLibros
     */
    public function setTxlibtitulo($txlibtitulo)
    {
        $this->txlibtitulo = $txlibtitulo;

        return $this;
    }

    /**
     * Get txlibtitulo
     *
     * @return string 
     */
    public function getTxlibtitulo()
    {
        return $this->txlibtitulo;
    }

    /**
     * Set txlibedicionanio
     *
     * @param string $txlibedicionanio
     * @return LbLibros
     */
    public function setTxlibedicionanio($txlibedicionanio)
    {
        $this->txlibedicionanio = $txlibedicionanio;

        return $this;
    }

    /**
     * Get txlibedicionanio
     *
     * @return string 
     */
    public function getTxlibedicionanio()
    {
        return $this->txlibedicionanio;
    }

    /**
     * Set txlibedicionnum
     *
     * @param string $txlibedicionnum
     * @return LbLibros
     */
    public function setTxlibedicionnum($txlibedicionnum)
    {
        $this->txlibedicionnum = $txlibedicionnum;

        return $this;
    }

    /**
     * Get txlibedicionnum
     *
     * @return string 
     */
    public function getTxlibedicionnum()
    {
        return $this->txlibedicionnum;
    }

    /**
     * Set txlibedicionpais
     *
     * @param string $txlibedicionpais
     * @return LbLibros
     */
    public function setTxlibedicionpais($txlibedicionpais)
    {
        $this->txlibedicionpais = $txlibedicionpais;

        return $this;
    }

    /**
     * Get txlibedicionpais
     *
     * @return string 
     */
    public function getTxlibedicionpais()
    {
        return $this->txlibedicionpais;
    }

    /**
     * Set txediciondescripcion
     *
     * @param string $txediciondescripcion
     * @return LbLibros
     */
    public function setTxediciondescripcion($txediciondescripcion)
    {
        $this->txediciondescripcion = $txediciondescripcion;

        return $this;
    }

    /**
     * Get txediciondescripcion
     *
     * @return string 
     */
    public function getTxediciondescripcion()
    {
        return $this->txediciondescripcion;
    }

    /**
     * Set txlibcodigoofic
     *
     * @param string $txlibcodigoofic
     * @return LbLibros
     */
    public function setTxlibcodigoofic($txlibcodigoofic)
    {
        $this->txlibcodigoofic = $txlibcodigoofic;

        return $this;
    }

    /**
     * Get txlibcodigoofic
     *
     * @return string 
     */
    public function getTxlibcodigoofic()
    {
        return $this->txlibcodigoofic;
    }

    /**
     * Set txlibcodigoofic13
     *
     * @param string $txlibcodigoofic13
     * @return LbLibros
     */
    public function setTxlibcodigoofic13($txlibcodigoofic13)
    {
        $this->txlibcodigoofic13 = $txlibcodigoofic13;

        return $this;
    }

    /**
     * Get txlibcodigoofic13
     *
     * @return string 
     */
    public function getTxlibcodigoofic13()
    {
        return $this->txlibcodigoofic13;
    }

    /**
     * Set txlibresumen
     *
     * @param string $txlibresumen
     * @return LbLibros
     */
    public function setTxlibresumen($txlibresumen)
    {
        $this->txlibresumen = $txlibresumen;

        return $this;
    }

    /**
     * Get txlibresumen
     *
     * @return string 
     */
    public function getTxlibresumen()
    {
        return $this->txlibresumen;
    }

    /**
     * Set txlibtomo
     *
     * @param string $txlibtomo
     * @return LbLibros
     */
    public function setTxlibtomo($txlibtomo)
    {
        $this->txlibtomo = $txlibtomo;

        return $this;
    }

    /**
     * Get txlibtomo
     *
     * @return string 
     */
    public function getTxlibtomo()
    {
        return $this->txlibtomo;
    }

    /**
     * Set txlibvolumen
     *
     * @param string $txlibvolumen
     * @return LbLibros
     */
    public function setTxlibvolumen($txlibvolumen)
    {
        $this->txlibvolumen = $txlibvolumen;

        return $this;
    }

    /**
     * Get txlibvolumen
     *
     * @return string 
     */
    public function getTxlibvolumen()
    {
        return $this->txlibvolumen;
    }

    /**
     * Set txlibpaginas
     *
     * @param string $txlibpaginas
     * @return LbLibros
     */
    public function setTxlibpaginas($txlibpaginas)
    {
        $this->txlibpaginas = $txlibpaginas;

        return $this;
    }

    /**
     * Get txlibpaginas
     *
     * @return string 
     */
    public function getTxlibpaginas()
    {
        return $this->txlibpaginas;
    }

    /**
     * Set inlibidioma
     *
     * @param \Libreame\BackendBundle\Entity\LbIdiomas $inlibidioma
     * @return LbLibros
     */
    public function setInlibidioma(\Libreame\BackendBundle\Entity\LbIdiomas $inlibidioma = null)
    {
        $this->inlibidioma = $inlibidioma;

        return $this;
    }

    /**
     * Get inlibidioma
     *
     * @return \Libreame\BackendBundle\Entity\LbIdiomas 
     */
    public function getInlibidioma()
    {
        return $this->inlibidioma;
    }

    /**
     * Set inlibtittitulo
     *
     * @param \Libreame\BackendBundle\Entity\LbTitulos $inlibtittitulo
     * @return LbLibros
     */
    public function setInlibtittitulo(\Libreame\BackendBundle\Entity\LbTitulos $inlibtittitulo = null)
    {
        $this->inlibtittitulo = $inlibtittitulo;

        return $this;
    }

    /**
     * Get inlibtittitulo
     *
     * @return \Libreame\BackendBundle\Entity\LbTitulos 
     */
    public function getInlibtittitulo()
    {
        return $this->inlibtittitulo;
    }

    /**
     * Add lbAutoresInidautor
     *
     * @param \Libreame\BackendBundle\Entity\LbAutores $lbAutoresInidautor
     * @return LbLibros
     */
    public function addLbAutoresInidautor(\Libreame\BackendBundle\Entity\LbAutores $lbAutoresInidautor)
    {
        $this->lbAutoresInidautor[] = $lbAutoresInidautor;

        return $this;
    }

    /**
     * Remove lbAutoresInidautor
     *
     * @param \Libreame\BackendBundle\Entity\LbAutores $lbAutoresInidautor
     */
    public function removeLbAutoresInidautor(\Libreame\BackendBundle\Entity\LbAutores $lbAutoresInidautor)
    {
        $this->lbAutoresInidautor->removeElement($lbAutoresInidautor);
    }

    /**
     * Get lbAutoresInidautor
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLbAutoresInidautor()
    {
        return $this->lbAutoresInidautor;
    }

    /**
     * Add inedilibroeditorial
     *
     * @param \Libreame\BackendBundle\Entity\LbEditoriales $inedilibroeditorial
     * @return LbLibros
     */
    public function addInedilibroeditorial(\Libreame\BackendBundle\Entity\LbEditoriales $inedilibroeditorial)
    {
        $this->inedilibroeditorial[] = $inedilibroeditorial;

        return $this;
    }

    /**
     * Remove inedilibroeditorial
     *
     * @param \Libreame\BackendBundle\Entity\LbEditoriales $inedilibroeditorial
     */
    public function removeInedilibroeditorial(\Libreame\BackendBundle\Entity\LbEditoriales $inedilibroeditorial)
    {
        $this->inedilibroeditorial->removeElement($inedilibroeditorial);
    }

    /**
     * Get inedilibroeditorial
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInedilibroeditorial()
    {
        return $this->inedilibroeditorial;
    }
}
