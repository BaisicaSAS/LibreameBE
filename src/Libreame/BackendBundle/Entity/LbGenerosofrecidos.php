<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbGenerosofrecidos
 */
class LbGenerosofrecidos
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Libreame\BackendBundle\Entity\LbGeneros
     */
    private $ingofgenero;

    /**
     * @var \Libreame\BackendBundle\Entity\LbOfrecidos
     */
    private $ingofofrecido;


    /**
     * Get ingeneroofrecido
     *
     * @return integer 
     */
    public function getIngeneroofrecido()
    {
        return $this->id;
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
