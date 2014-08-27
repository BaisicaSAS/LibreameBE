<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbLibros
 */
class LbLibros
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $txlibtipopublica;

    /**
     * @var string
     */
    private $txlibtitulo;

    /**
     * @var string
     */
    private $txlibautores;

    /**
     * @var string
     */
    private $txlibidioma;

    /**
     * @var string
     */
    private $txlibeditorial;

    /**
     * @var string
     */
    private $txlibedicionanio;

    /**
     * @var string
     */
    private $txlibedicionnum;

    /**
     * @var string
     */
    private $txlibedicionpais;

    /**
     * @var string
     */
    private $txlibcodigoofic;

    /**
     * @var string
     */
    private $txlibresumen;

    /**
     * @var string
     */
    private $txlibtomo;

    /**
     * @var string
     */
    private $txlibvolumen;

    /**
     * @var string
     */
    private $txpaginas;

    /**
     * @var \Libreame\BackendBundle\Entity\LbGeneros
     */
    private $inlibgenero;


    /**
     * Get inlibro
     *
     * @return integer 
     */
    public function getInlibro()
    {
        return $this->id;
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
     * Set inlibgenero
     *
     * @param \Libreame\BackendBundle\Entity\LbGeneros $inlibgenero
     * @return LbLibros
     */
    public function setInlibgenero(\Libreame\BackendBundle\Entity\LbGeneros $inlibgenero = null)
    {
        $this->inlibgenero = $inlibgenero;

        return $this;
    }

    /**
     * Get inlibgenero
     *
     * @return \Libreame\BackendBundle\Entity\LbGeneros 
     */
    public function getInlibgenero()
    {
        return $this->inlibgenero;
    }
}
