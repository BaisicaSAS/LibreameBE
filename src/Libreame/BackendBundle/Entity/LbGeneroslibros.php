<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbGeneroslibros
 */
class LbGeneroslibros
{
    /**
     * @var integer
     */
    private $ingenerolibro;

    /**
     * @var \Libreame\BackendBundle\Entity\LbGeneros
     */
    private $ingligenero;

    /**
     * @var \Libreame\BackendBundle\Entity\LbLibros
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
