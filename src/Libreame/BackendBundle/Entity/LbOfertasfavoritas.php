<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbOfertasfavoritas
 *
 * @ORM\Table(name="lb_ofertasfavoritas", indexes={@ORM\Index(name="fk_lb_ofertasfavoritas_lb_usuarios1_idx", columns={"inFavUsuario"}), @ORM\Index(name="fk_lb_ofertasfavoritas_lb_ofertas1_idx", columns={"inFavOferta"})})
 * @ORM\Entity
 */
class LbOfertasfavoritas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inOfertaFavorita", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $inofertafavorita;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feFavFecha", type="datetime", nullable=false)
     */
    protected $fefavfecha;

    /**
     * @var \Libreame\BackendBundle\Entity\LbOfertas
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbOfertas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inFavOferta", referencedColumnName="inOferta")
     * })
     */
    protected $infavoferta;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inFavUsuario", referencedColumnName="inUsuario")
     * })
     */
    protected $infavusuario;



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
}
