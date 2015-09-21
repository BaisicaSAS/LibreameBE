<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * LbLibros
 *
 * @ORM\Table(name="lb_libros")
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
    protected $inlibro;

    /**
     * @var integer
     *
     * @ORM\Column(name="txLibTipoPublica", type="integer", nullable=false)
     */
    protected $txlibtipopublica;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibTitulo", type="string", length=200, nullable=false)
     */
    protected $txlibtitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibAutores", type="string", length=200, nullable=true)
     */
    protected $txlibautores;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibIdioma", type="string", length=45, nullable=false)
     */
    protected $txlibidioma;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibEditorial", type="string", length=100, nullable=true)
     */
    protected $txlibeditorial;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibEdicionAnio", type="string", length=10, nullable=true)
     */
    protected $txlibedicionanio;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibEdicionNum", type="string", length=10, nullable=true)
     */
    protected $txlibedicionnum;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibEdicionPais", type="string", length=100, nullable=true)
     */
    protected $txlibedicionpais;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibCodigoOfic", type="string", length=45, nullable=true)
     */
    protected $txlibcodigoofic;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibResumen", type="string", length=300, nullable=true)
     */
    protected $txlibresumen;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibTomo", type="string", length=45, nullable=true)
     */
    protected $txlibtomo;

    /**
     * @var string
     *
     * @ORM\Column(name="txLibVolumen", type="string", length=45, nullable=true)
     */
    protected $txlibvolumen;

    /**
     * @var string
     *
     * @ORM\Column(name="txPaginas", type="string", length=45, nullable=true)
     */
    protected $txpaginas;

    /**
     * @var string
     */
    private $txediciondescripcion;

    /**
     * @var string
     */
    private $txlibcodigoofic13;

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
     * Set txlibautores
     *
     * @param string $txlibautores
     * @return LbLibros
     */
    public function setTxlibautores($txlibautores)
    {
        $this->txlibautores = $txlibautores;

        return $this;
    }

    /**
     * Get txlibautores
     *
     * @return string 
     */
    public function getTxlibautores()
    {
        return $this->txlibautores;
    }

    /**
     * Set txlibidioma
     *
     * @param string $txlibidioma
     * @return LbLibros
     */
    public function setTxlibidioma($txlibidioma)
    {
        $this->txlibidioma = $txlibidioma;

        return $this;
    }

    /**
     * Get txlibidioma
     *
     * @return string 
     */
    public function getTxlibidioma()
    {
        return $this->txlibidioma;
    }

    /**
     * Set txlibeditorial
     *
     * @param string $txlibeditorial
     * @return LbLibros
     */
    public function setTxlibeditorial($txlibeditorial)
    {
        $this->txlibeditorial = $txlibeditorial;

        return $this;
    }

    /**
     * Get txlibeditorial
     *
     * @return string 
     */
    public function getTxlibeditorial()
    {
        return $this->txlibeditorial;
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
     * Set txpaginas
     *
     * @param string $txpaginas
     * @return LbLibros
     */
    public function setTxpaginas($txpaginas)
    {
        $this->txpaginas = $txpaginas;

        return $this;
    }

    /**
     * Get txpaginas
     *
     * @return string 
     */
    public function getTxpaginas()
    {
        return $this->txpaginas;
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

}
