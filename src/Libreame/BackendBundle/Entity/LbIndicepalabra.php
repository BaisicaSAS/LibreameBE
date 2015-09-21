<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbIndicepalabra
 */
class LbIndicepalabra
{
    /**
     * @var integer
     */
    private $lbindpalid;

    /**
     * @var string
     */
    private $lbindpalpalabra;

    /**
     * @var string
     */
    private $lbindpalidioma;

    /**
     * @var \Libreame\BackendBundle\Entity\LbLibros
     */
    private $lbindpallibro;


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
