<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbOfertasfavoritas
 */
class LbOfertasfavoritas
{
    /**
     * @var integer
     */
    private $inofertafavorita;

    /**
     * @var \DateTime
     */
    private $fefavfecha;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     */
    private $infavusuario;

    /**
     * @var \Libreame\BackendBundle\Entity\LbOfertas
     */
    private $infavoferta;


    /**
     * Get inofertafavorita
     *
     * @return integer 
     */
    public function getInofertafavorita()
    {
        return $this->inofertafavorita;
    }

    /**
     * Set fefavfecha
     *
     * @param \DateTime $fefavfecha
     * @return LbOfertasfavoritas
     */
    public function setFefavfecha($fefavfecha)
    {
        $this->fefavfecha = $fefavfecha;

        return $this;
    }

    /**
     * Get fefavfecha
     *
     * @return \DateTime 
     */
    public function getFefavfecha()
    {
        return $this->fefavfecha;
    }

    /**
     * Set infavusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $infavusuario
     * @return LbOfertasfavoritas
     */
    public function setInfavusuario(\Libreame\BackendBundle\Entity\LbUsuarios $infavusuario = null)
    {
        $this->infavusuario = $infavusuario;

        return $this;
    }

    /**
     * Get infavusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInfavusuario()
    {
        return $this->infavusuario;
    }

    /**
     * Set infavoferta
     *
     * @param \Libreame\BackendBundle\Entity\LbOfertas $infavoferta
     * @return LbOfertasfavoritas
     */
    public function setInfavoferta(\Libreame\BackendBundle\Entity\LbOfertas $infavoferta = null)
    {
        $this->infavoferta = $infavoferta;

        return $this;
    }

    /**
     * Get infavoferta
     *
     * @return \Libreame\BackendBundle\Entity\LbOfertas 
     */
    public function getInfavoferta()
    {
        return $this->infavoferta;
    }
}
